<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminCourseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES COURS
    |--------------------------------------------------------------------------
    |
    | Cette page permet :
    |
    | - la recherche ;
    | - le filtrage par discipline ;
    | - le filtrage par catégorie ;
    | - le filtrage par statut ;
    | - l'affichage des Soft Deletes ;
    | - le tri rapide par colonne ;
    | - la détection automatique des cours terminés.
    |
    */

    public function index(Request $request): View
    {
        $admin = $request->user();


        /*
        |--------------------------------------------------------------------------
        | HEURE ACTUELLE DE BRUXELLES
        |--------------------------------------------------------------------------
        |
        | Les horaires BTT sont des horaires locaux de Bruxelles.
        |
        | Nous utilisons donc explicitement Europe/Brussels pour éviter
        | un éventuel décalage lié au fuseau UTC de Laravel.
        |
        */

        $now = now('Europe/Brussels');

        $nowSql = $now->format(
            'Y-m-d H:i:s'
        );


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE
        |--------------------------------------------------------------------------
        */

        $search = trim(
            (string) $request->query(
                'search',
                ''
            )
        );


        /*
        |--------------------------------------------------------------------------
        | DISCIPLINE
        |--------------------------------------------------------------------------
        */

        $discipline = trim(
            (string) $request->query(
                'discipline',
                'all'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | STATUT
        |--------------------------------------------------------------------------
        |
        | all       = tous
        | active    = actifs
        | inactive  = inactifs
        | completed = terminés
        | deleted   = supprimés
        |
        */

        $status = (string) $request->query(
            'status',
            'all'
        );


        if (! in_array(
            $status,
            [
                'all',
                'active',
                'inactive',
                'completed',
                'deleted',
            ],
            true
        )) {
            $status = 'all';
        }


        /*
        |--------------------------------------------------------------------------
        | COLONNE DE TRI
        |--------------------------------------------------------------------------
        */

        $sortBy = (string) $request->query(
            'sort_by',
            'date'
        );


        $allowedSorts = [
            'title',
            'date',
            'time',
            'category',
            'status',
        ];


        if (! in_array(
            $sortBy,
            $allowedSorts,
            true
        )) {
            $sortBy = 'date';
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECTION DU TRI
        |--------------------------------------------------------------------------
        */

        $direction = (string) $request->query(
            'direction',
            'desc'
        );


        if (! in_array(
            $direction,
            [
                'asc',
                'desc',
            ],
            true
        )) {
            $direction = 'desc';
        }


        /*
        |--------------------------------------------------------------------------
        | CATÉGORIE
        |--------------------------------------------------------------------------
        */

        if ($admin->isSuperAdmin()) {

            $gender = (string) $request->query(
                'gender',
                'all'
            );


            if (! in_array(
                $gender,
                [
                    'all',
                    'homme',
                    'femme',
                ],
                true
            )) {
                $gender = 'all';
            }

        } else {

            /*
            | Sécurité serveur :
            | un Admin normal reste toujours limité à sa catégorie.
            */
            $gender = $admin->genre;
        }


        /*
        |--------------------------------------------------------------------------
        | DISCIPLINES DISPONIBLES
        |--------------------------------------------------------------------------
        */

        $disciplineQuery = Course::withTrashed();


        if (! $admin->isSuperAdmin()) {

            $disciplineQuery->where(
                'target_gender',
                $admin->genre
            );
        }


        if (
            $admin->isSuperAdmin()
            && $gender !== 'all'
        ) {
            $disciplineQuery->where(
                'target_gender',
                $gender
            );
        }


        $disciplines = $disciplineQuery
            ->whereNotNull('discipline')
            ->where(
                'discipline',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy('discipline')
            ->pluck('discipline');


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE PRINCIPALE
        |--------------------------------------------------------------------------
        */

        $coursesQuery = Course::withTrashed();


        /*
        |--------------------------------------------------------------------------
        | SÉCURITÉ CATÉGORIE
        |--------------------------------------------------------------------------
        */

        if ($admin->isSuperAdmin()) {

            if ($gender !== 'all') {

                $coursesQuery->where(
                    'target_gender',
                    $gender
                );
            }

        } else {

            $coursesQuery->where(
                'target_gender',
                $admin->genre
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE TEXTE
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $coursesQuery->where(
                function ($query) use ($search) {

                    $query
                        ->where(
                            'title',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'discipline',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'description',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRE DISCIPLINE
        |--------------------------------------------------------------------------
        */

        if (
            $discipline !== ''
            && $discipline !== 'all'
        ) {
            $coursesQuery->where(
                'discipline',
                $discipline
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRE STATUT
        |--------------------------------------------------------------------------
        |
        | IMPORTANT :
        |
        | La date et l'heure de FIN déterminent si le cours est terminé.
        |
        | TIMESTAMP(course_date, end_time)
        | crée une date complète côté MySQL.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | ACTIFS
        |--------------------------------------------------------------------------
        |
        | - non supprimés
        | - activés manuellement
        | - heure de fin pas encore passée
        |
        */

        if ($status === 'active') {

            $coursesQuery
                ->whereNull('deleted_at')
                ->where(
                    'is_active',
                    true
                )
                ->whereRaw(
                    'TIMESTAMP(course_date, end_time) > ?',
                    [$nowSql]
                );


        /*
        |--------------------------------------------------------------------------
        | INACTIFS
        |--------------------------------------------------------------------------
        |
        | - non supprimés
        | - désactivés manuellement
        | - heure de fin pas encore passée
        |
        */

        } elseif ($status === 'inactive') {

            $coursesQuery
                ->whereNull('deleted_at')
                ->where(
                    'is_active',
                    false
                )
                ->whereRaw(
                    'TIMESTAMP(course_date, end_time) > ?',
                    [$nowSql]
                );


        /*
        |--------------------------------------------------------------------------
        | TERMINÉS
        |--------------------------------------------------------------------------
        |
        | Peu importe l'ancienne valeur de is_active :
        | une fois l'heure de fin passée, le cours est Terminé.
        |
        */

        } elseif ($status === 'completed') {

            $coursesQuery
                ->whereNull('deleted_at')
                ->whereRaw(
                    'TIMESTAMP(course_date, end_time) <= ?',
                    [$nowSql]
                );


        /*
        |--------------------------------------------------------------------------
        | SUPPRIMÉS
        |--------------------------------------------------------------------------
        */

        } elseif ($status === 'deleted') {

            $coursesQuery->onlyTrashed();
        }


        /*
        |--------------------------------------------------------------------------
        | TRI DU TABLEAU
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | TITRE
        |--------------------------------------------------------------------------
        */

        if ($sortBy === 'title') {

            $coursesQuery->orderBy(
                'title',
                $direction
            );


        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        } elseif ($sortBy === 'date') {

            $coursesQuery
                ->orderBy(
                    'course_date',
                    $direction
                )
                ->orderBy(
                    'start_time',
                    $direction
                );


        /*
        |--------------------------------------------------------------------------
        | HORAIRE
        |--------------------------------------------------------------------------
        */

        } elseif ($sortBy === 'time') {

            $coursesQuery
                ->orderBy(
                    'start_time',
                    $direction
                )
                ->orderBy(
                    'course_date',
                    $direction
                );


        /*
        |--------------------------------------------------------------------------
        | CATÉGORIE
        |--------------------------------------------------------------------------
        */

        } elseif ($sortBy === 'category') {

            $coursesQuery
                ->orderBy(
                    'target_gender',
                    $direction
                )
                ->orderBy(
                    'course_date',
                    'desc'
                );


        /*
        |--------------------------------------------------------------------------
        | STATUT
        |--------------------------------------------------------------------------
        |
        | Ordre logique croissant :
        |
        | 1 = Actif
        | 2 = Inactif
        | 3 = Terminé
        | 4 = Supprimé
        |
        */

        } elseif ($sortBy === 'status') {

            $coursesQuery->orderByRaw(
                "
                CASE
                    WHEN deleted_at IS NOT NULL THEN 4

                    WHEN TIMESTAMP(course_date, end_time) <= ?
                        THEN 3

                    WHEN is_active = 0
                        THEN 2

                    ELSE 1
                END {$direction}
                ",
                [$nowSql]
            );


            /*
            | À statut identique :
            | les dates les plus récentes passent en premier.
            */
            $coursesQuery->orderBy(
                'course_date',
                'desc'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ORDRE STABLE
        |--------------------------------------------------------------------------
        */

        $coursesQuery->orderBy(
            'id',
            'desc'
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $courses = $coursesQuery
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | VUE
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.courses.index',
            [
                'courses' => $courses,
                'search' => $search,
                'discipline' => $discipline,
                'disciplines' => $disciplines,
                'gender' => $gender,
                'status' => $status,
                'sortBy' => $sortBy,
                'direction' => $direction,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE D'AJOUT
    |--------------------------------------------------------------------------
    */

    public function create(Request $request): View
    {
        $admin = $request->user();

        $forcedGender = null;


        if (! $admin->isSuperAdmin()) {

            $forcedGender = $admin->genre;
        }


        return view(
            'admin.courses.create',
            [
                'forcedGender' => $forcedGender,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTREMENT D'UN NOUVEAU COURS
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        $admin = $request->user();


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $rules = [
            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'discipline' => [
                'required',
                'string',
                'max:100',
            ],

            'course_date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];


        if ($admin->isSuperAdmin()) {

            $rules['target_gender'] = [
                'required',
                Rule::in([
                    'homme',
                    'femme',
                ]),
            ];
        }


        $validated = $request->validate(
            $rules,
            $this->validationMessages()
        );


        /*
        |--------------------------------------------------------------------------
        | CATÉGORIE
        |--------------------------------------------------------------------------
        */

        if ($admin->isSuperAdmin()) {

            $targetGender =
                $validated['target_gender'];

        } else {

            $targetGender =
                $admin->genre;
        }


        /*
        |--------------------------------------------------------------------------
        | CRÉATION
        |--------------------------------------------------------------------------
        */

        Course::create([
            'title' =>
                $validated['title'],

            'discipline' =>
                $validated['discipline'],

            'course_date' =>
                $validated['course_date'],

            'start_time' =>
                $validated['start_time'],

            'end_time' =>
                $validated['end_time'],

            'target_gender' =>
                $targetGender,

            'description' =>
                $validated['description'] ?? null,

            'created_by' =>
                $admin->id,

            'is_active' =>
                $request->boolean('is_active'),
        ]);


        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Le cours a été ajouté au calendrier avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(
        Request $request,
        Course $course
    ): View {

        $admin = $request->user();


        if (! $this->canManageCourse(
            $admin,
            $course
        )) {
            abort(
                403,
                'Vous n’êtes pas autorisé à modifier ce cours.'
            );
        }


        $forcedGender = null;


        if (! $admin->isSuperAdmin()) {

            $forcedGender = $admin->genre;
        }


        return view(
            'admin.courses.edit',
            [
                'course' => $course,
                'forcedGender' => $forcedGender,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MISE À JOUR D'UN COURS
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Course $course
    ): RedirectResponse {

        $admin = $request->user();


        if (! $this->canManageCourse(
            $admin,
            $course
        )) {
            abort(
                403,
                'Vous n’êtes pas autorisé à modifier ce cours.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $rules = [
            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'discipline' => [
                'required',
                'string',
                'max:100',
            ],

            'course_date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];


        if ($admin->isSuperAdmin()) {

            $rules['target_gender'] = [
                'required',
                Rule::in([
                    'homme',
                    'femme',
                ]),
            ];
        }


        $validated = $request->validate(
            $rules,
            $this->validationMessages()
        );


        /*
        |--------------------------------------------------------------------------
        | CATÉGORIE
        |--------------------------------------------------------------------------
        */

        if ($admin->isSuperAdmin()) {

            $targetGender =
                $validated['target_gender'];

        } else {

            $targetGender =
                $admin->genre;
        }


        /*
        |--------------------------------------------------------------------------
        | MISE À JOUR
        |--------------------------------------------------------------------------
        */

        $course->update([
            'title' =>
                $validated['title'],

            'discipline' =>
                $validated['discipline'],

            'course_date' =>
                $validated['course_date'],

            'start_time' =>
                $validated['start_time'],

            'end_time' =>
                $validated['end_time'],

            'target_gender' =>
                $targetGender,

            'description' =>
                $validated['description'] ?? null,

            'is_active' =>
                $request->boolean('is_active'),
        ]);


        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Le cours a été modifié avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SOFT DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request,
        Course $course
    ): RedirectResponse {

        $admin = $request->user();


        if (! $this->canManageCourse(
            $admin,
            $course
        )) {
            abort(
                403,
                'Vous n’êtes pas autorisé à supprimer ce cours.'
            );
        }


        $course->delete();


        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Le cours a été supprimé du calendrier.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RÉACTIVATION D'UN COURS SUPPRIMÉ
    |--------------------------------------------------------------------------
    */

    public function restore(
        Request $request,
        int $id
    ): RedirectResponse {

        $admin = $request->user();


        if (! $admin->isSuperAdmin()) {

            abort(
                403,
                'Seul le Super Admin peut réactiver un cours supprimé.'
            );
        }


        $course = Course::withTrashed()
            ->findOrFail($id);


        if ($course->trashed()) {

            $course->restore();


            return redirect()
                ->route('admin.courses.index')
                ->with(
                    'success',
                    'Le cours a été réactivé avec succès.'
                );
        }


        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Ce cours est déjà actif dans la base de données.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MESSAGES DE VALIDATION
    |--------------------------------------------------------------------------
    */

    private function validationMessages(): array
    {
        return [
            'title.required' =>
                'Le titre du cours est obligatoire.',

            'discipline.required' =>
                'La discipline est obligatoire.',

            'course_date.required' =>
                'La date du cours est obligatoire.',

            'course_date.date' =>
                'La date du cours est invalide.',

            'start_time.required' =>
                'L’heure de début est obligatoire.',

            'start_time.date_format' =>
                'L’heure de début est invalide.',

            'end_time.required' =>
                'L’heure de fin est obligatoire.',

            'end_time.date_format' =>
                'L’heure de fin est invalide.',

            'end_time.after' =>
                'L’heure de fin doit être postérieure à l’heure de début.',

            'target_gender.required' =>
                'La catégorie du cours est obligatoire.',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION DES DROITS
    |--------------------------------------------------------------------------
    */

    private function canManageCourse(
        $admin,
        Course $course
    ): bool {

        if ($admin->isSuperAdmin()) {

            return true;
        }


        return $admin->isAdmin()
            && $course->target_gender === $admin->genre;
    }
}