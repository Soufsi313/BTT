<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


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
 * - de filtrer les articles par catégorie ;
 * - de trier les articles ;
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
     * ============================================================
     * AFFICHER LA LISTE PUBLIQUE DES ARTICLES
     * ============================================================
     *
     * Paramètres disponibles dans l'URL :
     *
     * category
     * Exemple :
     *
     * /blog?category=HYROX
     *
     *
     * sort
     * Valeurs possibles :
     *
     * recent
     * oldest
     * featured
     * title
     *
     * Exemple :
     *
     * /blog?category=HYROX&sort=recent
     *
     * ============================================================
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | CATÉGORIES AUTORISÉES
        |--------------------------------------------------------------------------
        |
        | Ces catégories correspondent aux catégories actuellement utilisées
        | dans la gestion des articles.
        |
        | On utilise une liste contrôlée afin d'éviter d'accepter n'importe
        | quelle valeur provenant directement de l'URL.
        |
        */

        $categories = [
            'Actualité',
            'Futsal',
            'Boxe',
            'Boxe Femmes',
            'HYROX',
            'Association',
            'Événement',
        ];


        /*
        |--------------------------------------------------------------------------
        | TRI AUTORISÉ
        |--------------------------------------------------------------------------
        |
        | recent   = articles les plus récents
        | oldest   = articles les plus anciens
        | featured = articles mis en avant en premier
        | title    = ordre alphabétique A → Z
        |
        */

        $allowedSorts = [
            'recent',
            'oldest',
            'featured',
            'title',
        ];


        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DE LA CATÉGORIE
        |--------------------------------------------------------------------------
        */

        $selectedCategory = $request->query('category');


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DE LA CATÉGORIE
        |--------------------------------------------------------------------------
        |
        | Si la catégorie reçue n'existe pas dans notre liste,
        | nous revenons simplement sur "Toutes les catégories".
        |
        */

        if (
            $selectedCategory !== null
            && !in_array(
                $selectedCategory,
                $categories,
                true
            )
        ) {
            $selectedCategory = null;
        }


        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DU TRI
        |--------------------------------------------------------------------------
        |
        | Par défaut, nous affichons les articles les plus récents.
        |
        */

        $selectedSort = $request->query(
            'sort',
            'recent'
        );


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DU TRI
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $selectedSort,
            $allowedSorts,
            true
        )) {
            $selectedSort = 'recent';
        }


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE DE BASE
        |--------------------------------------------------------------------------
        |
        | Seuls les articles :
        |
        | - publiés ;
        | - ayant une date de publication ;
        | - dont la date de publication est atteinte ;
        |
        | peuvent apparaître dans le blog public.
        |
        | Les articles supprimés avec SoftDeletes sont automatiquement
        | exclus par Eloquent.
        |
        */

        $query = Article::query()
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
            );


        /*
        |--------------------------------------------------------------------------
        | FILTRE PAR CATÉGORIE
        |--------------------------------------------------------------------------
        |
        | Le filtre n'est appliqué que lorsqu'une catégorie valide
        | a été sélectionnée.
        |
        */

        if ($selectedCategory !== null) {

            $query->where(
                'category',
                $selectedCategory
            );

        }


        /*
        |--------------------------------------------------------------------------
        | TRI DES ARTICLES
        |--------------------------------------------------------------------------
        */

        switch ($selectedSort) {

            /*
            |--------------------------------------------------------------------------
            | PLUS ANCIENS
            |--------------------------------------------------------------------------
            */

            case 'oldest':

                $query->orderBy(
                    'published_at',
                    'asc'
                );

                break;


            /*
            |--------------------------------------------------------------------------
            | À LA UNE
            |--------------------------------------------------------------------------
            |
            | Les articles mis en avant apparaissent d'abord.
            |
            | À l'intérieur de chaque groupe, les plus récents
            | apparaissent en premier.
            |
            */

            case 'featured':

                $query
                    ->orderByDesc(
                        'is_featured'
                    )
                    ->orderByDesc(
                        'published_at'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | TITRE A → Z
            |--------------------------------------------------------------------------
            */

            case 'title':

                $query
                    ->orderBy(
                        'title',
                        'asc'
                    )
                    ->orderByDesc(
                        'published_at'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | PLUS RÉCENTS
            |--------------------------------------------------------------------------
            |
            | Tri par défaut.
            |
            */

            case 'recent':

            default:

                $query->orderByDesc(
                    'published_at'
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | Nous affichons 12 articles par page.
        |
        | withQueryString() permet de conserver automatiquement
        | les paramètres :
        |
        | ?category=...
        | ?sort=...
        |
        | lorsqu'on clique sur la page suivante.
        |
        */

        $articles = $query
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA VUE
        |--------------------------------------------------------------------------
        |
        | Nous transmettons :
        |
        | - les articles ;
        | - les catégories disponibles ;
        | - la catégorie sélectionnée ;
        | - le tri sélectionné.
        |
        */

        return view(
            'blog',
            [
                'articles' => $articles,

                'categories' => $categories,

                'selectedCategory' => $selectedCategory,

                'selectedSort' => $selectedSort,
            ]
        );
    }


    /**
     * ============================================================
     * AFFICHER UN ARTICLE
     * ============================================================
     *
     * L'article est recherché grâce à son slug.
     *
     * Exemple :
     *
     * /blog/btt-girls-la-boxe-feminine
     *
     * ============================================================
     */
    public function show(string $slug): View
    {
        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DE L'ARTICLE
        |--------------------------------------------------------------------------
        |
        | L'article doit obligatoirement :
        |
        | - correspondre au slug demandé ;
        | - être publié ;
        | - avoir une date de publication ;
        | - être déjà publié à l'heure actuelle.
        |
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


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE L'ARTICLE
        |--------------------------------------------------------------------------
        */

        return view(
            'blog.show',
            [
                'article' => $article,
            ]
        );
    }
}