<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminCourseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES COURS
    |--------------------------------------------------------------------------
    |
    | Cette méthode affiche tous les cours accessibles à l'administrateur.
    |
    | SUPER ADMIN :
    | - peut consulter Homme + Femme ;
    | - peut filtrer les deux catégories.
    |
    | ADMIN NORMAL :
    | - ne voit que les cours correspondant à son propre genre ;
    | - cette restriction est appliquée côté serveur.
    |
    */
    public function index(Request $request): View
    {
        $admin = $request->user();


        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DES FILTRES
        |--------------------------------------------------------------------------
        */

        $search = trim(
            (string) $request->query('search', '')
        );

        $discipline = trim(
            (string) $request->query('discipline', 'all')
        );

        $status = (string) $request->query(
            'status',
            'all'
        );

        $sort = (string) $request->query(
            'sort',
            'asc'
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDATION DU TRI
        |--------------------------------------------------------------------------
        |
        | asc  = cours les plus proches en premier
        | desc = cours les plus éloignés en premier
        |
        */

        if (! in_array($sort, ['asc', 'desc'], true)) {
            $sort = 'asc';
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION DU STATUT
        |--------------------------------------------------------------------------
        */

        if (! in_array(
            $status,
            ['all', 'active', 'inactive'],
            true
        )) {
            $status = 'all';
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRE DE CATÉGORIE
        |--------------------------------------------------------------------------
        */

        if ($admin->isSuperAdmin()) {

            $gender = (string) $request->query(
                'gender',
                'all'
            );

            if (! in_array(
                $gender,
                ['all', 'homme', 'femme'],
                true
            )) {
                $gender = 'all';
            }

        } else {

            /*
            |--------------------------------------------------------------------------
            | SÉCURITÉ ADMIN NORMAL
            |--------------------------------------------------------------------------
            |
            | Même si un administrateur modifie manuellement l'URL,
            | sa catégorie reste imposée côté serveur.
            |
            */

            $gender = $admin->genre;
        }


        /*
        |--------------------------------------------------------------------------
        | DISCIPLINES DISPONIBLES
        |--------------------------------------------------------------------------
        |
        | Les disciplines sont récupérées directement dans la base.
        |
        | Ainsi, lorsqu'une nouvelle discipline est utilisée dans un cours,
        | elle apparaît automatiquement dans le filtre.
        |
        */

        $disciplineQuery = Course::query();

        /*
        | Un administrateur normal ne doit pas voir les disciplines
        | appartenant exclusivement à l'autre catégorie.
        */
        if (! $admin->isSuperAdmin()) {
            $disciplineQuery->where(
                'target_gender',
                $admin->genre
            );
        }

        /*
        | Si le Super Admin sélectionne une catégorie,
        | les disciplines proposées correspondent également
        | à cette catégorie.
        */
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
            ->where('discipline', '!=', '')
            ->distinct()
            ->orderBy('discipline')
            ->pluck('discipline');


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE PRINCIPALE
        |--------------------------------------------------------------------------
        */

        $coursesQuery = Course::query();


        /*
        |--------------------------------------------------------------------------
        | RESTRICTION PAR CATÉGORIE
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
        |
        | Recherche dans :
        | - titre
        | - discipline
        | - description
        |
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
        | FILTRE PAR DISCIPLINE
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
        | FILTRE PAR STATUT
        |--------------------------------------------------------------------------
        */

        if ($status === 'active') {

            $coursesQuery->where(
                'is_active',
                true
            );

        } elseif ($status === 'inactive') {

            $coursesQuery->where(
                'is_active',
                false
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI PAR DATE
        |--------------------------------------------------------------------------
        |
        | On ajoute également l'heure de début pour conserver
        | un ordre logique lorsque plusieurs cours ont lieu
        | le même jour.
        |
        */

        $coursesQuery
            ->orderBy(
                'course_date',
                $sort
            )
            ->orderBy(
                'start_time',
                $sort
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
        | AFFICHAGE DE LA VUE
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
                'sort' => $sort,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE D'AJOUT D'UN COURS
    |--------------------------------------------------------------------------
    */

    public function create(Request $request): View
    {
        $admin = $request->user();

        $forcedGender = null;


        /*
        |--------------------------------------------------------------------------
        | ADMIN NORMAL
        |--------------------------------------------------------------------------
        |
        | Un administrateur normal ne peut créer un cours
        | que dans sa propre catégorie.
        |
        */

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
    | ENREGISTREMENT D'UN COURS
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        $admin = $request->user();


        /*
        |--------------------------------------------------------------------------
        | RÈGLES DE VALIDATION COMMUNES
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


        /*
        |--------------------------------------------------------------------------
        | CATÉGORIE
        |--------------------------------------------------------------------------
        |
        | Seul le Super Admin peut choisir Homme ou Femme.
        |
        */

        if ($admin->isSuperAdmin()) {

            $rules['target_gender'] = [
                'required',
                Rule::in([
                    'homme',
                    'femme',
                ]),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION DU FORMULAIRE
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            $rules,
            [
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

                'end_time.required' =>
                    'L’heure de fin est obligatoire.',

                'end_time.after' =>
                    'L’heure de fin doit être postérieure à l’heure de début.',

                'target_gender.required' =>
                    'La catégorie du cours est obligatoire.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | CATÉGORIE FINALE DU COURS
        |--------------------------------------------------------------------------
        */

        if ($admin->isSuperAdmin()) {

            $targetGender =
                $validated['target_gender'];

        } else {

            /*
            | Sécurité serveur :
            | un admin normal ne peut jamais forcer
            | une autre catégorie via le navigateur.
            */
            $targetGender =
                $admin->genre;
        }


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DU COURS
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


        /*
        |--------------------------------------------------------------------------
        | RETOUR AU CALENDRIER ADMIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Le cours a été ajouté au calendrier avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION DES DROITS SUR UN COURS
    |--------------------------------------------------------------------------
    |
    | Cette méthode servira également lorsque nous activerons
    | prochainement la modification et la suppression.
    |
    */

    private function canManageCourse(
        $admin,
        Course $course
    ): bool {

        /*
        | Le Super Admin peut tout gérer.
        */
        if ($admin->isSuperAdmin()) {
            return true;
        }


        /*
        | Un administrateur normal ne peut gérer
        | que les cours de sa catégorie.
        */
        return $admin->isAdmin()
            && $course->target_gender === $admin->genre;
    }
}