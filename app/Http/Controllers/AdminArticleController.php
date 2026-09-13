<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


/**
 * ================================================================
 * CONTRÔLEUR DE GESTION DES ARTICLES - ADMINISTRATION
 * ================================================================
 *
 * Ce contrôleur sera responsable de toute la gestion des articles
 * du blog depuis l'espace d'administration Brussels Top Team.
 *
 * Pour le moment, nous mettons uniquement en place :
 *
 * - la liste des articles ;
 * - l'affichage des articles actifs et supprimés ;
 * - l'ordre d'affichage ;
 * - la pagination.
 *
 * Les prochaines étapes ajouteront :
 *
 * - la création d'un article ;
 * - la modification ;
 * - la publication ;
 * - la suppression ;
 * - la restauration ;
 * - la bannière ;
 * - les images intégrées dans l'article.
 *
 * ================================================================
 */
class AdminArticleController extends Controller
{
    /**
     * ===============================================================
     * LISTE DES ARTICLES
     * ===============================================================
     *
     * Affiche tous les articles du blog dans l'administration.
     *
     * Nous utilisons withTrashed() afin de pouvoir également afficher
     * les articles supprimés par Soft Delete.
     *
     * Cela permettra plus tard au Super Admin de restaurer un article.
     */
    public function index(Request $request): View
    {
        /**
         * -----------------------------------------------------------
         * TRI PAR DÉFAUT
         * -----------------------------------------------------------
         *
         * Les articles les plus récents apparaissent en premier.
         */
        $sort = $request->query(
            'sort',
            'created_at'
        );


        /**
         * -----------------------------------------------------------
         * DIRECTION DU TRI
         * -----------------------------------------------------------
         *
         * desc = du plus récent au plus ancien
         * asc  = du plus ancien au plus récent
         */
        $direction = $request->query(
            'direction',
            'desc'
        );


        /**
         * -----------------------------------------------------------
         * COLONNES AUTORISÉES POUR LE TRI
         * -----------------------------------------------------------
         *
         * Cela évite d'accepter n'importe quelle colonne provenant
         * directement de l'URL.
         */
        $allowedSorts = [
            'title',
            'category',
            'status',
            'published_at',
            'created_at',
        ];


        /**
         * -----------------------------------------------------------
         * SÉCURISATION DU TRI
         * -----------------------------------------------------------
         */
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }


        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }


        /**
         * -----------------------------------------------------------
         * RÉCUPÉRATION DES ARTICLES
         * -----------------------------------------------------------
         *
         * withTrashed()
         * permet également de récupérer les articles supprimés.
         *
         * with('author')
         * récupère l'auteur de chaque article en une seule fois.
         *
         * paginate(20)
         * limite la liste à 20 articles par page.
         */
        $articles = Article::query()
            ->withTrashed()
            ->with('author')
            ->orderBy(
                $sort,
                $direction
            )
            ->orderBy(
                'id',
                'desc'
            )
            ->paginate(20)
            ->withQueryString();


        /**
         * -----------------------------------------------------------
         * AFFICHAGE DE LA VUE
         * -----------------------------------------------------------
         *
         * La vue sera créée juste après :
         *
         * resources/views/admin/articles/index.blade.php
         */
        return view(
            'admin.articles.index',
            [
                'articles' => $articles,
                'sort' => $sort,
                'direction' => $direction,
            ]
        );
    }
}