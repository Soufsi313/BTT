<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;


/**
 * ================================================================
 * CONTRÔLEUR PUBLIC DU BLOG BTT
 * ================================================================
 *
 * Ce contrôleur gère la partie publique du blog Brussels Top Team.
 *
 * Il permet :
 *
 * - d'afficher la liste des articles publiés ;
 * - d'afficher un article individuel ;
 * - d'exclure les brouillons ;
 * - d'exclure les articles supprimés ;
 * - d'exclure les articles dont la date de publication
 *   n'est pas encore atteinte.
 *
 * ================================================================
 */
class BlogController extends Controller
{
    /**
     * ===============================================================
     * LISTE PUBLIQUE DES ARTICLES
     * ===============================================================
     *
     * URL :
     *
     * /blog
     *
     * Cette méthode récupère uniquement les articles qui peuvent
     * réellement être visibles publiquement.
     * ===============================================================
     */
    public function index(): View
    {
        /**
         * -----------------------------------------------------------
         * RÉCUPÉRATION DES ARTICLES PUBLIÉS
         * -----------------------------------------------------------
         *
         * Nous ne récupérons pas les articles supprimés.
         *
         * Laravel les exclut automatiquement grâce à SoftDeletes
         * puisque nous n'utilisons pas withTrashed().
         */
        $articles = Article::query()
            ->with('author')
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
            ->orderByDesc(
                'is_featured'
            )
            ->orderByDesc(
                'published_at'
            )
            ->paginate(12);


        /**
         * -----------------------------------------------------------
         * AFFICHAGE DE LA PAGE BLOG
         * -----------------------------------------------------------
         */
        return view(
            'blog',
            [
                'articles' => $articles,
            ]
        );
    }


    /**
     * ===============================================================
     * LECTURE D'UN ARTICLE
     * ===============================================================
     *
     * URL future :
     *
     * /blog/{slug}
     *
     * Exemple :
     *
     * /blog/retour-sur-notre-entrainement-boxe
     *
     * Nous utilisons le slug au lieu de l'identifiant numérique
     * afin d'obtenir une adresse plus propre et plus lisible.
     * ===============================================================
     */
    public function show(string $slug): View
    {
        /**
         * -----------------------------------------------------------
         * RECHERCHE DE L'ARTICLE
         * -----------------------------------------------------------
         *
         * L'article doit :
         *
         * - posséder le slug demandé ;
         * - être publié ;
         * - posséder une date de publication ;
         * - avoir déjà atteint sa date de publication ;
         * - ne pas être supprimé.
         *
         * firstOrFail() provoquera automatiquement une erreur 404
         * si aucun article public ne correspond.
         *
         * Cela empêche notamment un visiteur d'accéder directement
         * à un brouillon en connaissant son slug.
         * -----------------------------------------------------------
         */
        $article = Article::query()
            ->with('author')
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


        /**
         * -----------------------------------------------------------
         * AFFICHAGE DE L'ARTICLE
         * -----------------------------------------------------------
         *
         * La vue sera créée lors de l'étape suivante :
         *
         * resources/views/blog/show.blade.php
         */
        return view(
            'blog.show',
            [
                'article' => $article,
            ]
        );
    }
}