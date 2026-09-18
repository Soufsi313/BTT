<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


/**
 * ================================================================
 * CONTRÔLEUR ADMINISTRATION DES COMMENTAIRES
 * ================================================================
 *
 * Ce contrôleur permet aux administrateurs de gérer les commentaires
 * publiés sous les articles du blog Brussels Top Team.
 *
 * Il permet notamment :
 *
 * - d'afficher la liste des commentaires ;
 * - d'afficher les statistiques des commentaires ;
 * - de trier les commentaires ;
 * - de masquer un commentaire ;
 * - de réafficher un commentaire ;
 * - de supprimer logiquement un commentaire ;
 * - de restaurer un commentaire supprimé.
 *
 * ================================================================
 */
class AdminCommentController extends Controller
{
    /**
     * ============================================================
     * LISTE DES COMMENTAIRES
     * ============================================================
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | COLONNES AUTORISÉES POUR LE TRI
        |--------------------------------------------------------------------------
        */

        $allowedSorts = [
            'created_at',
            'status',
        ];


        /*
        |--------------------------------------------------------------------------
        | TRI DEMANDÉ
        |--------------------------------------------------------------------------
        */

        $sort = $request->query(
            'sort',
            'created_at'
        );


        /*
        |--------------------------------------------------------------------------
        | DIRECTION DU TRI
        |--------------------------------------------------------------------------
        */

        $direction = $request->query(
            'direction',
            'desc'
        );


        /*
        |--------------------------------------------------------------------------
        | SÉCURISATION DU TRI
        |--------------------------------------------------------------------------
        */

        if (
            ! in_array(
                $sort,
                $allowedSorts,
                true
            )
        ) {
            $sort = 'created_at';
        }


        if (
            ! in_array(
                $direction,
                [
                    'asc',
                    'desc',
                ],
                true
            )
        ) {
            $direction = 'desc';
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES DES COMMENTAIRES
        |--------------------------------------------------------------------------
        |
        | Ces statistiques sont totalement indépendantes :
        |
        | - du tri actuellement appliqué au tableau ;
        | - de la pagination.
        |
        | Le compteur total inclut également les commentaires supprimés
        | logiquement grâce à withTrashed().
        |
        | Les compteurs "Publiés" et "Masqués" concernent uniquement
        | les commentaires qui ne sont pas supprimés.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | TOTAL DES COMMENTAIRES
        |--------------------------------------------------------------------------
        |
        | Comprend :
        |
        | - les commentaires publiés ;
        | - les commentaires masqués ;
        | - les commentaires supprimés logiquement.
        |
        */

        $totalCommentsCount = Comment::withTrashed()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | COMMENTAIRES PUBLIÉS
        |--------------------------------------------------------------------------
        |
        | Comment::query() exclut automatiquement les commentaires
        | supprimés grâce au scope SoftDeletes de Laravel.
        |
        */

        $publishedCommentsCount = Comment::query()
            ->where(
                'status',
                'published'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | COMMENTAIRES MASQUÉS
        |--------------------------------------------------------------------------
        |
        | Un commentaire masqué reste présent dans la base de données
        | mais n'est plus visible publiquement.
        |
        */

        $hiddenCommentsCount = Comment::query()
            ->where(
                'status',
                'hidden'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | COMMENTAIRES SUPPRIMÉS
        |--------------------------------------------------------------------------
        |
        | onlyTrashed() récupère uniquement les commentaires supprimés
        | logiquement et possédant donc une valeur dans deleted_at.
        |
        */

        $deletedCommentsCount = Comment::onlyTrashed()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DES COMMENTAIRES
        |--------------------------------------------------------------------------
        |
        | withTrashed() permet également à l'administration de voir
        | les commentaires supprimés logiquement.
        |
        | On charge :
        |
        | - l'article concerné ;
        | - l'auteur du commentaire.
        |
        */

        $comments = Comment::query()
            ->withTrashed()
            ->with([
                'article',
                'user',
            ])
            ->orderBy(
                $sort,
                $direction
            )
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.comments.index',
            [
                'comments' => $comments,

                'sort' => $sort,

                'direction' => $direction,

                /*
                |--------------------------------------------------------------------------
                | STATISTIQUES TRANSMISES À LA VUE
                |--------------------------------------------------------------------------
                */

                'totalCommentsCount' => $totalCommentsCount,

                'publishedCommentsCount' => $publishedCommentsCount,

                'hiddenCommentsCount' => $hiddenCommentsCount,

                'deletedCommentsCount' => $deletedCommentsCount,
            ]
        );
    }


    /**
     * ============================================================
     * MASQUER UN COMMENTAIRE
     * ============================================================
     *
     * Le commentaire reste présent en base de données,
     * mais il n'est plus visible publiquement.
     *
     * ============================================================
     */
    public function hide(Comment $comment): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | COMMENTAIRE DÉJÀ SUPPRIMÉ
        |--------------------------------------------------------------------------
        |
        | Une ressource supprimée logiquement ne doit pas être modifiée
        | via cette action.
        |
        */

        if ($comment->trashed()) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | CHANGEMENT DE STATUT
        |--------------------------------------------------------------------------
        */

        $comment->update([
            'status' => 'hidden',
        ]);


        return redirect()
            ->route(
                'admin.comments.index'
            )
            ->with(
                'success',
                'Le commentaire a été masqué.'
            );
    }


    /**
     * ============================================================
     * RÉAFFICHER UN COMMENTAIRE
     * ============================================================
     */
    public function publish(Comment $comment): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | COMMENTAIRE DÉJÀ SUPPRIMÉ
        |--------------------------------------------------------------------------
        */

        if ($comment->trashed()) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | CHANGEMENT DE STATUT
        |--------------------------------------------------------------------------
        */

        $comment->update([
            'status' => 'published',
        ]);


        return redirect()
            ->route(
                'admin.comments.index'
            )
            ->with(
                'success',
                'Le commentaire est de nouveau visible publiquement.'
            );
    }


    /**
     * ============================================================
     * SUPPRIMER UN COMMENTAIRE
     * ============================================================
     *
     * Suppression logique uniquement.
     *
     * Le commentaire reste en base et pourra être restauré.
     *
     * ============================================================
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();


        return redirect()
            ->route(
                'admin.comments.index'
            )
            ->with(
                'success',
                'Le commentaire a été supprimé.'
            );
    }


    /**
     * ============================================================
     * RESTAURER UN COMMENTAIRE SUPPRIMÉ
     * ============================================================
     */
    public function restore(int $id): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | RECHERCHE PARMI LES COMMENTAIRES SUPPRIMÉS
        |--------------------------------------------------------------------------
        */

        $comment = Comment::onlyTrashed()
            ->findOrFail(
                $id
            );


        /*
        |--------------------------------------------------------------------------
        | RESTAURATION
        |--------------------------------------------------------------------------
        */

        $comment->restore();


        /*
        |--------------------------------------------------------------------------
        | STATUT APRÈS RESTAURATION
        |--------------------------------------------------------------------------
        |
        | On conserve volontairement son ancien statut.
        |
        | Exemple :
        |
        | - s'il était "published", il redevient visible ;
        | - s'il était "hidden", il reste masqué.
        |
        */

        return redirect()
            ->route(
                'admin.comments.index'
            )
            ->with(
                'success',
                'Le commentaire a été restauré.'
            );
    }
}