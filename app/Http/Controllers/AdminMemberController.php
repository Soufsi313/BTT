<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES ADHÉRENTS
    |--------------------------------------------------------------------------
    |
    | Super Admin :
    | - voit les hommes et les femmes ;
    | - peut utiliser une recherche mixte ;
    | - voit les comptes actifs et supprimés ;
    | - peut réactiver un compte supprimé ;
    | - peut promouvoir un adhérent actif en Admin.
    |
    | Admin normal :
    | - voit uniquement les adhérents correspondant à son propre genre ;
    | - ne peut pas modifier les rôles.
    |
    */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ADMINISTRATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $admin = $request->user();


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE MANUELLE
        |--------------------------------------------------------------------------
        */
        $search = trim(
            (string) $request->query('search', '')
        );


        /*
        |--------------------------------------------------------------------------
        | TRI ALPHABÉTIQUE
        |--------------------------------------------------------------------------
        */
        $sort = $request->query('sort', 'asc');

        if (! in_array($sort, ['asc', 'desc'], true)) {
            $sort = 'asc';
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRE DE GENRE
        |--------------------------------------------------------------------------
        */
        $gender = $request->query('genre', 'all');

        if ($admin->isSuperAdmin()) {

            /*
            |--------------------------------------------------------------------------
            | SUPER ADMIN
            |--------------------------------------------------------------------------
            */
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
            | ADMIN NORMAL
            |--------------------------------------------------------------------------
            |
            | Le genre de l'Admin est imposé côté serveur.
            |
            */
            $gender = $admin->genre;
        }


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE DES ADHÉRENTS
        |--------------------------------------------------------------------------
        |
        | withTrashed() permet d'afficher également les comptes supprimés.
        |
        */
        $members = User::withTrashed()
            ->where('role', 'adherent');


        /*
        |--------------------------------------------------------------------------
        | FILTRE DE GENRE
        |--------------------------------------------------------------------------
        */
        if ($gender !== 'all') {
            $members->where('genre', $gender);
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE
        |--------------------------------------------------------------------------
        */
        if ($search !== '') {

            $members->where(function ($query) use ($search) {

                $query
                    ->where(
                        'nom',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'prenom',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'pseudo',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | TRI
        |--------------------------------------------------------------------------
        */
        $members
            ->orderBy('nom', $sort)
            ->orderBy('prenom', $sort);


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $members = $members
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.members.index',
            [
                'members' => $members,
                'search' => $search,
                'sort' => $sort,
                'gender' => $gender,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RÉACTIVER UN ADHÉRENT
    |--------------------------------------------------------------------------
    |
    | Seul le Super Admin peut effectuer cette action.
    |
    */
    public function restore(Request $request, int $id)
    {
        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN UNIQUEMENT
        |--------------------------------------------------------------------------
        */
        if (! $request->user()->isSuperAdmin()) {
            abort(
                403,
                'Seul le Super Admin peut réactiver un adhérent.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DU COMPTE SUPPRIMÉ
        |--------------------------------------------------------------------------
        */
        $member = User::onlyTrashed()
            ->where('role', 'adherent')
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | RÉACTIVATION
        |--------------------------------------------------------------------------
        */
        $member->restore();


        /*
        |--------------------------------------------------------------------------
        | RETOUR
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.members.index')
            ->with(
                'success',
                'Le compte de l’adhérent a été réactivé.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PROMOUVOIR UN ADHÉRENT EN ADMIN
    |--------------------------------------------------------------------------
    |
    | Cette action est strictement réservée au Super Admin.
    |
    | Le genre du compte n'est pas modifié.
    |
    */
    public function promoteToAdmin(
        Request $request,
        int $id
    ) {
        /*
        |--------------------------------------------------------------------------
        | PROTECTION SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        if (! $request->user()->isSuperAdmin()) {
            abort(
                403,
                'Seul le Super Admin peut nommer un administrateur.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DE L'ADHÉRENT
        |--------------------------------------------------------------------------
        |
        | Seul un adhérent actif peut devenir administrateur.
        |
        */
        $member = User::query()
            ->where('role', 'adherent')
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | PROMOTION
        |--------------------------------------------------------------------------
        */
        $member->role = 'admin';

        $member->save();


        /*
        |--------------------------------------------------------------------------
        | RETOUR
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.members.index')
            ->with(
                'success',
                $member->prenom
                . ' '
                . $member->nom
                . ' est maintenant administrateur.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LISTE DES ADMINISTRATEURS
    |--------------------------------------------------------------------------
    |
    | Cette page est strictement réservée au Super Admin.
    |
    | Elle affiche :
    |
    | - le Super Admin ;
    | - les Admins Hommes ;
    | - les Admins Femmes.
    |
    | Le Super Admin peut :
    |
    | - effectuer une recherche ;
    | - filtrer par genre ;
    | - trier alphabétiquement ;
    | - rétrograder un Admin en adhérent.
    |
    */
    public function administrators(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | PROTECTION SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        if (! $request->user()->isSuperAdmin()) {
            abort(
                403,
                'Seul le Super Admin peut gérer les administrateurs.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE MANUELLE
        |--------------------------------------------------------------------------
        */
        $search = trim(
            (string) $request->query('search', '')
        );


        /*
        |--------------------------------------------------------------------------
        | TRI ALPHABÉTIQUE
        |--------------------------------------------------------------------------
        */
        $sort = $request->query('sort', 'asc');

        if (! in_array($sort, ['asc', 'desc'], true)) {
            $sort = 'asc';
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRE DE GENRE
        |--------------------------------------------------------------------------
        */
        $gender = $request->query('genre', 'all');

        if (! in_array(
            $gender,
            ['all', 'homme', 'femme'],
            true
        )) {
            $gender = 'all';
        }


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE DES ADMINISTRATEURS
        |--------------------------------------------------------------------------
        |
        | Nous recherchons :
        |
        | - les comptes "admin" ;
        | - le compte "super_admin".
        |
        */
        $administrators = User::query()
            ->whereIn(
                'role',
                [
                    'admin',
                    'super_admin',
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | FILTRE DE GENRE
        |--------------------------------------------------------------------------
        */
        if ($gender !== 'all') {
            $administrators->where(
                'genre',
                $gender
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE
        |--------------------------------------------------------------------------
        */
        if ($search !== '') {

            $administrators->where(
                function ($query) use ($search) {

                    $query
                        ->where(
                            'nom',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'prenom',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'pseudo',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI
        |--------------------------------------------------------------------------
        */
        $administrators
            ->orderBy('nom', $sort)
            ->orderBy('prenom', $sort);


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $administrators = $administrators
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.administrators.index',
            [
                'administrators' => $administrators,
                'search' => $search,
                'sort' => $sort,
                'gender' => $gender,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RÉTROGRADER UN ADMIN EN ADHÉRENT
    |--------------------------------------------------------------------------
    |
    | Seul le Super Admin peut effectuer cette opération.
    |
    | Un compte Super Admin ne peut jamais être rétrogradé par cette route.
    |
    */
    public function demoteAdmin(
        Request $request,
        int $id
    ) {
        /*
        |--------------------------------------------------------------------------
        | PROTECTION SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        if (! $request->user()->isSuperAdmin()) {
            abort(
                403,
                'Seul le Super Admin peut rétrograder un administrateur.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DE L'ADMIN
        |--------------------------------------------------------------------------
        |
        | Le filtre role = admin est volontaire.
        |
        | Cela empêche automatiquement de rétrograder :
        |
        | - un adhérent ;
        | - le Super Admin.
        |
        */
        $administrator = User::query()
            ->where('role', 'admin')
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | RÉTROGRADATION
        |--------------------------------------------------------------------------
        */
        $administrator->role = 'adherent';

        $administrator->save();


        /*
        |--------------------------------------------------------------------------
        | RETOUR
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.administrators.index')
            ->with(
                'success',
                $administrator->prenom
                . ' '
                . $administrator->nom
                . ' est redevenu adhérent.'
            );
    }
}