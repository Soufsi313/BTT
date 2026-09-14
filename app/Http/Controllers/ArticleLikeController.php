<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


/**
 * ================================================================
 * CONTRÔLEUR DES LIKES D'ARTICLES
 * ================================================================
 *
 * Ce contrôleur gère les "J'aime" déposés par les utilisateurs
 * connectés sur les articles du blog Brussels Top Team.
 *
 * Fonctionnement :
 *
 * - premier clic :
 *   création d'un like ;
 *
 * - deuxième clic :
 *   suppression du like existant ;
 *
 * Un utilisateur ne peut donc posséder qu'un seul like
 * par article.
 *
 * Cette règle est protégée à deux niveaux :
 *
 * - par le contrôleur ;
 * - par la contrainte UNIQUE présente dans la base de données
 *   sur article_id + user_id.
 *
 * ================================================================
 */
class ArticleLikeController extends Controller
{
    /**
     * ============================================================
     * AJOUTER OU RETIRER UN LIKE
     * ============================================================
     *
     * Cette méthode fonctionne comme un interrupteur.
     *
     * Si le membre n'a pas encore aimé l'article :
     * nous créons le like.
     *
     * S'il l'a déjà aimé :
     * nous supprimons son like.
     *
     * ============================================================
     */
    public function toggle(
        Request $request,
        string $slug
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DE L'ARTICLE PUBLIC
        |--------------------------------------------------------------------------
        |
        | Nous autorisons les likes uniquement sur un article :
        |
        | - existant ;
        | - publié ;
        | - possédant une date de publication ;
        | - dont la date de publication est déjà passée.
        |
        | Un brouillon ou un article programmé dans le futur
        | ne peut donc pas recevoir de like depuis cette action.
        |
        */

        $article = Article::query()
            ->where(
                'slug',
                $slug
            )
            ->where(
                'status',
                'published'
            )
            ->whereNotNull(
                'published_at'
            )
            ->where(
                'published_at',
                '<=',
                now()
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        |
        | La route sera protégée avec le middleware auth.
        |
        | Nous récupérons donc ici directement l'utilisateur connecté.
        |
        */

        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE D'UN LIKE EXISTANT
        |--------------------------------------------------------------------------
        |
        | Nous vérifions si cet utilisateur a déjà liké cet article.
        |
        */

        $existingLike = ArticleLike::query()
            ->where(
                'article_id',
                $article->id
            )
            ->where(
                'user_id',
                $user->id
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | LE LIKE EXISTE DÉJÀ
        |--------------------------------------------------------------------------
        |
        | Dans ce cas, le membre a recliqué sur le bouton.
        |
        | Nous supprimons donc son like.
        |
        */

        if ($existingLike) {

            $existingLike->delete();


            /*
            |--------------------------------------------------------------------------
            | RETOUR VERS L'ARTICLE
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'blog.show',
                    $article->slug
                )
                ->with(
                    'success',
                    'Votre like a été retiré.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DU LIKE
        |--------------------------------------------------------------------------
        |
        | Aucun like n'existe encore pour ce membre sur cet article.
        |
        | Nous pouvons donc l'enregistrer.
        |
        */

        ArticleLike::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | RETOUR VERS L'ARTICLE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'blog.show',
                $article->slug
            )
            ->with(
                'success',
                'Merci ! Vous aimez maintenant cet article.'
            );
    }
}