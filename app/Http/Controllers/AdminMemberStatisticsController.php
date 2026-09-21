<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * ================================================================
 * STATISTIQUES DES ADHÉRENTS BTT
 * ================================================================
 *
 * Ce contrôleur prépare les statistiques d'inscriptions et leur
 * export au format Excel (.xlsx).
 *
 * Règles d'accès :
 * - Super Admin : tous les genres, hommes ou femmes.
 * - Admin : uniquement les adhérents de son propre genre.
 *
 * Les exports contiennent des nombres agrégés, jamais de données
 * nominatives (nom, prénom, email, etc.).
 *
 * Les statistiques sont fondées sur la date de création du compte.
 * Les comptes archivés restent inclus dans les inscriptions
 * historiques, puisqu'ils ont bien été inscrits à cette date.
 *
 * ================================================================
 */
class AdminMemberStatisticsController extends Controller
{
    /**
     * Nombre maximal de périodes générées pour une requête.
     *
     * Cette limite évite de produire un classeur excessivement
     * volumineux lorsqu'une plage de dates est très étendue.
     */
    private const MAX_PERIODS = 1500;

    /**
     * ============================================================
     * AFFICHER LES STATISTIQUES
     * ============================================================
     *
     * Cette méthode sera reliée à la vue Blade lors de l'étape
     * d'intégration des routes et de l'interface.
     */
    public function index(Request $request)
    {
        $admin = $this->authorizedAdmin($request);

        $filters = $this->validatedFilters($request, $admin);

        return view('admin.members.statistics', [
            'filters' => $filters,
            'statistics' => $this->buildStatistics(
                $admin,
                $filters
            ),
            'isSuperAdmin' => $admin->isSuperAdmin(),
        ]);
    }

    /**
     * ============================================================
     * EXPORTER LES STATISTIQUES EN EXCEL
     * ============================================================
     *
     * L'export reprend exactement les filtres de la page.
     *
     * Pour le Super Admin, le filtre "tous" produit trois onglets :
     * Tous, Hommes et Femmes.
     *
     * Pour un admin classique, un seul onglet est généré et les
     * données sont limitées à son genre.
     */
    public function export(Request $request): StreamedResponse
    {
        $admin = $this->authorizedAdmin($request);

        $filters = $this->validatedFilters($request, $admin);

        $statistics = $this->buildStatistics(
            $admin,
            $filters
        );

        $spreadsheet = new Spreadsheet();

        $groups = $this->exportGroups($admin, $filters);

        foreach ($groups as $index => $group) {
            $sheet = $index === 0
                ? $spreadsheet->getActiveSheet()
                : $spreadsheet->createSheet();

            $sheet->setTitle($group['title']);

            $this->fillWorksheet(
                $sheet,
                $statistics['groups'][$group['key']],
                $filters,
                $group['title']
            );
        }

        $spreadsheet->setActiveSheetIndex(0);

        $filename = sprintf(
            'btt-statistiques-adherents-%s-%s.xlsx',
            $filters['start_date'],
            $filters['end_date']
        );

        return response()->streamDownload(
            function () use ($spreadsheet): void {
                try {
                    $writer = new Xlsx($spreadsheet);

                    $writer->save('php://output');
                } finally {
                    $spreadsheet->disconnectWorksheets();
                }
            },
            $filename,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }

    /**
     * ============================================================
     * VÉRIFIER L'ACCÈS ADMIN
     * ============================================================
     *
     * Cette vérification est effectuée dans le contrôleur, même
     * si les routes seront également protégées par middleware.
     */
    private function authorizedAdmin(Request $request): User
    {
        $admin = $request->user();

        abort_unless(
            $admin instanceof User && $admin->canAccessAdmin(),
            403
        );

        return $admin;
    }

    /**
     * ============================================================
     * VALIDER LES FILTRES
     * ============================================================
     *
     * Périodes disponibles :
     * - day : jour ;
     * - week : semaine, du lundi au dimanche ;
     * - month : mois ;
     * - year : année.
     *
     * Les dates sont inclusives.
     *
     * Le genre transmis par un admin classique ne peut jamais
     * élargir ses droits : son propre genre est imposé côté serveur.
     */
    private function validatedFilters(
        Request $request,
        User $admin
    ): array {
        $today = CarbonImmutable::now(
            config('app.timezone')
        )->startOfDay();

        $validated = $request->validate([
            'period' => [
                'nullable',
                Rule::in(['day', 'week', 'month', 'year']),
            ],
            'start_date' => [
                'nullable',
                'date_format:Y-m-d',
            ],
            'end_date' => [
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:start_date',
            ],
            'genre' => [
                'nullable',
                Rule::in(['tous', 'homme', 'femme']),
            ],
        ]);

        $startDate = isset($validated['start_date'])
            ? CarbonImmutable::createFromFormat(
                '!Y-m-d',
                $validated['start_date'],
                config('app.timezone')
            )
            : $today->startOfYear();

        $endDate = isset($validated['end_date'])
            ? CarbonImmutable::createFromFormat(
                '!Y-m-d',
                $validated['end_date'],
                config('app.timezone')
            )
            : $today;

        abort_if(
            $startDate->greaterThan($endDate),
            422,
            'La date de début doit précéder la date de fin.'
        );

        $genre = $admin->isSuperAdmin()
            ? ($validated['genre'] ?? 'tous')
            : $admin->genre;

        abort_unless(
            $genre === 'tous'
                ? $admin->isSuperAdmin()
                : $admin->canManageGender($genre),
            403
        );

        $period = $validated['period'] ?? 'month';

        $periods = $this->makePeriods(
            $startDate,
            $endDate,
            $period
        );

        return [
            'period' => $period,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'genre' => $genre,
            'periods' => $periods,
        ];
    }

    /**
     * ============================================================
     * CONSTRUIRE LES PÉRIODES
     * ============================================================
     *
     * Chaque période contient une plage réelle de dates.
     *
     * Exemple : une sélection du 10 au 20 septembre en mode
     * "mois" ne compte que les inscriptions du 10 au 20.
     */
    private function makePeriods(
        CarbonImmutable $startDate,
        CarbonImmutable $endDate,
        string $period
    ): array {
        $cursor = match ($period) {
            'day' => $startDate,
            'week' => $startDate->startOfWeek(),
            'month' => $startDate->startOfMonth(),
            'year' => $startDate->startOfYear(),
        };

        $periods = [];

        while ($cursor->lessThanOrEqualTo($endDate)) {
            abort_if(
                count($periods) >= self::MAX_PERIODS,
                422,
                'La plage sélectionnée contient trop de périodes.'
            );

            $periodEnd = match ($period) {
                'day' => $cursor->endOfDay(),
                'week' => $cursor->endOfWeek(),
                'month' => $cursor->endOfMonth(),
                'year' => $cursor->endOfYear(),
            };

            $actualStart = $cursor->greaterThan($startDate)
                ? $cursor
                : $startDate;

            $actualEnd = $periodEnd->lessThan($endDate)
                ? $periodEnd
                : $endDate;

            $label = match ($period) {
                'day' => $cursor->format('d/m/Y'),
                'week' => sprintf(
                    '%s au %s',
                    $cursor->format('d/m/Y'),
                    $cursor->endOfWeek()->format('d/m/Y')
                ),
                'month' => $cursor->format('m/Y'),
                'year' => $cursor->format('Y'),
            };

            $periods[] = [
                'label' => $label,
                'start_date' => $actualStart->toDateString(),
                'end_date' => $actualEnd->toDateString(),
            ];

            $cursor = match ($period) {
                'day' => $cursor->addDay(),
                'week' => $cursor->addWeek(),
                'month' => $cursor->addMonth(),
                'year' => $cursor->addYear(),
            };
        }

        return $periods;
    }

    /**
     * ============================================================
     * CONSTRUIRE LES STATISTIQUES
     * ============================================================
     *
     * Nous conservons les comptes archivés dans les inscriptions
     * historiques grâce à withTrashed().
     *
     * Le rôle est filtré sur sa valeur actuelle : "adherent".
     */
    private function buildStatistics(
        User $admin,
        array $filters
    ): array {
        $groups = [];

        foreach (
            $this->exportGroups($admin, $filters) as $group
        ) {
            $groups[$group['key']] = $this->statisticsForGender(
                $admin,
                $filters,
                $group['gender']
            );
        }

        return [
            'groups' => $groups,
            'period' => $filters['period'],
            'start_date' => $filters['start_date'],
            'end_date' => $filters['end_date'],
            'genre' => $filters['genre'],
        ];
    }

    /**
     * ============================================================
     * DÉFINIR LES GROUPES AUTORISÉS
     * ============================================================
     */
    private function exportGroups(
        User $admin,
        array $filters
    ): array {
        if (
            $admin->isSuperAdmin()
            && $filters['genre'] === 'tous'
        ) {
            return [
                [
                    'key' => 'tous',
                    'title' => 'Tous',
                    'gender' => null,
                ],
                [
                    'key' => 'homme',
                    'title' => 'Hommes',
                    'gender' => 'homme',
                ],
                [
                    'key' => 'femme',
                    'title' => 'Femmes',
                    'gender' => 'femme',
                ],
            ];
        }

        $gender = $filters['genre'];

        return [
            [
                'key' => $gender,
                'title' => $gender === 'homme'
                    ? 'Hommes'
                    : 'Femmes',
                'gender' => $gender,
            ],
        ];
    }

    /**
     * ============================================================
     * CALCULER LES INSCRIPTIONS PAR GENRE
     * ============================================================
     *
     * Une requête récupère uniquement les dates de création.
     * Aucun nom, email ou autre champ personnel n'est chargé.
     *
     * Les comptes archivés sont inclus.
     */
    private function statisticsForGender(
        User $admin,
        array $filters,
        ?string $gender
    ): array {
        $query = User::withTrashed()
            ->where('role', 'adherent');

        if ($gender !== null) {
            abort_unless(
                $admin->canManageGender($gender),
                403
            );

            $query->where('genre', $gender);
        } else {
            abort_unless($admin->isSuperAdmin(), 403);
        }

        $startDate = CarbonImmutable::parse(
            $filters['start_date'],
            config('app.timezone')
        )->startOfDay();

        $endExclusive = CarbonImmutable::parse(
            $filters['end_date'],
            config('app.timezone')
        )->addDay()->startOfDay();

        $registrations = (clone $query)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endExclusive)
            ->pluck('created_at');

        $rows = [];
        $total = 0;

        foreach ($filters['periods'] as $period) {
            $periodStart = $period['start_date'];
            $periodEnd = $period['end_date'];

            $count = $registrations->filter(
                function ($createdAt) use (
                    $periodStart,
                    $periodEnd
                ): bool {
                    $date = CarbonImmutable::parse(
                        $createdAt
                    )->toDateString();

                    return $date >= $periodStart
                        && $date <= $periodEnd;
                }
            )->count();

            $rows[] = [
                'label' => $period['label'],
                'start_date' => $periodStart,
                'end_date' => $periodEnd,
                'registrations' => $count,
            ];

            $total += $count;
        }

        return [
            'rows' => $rows,
            'total_registrations' => $total,
        ];
    }

    /**
     * ============================================================
     * REMPLIR UN ONGLET EXCEL
     * ============================================================
     *
     * Les valeurs sont des statistiques agrégées.
     */
    private function fillWorksheet(
        \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet,
        array $statistics,
        array $filters,
        string $title
    ): void {
        $sheet->setCellValue(
            'A1',
            'BTT — Statistiques des inscriptions'
        );

        $sheet->setCellValue('A2', 'Groupe');
        $sheet->setCellValue('B2', $title);

        $sheet->setCellValue('A3', 'Date de début');
        $sheet->setCellValue('B3', $filters['start_date']);

        $sheet->setCellValue('A4', 'Date de fin');
        $sheet->setCellValue('B4', $filters['end_date']);

        $sheet->setCellValue('A5', 'Regroupement');
        $sheet->setCellValue(
            'B5',
            match ($filters['period']) {
                'day' => 'Jour',
                'week' => 'Semaine',
                'month' => 'Mois',
                'year' => 'Année',
            }
        );

        $sheet->fromArray(
            [
                [
                    'Période',
                    'Début',
                    'Fin',
                    'Nouvelles inscriptions',
                ],
            ],
            null,
            'A7'
        );

        $rowNumber = 8;

        foreach ($statistics['rows'] as $row) {
            $sheet->fromArray(
                [
                    [
                        $row['label'],
                        $row['start_date'],
                        $row['end_date'],
                        $row['registrations'],
                    ],
                ],
                null,
                'A' . $rowNumber
            );

            $rowNumber++;
        }

        $sheet->setCellValue(
            'A' . $rowNumber,
            'TOTAL'
        );

        $sheet->setCellValue(
            'D' . $rowNumber,
            $statistics['total_registrations']
        );

        $sheet->getStyle('A1:D1')
            ->getFont()
            ->setBold(true)
            ->setSize(15);

        $sheet->getStyle('A7:D7')
            ->getFont()
            ->setBold(true);

        $sheet->getStyle('A7:D7')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('E5E7EB');

        $sheet->getStyle(
            'A' . $rowNumber . ':D' . $rowNumber
        )->getFont()->setBold(true);

        $sheet->getStyle('D8:D' . $rowNumber)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        foreach (['A', 'B', 'C', 'D'] as $column) {
            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }

        $sheet->freezePane('A8');

        $sheet->setAutoFilter(
            'A7:D' . max(7, $rowNumber - 1)
        );
    }
}