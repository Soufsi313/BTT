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
    | Cette page permet aux administrateurs de rechercher et trier les
    | adhérents.
    |
    | Règles :
    |
    | Super Admin :
    | - voit tous les adhérents ;
    | - peut afficher les hommes ;
    | - peut afficher les femmes ;
    | - peut voir les comptes actifs et supprimés ;
    | - peut effectuer une recherche mixte.
    |
    | Admin :
    | - voit uniquement les adhérents de sa propre catégorie ;
    | - un Admin Homme ne peut voir que les hommes ;
    | - une Admin Femme ne peut voir que les femmes.
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
            | Son genre est imposé côté serveur.
            |
            */
            $gender = $admin->genre;
        }


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE DES ADHÉRENTS
        |--------------------------------------------------------------------------
        |
        | withTrashed() permet d'inclure les comptes supprimés avec
        | SoftDeletes.
        |
        | On affiche uniquement les comptes ayant le rôle "adherent".
        |
        */
        $members = User::withTrashed()
            ->where('role', 'adherent');


        /*
        |--------------------------------------------------------------------------
        | APPLICATION DU FILTRE DE GENRE
        |--------------------------------------------------------------------------
        */
        if ($gender !== 'all') {
            $members->where('genre', $gender);
        }


        /*
        |--------------------------------------------------------------------------
        | APPLICATION DE LA RECHERCHE
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
    | RÉACTIVER UN ADHÉRENT SUPPRIMÉ
    |--------------------------------------------------------------------------
    |
    | Cette action est réservée au Super Admin.
    |
    | restore() remet simplement deleted_at à NULL.
    |
    */
    public function restore(Request $request, int $id)
    {
        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $admin = $request->user();


        /*
        |--------------------------------------------------------------------------
        | PROTECTION SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        if (! $admin->isSuperAdmin()) {
            abort(
                403,
                'Seul le Super Admin peut réactiver un adhérent.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DU COMPTE SUPPRIMÉ
        |--------------------------------------------------------------------------
        |
        | onlyTrashed() garantit que cette action ne concerne que les
        | comptes réellement supprimés.
        |
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
        | RETOUR À LA LISTE
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.members.index')
            ->with(
                'success',
                'Le compte de l’adhérent a été réactivé.'
            );
    }
}