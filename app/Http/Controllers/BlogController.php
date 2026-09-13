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
 * Pour le moment, il permet :
 *
 * - de récupérer les articles publiés ;
 * - d'exclure automatiquement les articles supprimés ;
 * - d'exclure les brouillons ;
 * - d'exclure les articles dont la publication est future ;
 * - d'envoyer les articles à la vue publique du blog.
 *
 * Plus tard, ce même contrôleur servira également pour :
 *
 * - la lecture d'un article individuel ;
 * - les catégories ;
 * - les articles mis en avant ;
 * - éventuellement la pagination / les filtres.
 *
 * ================================================================
 */
class BlogController extends Controller
{
    /**
     * ===============================================================
     * PAGE PUBLIQUE DU BLOG
     * ===============================================================
     *
     * URL :
     *
     * /blog
     *
     * Seuls les véritables articles publiés doivent apparaître
     * publiquement.
     *
     * Un article doit donc :
     *
     * - avoir le statut "published" ;
     * - posséder une date de publication ;
     * - avoir une date de publication inférieure ou égale à maintenant ;
     * - ne pas être supprimé.
     *
     * Les articles supprimés sont automatiquement ignorés par Laravel
     * grâce à SoftDeletes tant que nous n'utilisons pas withTrashed().
     * ===============================================================
     */
    public function index(): View
    {
        /**
         * -----------------------------------------------------------
         * RÉCUPÉRATION DES ARTICLES PUBLIÉS
         * -----------------------------------------------------------
         *
         * with('author') charge également l'auteur afin d'éviter
         * plusieurs requêtes SQL inutiles dans la vue.
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
         * ENVOI DES ARTICLES À LA VUE
         * -----------------------------------------------------------
         */
        return view(
            'blog',
            [
                'articles' => $articles,
            ]
        );
    }
}