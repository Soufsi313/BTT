<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberCourseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AFFICHER LE CALENDRIER PRIVÉ DE L'ADHÉRENT
    |--------------------------------------------------------------------------
    |
    | Le calendrier est entièrement dynamique.
    |
    | L'utilisateur peut consulter :
    | - le mois courant ;
    | - les mois précédents ;
    | - les mois suivants ;
    | - les années futures.
    |
    | Exemple :
    | /mon-compte/calendrier?month=1&year=2027
    |
    */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | MOIS ET ANNÉE DEMANDÉS
        |--------------------------------------------------------------------------
        |
        | Si aucun mois ou aucune année n'est fourni dans l'URL,
        | Laravel utilise automatiquement le mois et l'année actuels.
        |
        */
        $month = (int) $request->query(
            'month',
            now()->month
        );

        $year = (int) $request->query(
            'year',
            now()->year
        );


        /*
        |--------------------------------------------------------------------------
        | SÉCURISATION DU MOIS
        |--------------------------------------------------------------------------
        |
        | Un mois valide doit être compris entre 1 et 12.
        |
        | En cas de valeur incorrecte, on revient au mois actuel.
        |
        */
        if ($month < 1 || $month > 12) {
            $month = now()->month;
        }


        /*
        |--------------------------------------------------------------------------
        | SÉCURISATION DE L'ANNÉE
        |--------------------------------------------------------------------------
        |
        | On autorise ici une très large plage d'années.
        |
        | Cela évite qu'une valeur complètement incohérente soit utilisée.
        |
        */
        if ($year < 2000 || $year > 2100) {
            $year = now()->year;
        }


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DU MOIS À AFFICHER
        |--------------------------------------------------------------------------
        */
        $currentMonth = Carbon::create(
            $year,
            $month,
            1
        )->startOfMonth();


        /*
        |--------------------------------------------------------------------------
        | PREMIER ET DERNIER JOUR DU MOIS
        |--------------------------------------------------------------------------
        */
        $startOfMonth = $currentMonth
            ->copy()
            ->startOfMonth();

        $endOfMonth = $currentMonth
            ->copy()
            ->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DES COURS
        |--------------------------------------------------------------------------
        |
        | On récupère uniquement :
        | - les cours actifs ;
        | - correspondant à la catégorie homme/femme ;
        | - compris dans le mois affiché.
        |
        */
        $courses = Course::query()
            ->where('is_active', true)
            ->where('target_gender', $user->genre)
            ->whereBetween(
                'course_date',
                [
                    $startOfMonth->toDateString(),
                    $endOfMonth->toDateString(),
                ]
            )
            ->orderBy('course_date')
            ->orderBy('start_time')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | REGROUPEMENT DES COURS PAR DATE
        |--------------------------------------------------------------------------
        */
        $coursesByDate = $courses->groupBy(function ($course) {
            return $course->course_date->format('Y-m-d');
        });


        /*
        |--------------------------------------------------------------------------
        | DATE DU JOUR
        |--------------------------------------------------------------------------
        */
        $today = Carbon::today();


        /*
        |--------------------------------------------------------------------------
        | JOUR DE LA SEMAINE DU PREMIER JOUR
        |--------------------------------------------------------------------------
        |
        | 1 = lundi
        | 7 = dimanche
        |
        */
        $firstDayOfWeek = $startOfMonth->dayOfWeekIso;


        /*
        |--------------------------------------------------------------------------
        | NOMBRE DE JOURS DANS LE MOIS
        |--------------------------------------------------------------------------
        */
        $daysInMonth = $currentMonth->daysInMonth;


        /*
        |--------------------------------------------------------------------------
        | NOM DU MOIS EN FRANÇAIS
        |--------------------------------------------------------------------------
        */
        $monthName = $currentMonth
            ->locale('fr')
            ->translatedFormat('F Y');


        /*
        |--------------------------------------------------------------------------
        | MOIS PRÉCÉDENT
        |--------------------------------------------------------------------------
        |
        | Carbon gère automatiquement le changement d'année.
        |
        | Décembre 2026 → janvier 2027
        | Janvier 2027 → décembre 2026
        |
        */
        $previousMonth = $currentMonth
            ->copy()
            ->subMonth();


        /*
        |--------------------------------------------------------------------------
        | MOIS SUIVANT
        |--------------------------------------------------------------------------
        */
        $nextMonth = $currentMonth
            ->copy()
            ->addMonth();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA VUE
        |--------------------------------------------------------------------------
        */
        return view(
            'member.courses',
            [
                'currentMonth' => $currentMonth,
                'coursesByDate' => $coursesByDate,
                'today' => $today,
                'firstDayOfWeek' => $firstDayOfWeek,
                'daysInMonth' => $daysInMonth,
                'monthName' => $monthName,
                'previousMonth' => $previousMonth,
                'nextMonth' => $nextMonth,
            ]
        );
    }
}