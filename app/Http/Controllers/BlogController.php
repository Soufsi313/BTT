<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;


/**
 * ================================================================
 * CONTRÔLEUR PUBLIC DU BLOG
 * ================================================================
 *
 * Ce contrôleur gère la partie publique du blog Brussels Top Team.
 *
 * Il permet :
 *
 * - d'afficher les articles publiés ;
 * - de filtrer les articles par catégorie ;
 * - de trier les articles ;
 * - d'afficher un article individuel ;
 * - d'afficher les commentaires publics de cet article.
 *
 * ================================================================
 */
class BlogController extends Controller
{
    /**
     * ============================================================
     * LISTE PUBLIQUE DES ARTICLES
     * ============================================================
     *
     * Cette méthode affiche uniquement les articles :
     *
     * - publiés ;
     * - possédant une date de publication ;
     * - dont la date de publication est passée ou actuelle.
     *
     * Elle gère également :
     *
     * - le filtrage par catégorie ;
     * - le tri des articles.
     *
     * ============================================================
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | CATÉGORIES DISPONIBLES
        |--------------------------------------------------------------------------
        |
        | Cette liste correspond aux catégories actuellement utilisées
        | pour les articles du blog Brussels Top Team.
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
        | TRIS AUTORISÉS
        |--------------------------------------------------------------------------
        |
        | On n'accepte que les valeurs définies ici.
        |
        | Cela évite qu'une valeur arbitraire provenant de l'URL
        | puisse modifier directement la requête SQL.
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
        | CATÉGORIE SÉLECTIONNÉE
        |--------------------------------------------------------------------------
        */

        $selectedCategory = $request->query(
            'category'
        );


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DE LA CATÉGORIE
        |--------------------------------------------------------------------------
        |
        | Si une catégorie inconnue est passée dans l'URL,
        | on l'ignore simplement.
        |
        */

        if (
            $selectedCategory !== null
            && ! in_array(
                $selectedCategory,
                $categories,
                true
            )
        ) {
            $selectedCategory = null;
        }


        /*
        |--------------------------------------------------------------------------
        | TRI SÉLECTIONNÉ
        |--------------------------------------------------------------------------
        |
        | Par défaut :
        |
        | les articles les plus récents apparaissent en premier.
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

        if (
            ! in_array(
                $selectedSort,
                $allowedSorts,
                true
            )
        ) {
            $selectedSort = 'recent';
        }


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE DE BASE
        |--------------------------------------------------------------------------
        |
        | On récupère uniquement les articles réellement visibles
        | publiquement.
        |
        | L'auteur est chargé immédiatement afin d'éviter des requêtes
        | supplémentaires lors de l'affichage de la liste.
        |
        */

        $articlesQuery = Article::query()
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
        */

        if ($selectedCategory !== null) {
            $articlesQuery->where(
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

                $articlesQuery
                    ->orderBy(
                        'published_at',
                        'asc'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | ARTICLES À LA UNE
            |--------------------------------------------------------------------------
            |
            | Les articles mis en avant apparaissent d'abord.
            | À l'intérieur de chaque groupe, les plus récents restent
            | affichés en premier.
            |
            */
            case 'featured':

                $articlesQuery
                    ->orderBy(
                        'is_featured',
                        'desc'
                    )
                    ->orderBy(
                        'published_at',
                        'desc'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | TITRE A → Z
            |--------------------------------------------------------------------------
            */
            case 'title':

                $articlesQuery
                    ->orderBy(
                        'title',
                        'asc'
                    )
                    ->orderBy(
                        'published_at',
                        'desc'
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

                $articlesQuery
                    ->orderBy(
                        'published_at',
                        'desc'
                    );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | 12 articles par page.
        |
        | withQueryString() conserve les paramètres :
        |
        | ?category=...
        | ?sort=...
        |
        | lorsque l'utilisateur change de page.
        |
        */

        $articles = $articlesQuery
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA PAGE
        |--------------------------------------------------------------------------
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
     * Cette méthode affiche un article individuel grâce à son slug.
     *
     * Elle récupère également :
     *
     * - l'auteur de l'article ;
     * - les commentaires publiés ;
     * - l'auteur de chaque commentaire.
     *
     * Les commentaires masqués ou supprimés ne sont jamais envoyés
     * à la page publique.
     *
     * ============================================================
     */
    public function show(string $slug): View
    {
        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DE L'ARTICLE
        |--------------------------------------------------------------------------
        */

        $article = Article::query()

            /*
            |--------------------------------------------------------------------------
            | CHARGEMENT DES RELATIONS
            |--------------------------------------------------------------------------
            |
            | author :
            | auteur de l'article.
            |
            | comments :
            | uniquement les commentaires ayant le statut "published".
            |
            | comments.user :
            | utilisateur ayant publié chaque commentaire.
            |
            */

            ->with([
                'author',

                'comments' => function ($query) {
                    $query
                        ->where(
                            'status',
                            'published'
                        )
                        ->with('user')
                        ->orderBy(
                            'created_at',
                            'asc'
                        );
                },
            ])


            /*
            |--------------------------------------------------------------------------
            | RECHERCHE PAR SLUG
            |--------------------------------------------------------------------------
            */

            ->where(
                'slug',
                $slug
            )


            /*
            |--------------------------------------------------------------------------
            | ARTICLE PUBLIÉ UNIQUEMENT
            |--------------------------------------------------------------------------
            */

            ->where(
                'status',
                'published'
            )


            /*
            |--------------------------------------------------------------------------
            | DATE DE PUBLICATION OBLIGATOIRE
            |--------------------------------------------------------------------------
            */

            ->whereNotNull(
                'published_at'
            )


            /*
            |--------------------------------------------------------------------------
            | PAS DE PUBLICATION FUTURE
            |--------------------------------------------------------------------------
            */

            ->where(
                'published_at',
                '<=',
                now()
            )


            /*
            |--------------------------------------------------------------------------
            | ARTICLE INTROUVABLE = ERREUR 404
            |--------------------------------------------------------------------------
            */

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