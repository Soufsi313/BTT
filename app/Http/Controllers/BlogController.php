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
 * Ce contrôleur gère :
 *
 * - la liste publique des articles ;
 * - le filtrage par catégorie ;
 * - le tri des articles ;
 * - le nombre de likes affiché sur chaque vignette ;
 * - le nombre de commentaires publiés affiché sur chaque vignette ;
 * - l'affichage d'un article individuel ;
 * - les commentaires visibles publiquement ;
 * - le nombre de likes d'un article ;
 * - l'état du like pour l'utilisateur connecté.
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
     * Cette méthode affiche la page :
     *
     * /blog
     *
     * Elle récupère uniquement les articles publics et charge
     * également :
     *
     * - le nombre de likes de chaque article ;
     * - le nombre de commentaires publiés de chaque article.
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
        | Ces catégories correspondent aux catégories utilisées
        | dans les articles du blog BTT.
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
        | CATÉGORIE SÉLECTIONNÉE
        |--------------------------------------------------------------------------
        */

        $selectedCategory = $request->query('category');


        /*
        |--------------------------------------------------------------------------
        | SÉCURISATION DE LA CATÉGORIE
        |--------------------------------------------------------------------------
        |
        | Si une catégorie inconnue est passée manuellement dans l'URL,
        | nous l'ignorons.
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
        | TRIS DISPONIBLES
        |--------------------------------------------------------------------------
        */

        $allowedSorts = [
            'recent',
            'oldest',
            'featured',
            'title',
        ];


        /*
        |--------------------------------------------------------------------------
        | TRI SÉLECTIONNÉ
        |--------------------------------------------------------------------------
        */

        $selectedSort = $request->query(
            'sort',
            'recent'
        );


        /*
        |--------------------------------------------------------------------------
        | SÉCURISATION DU TRI
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
        | Nous récupérons uniquement les articles :
        |
        | - publiés ;
        | - possédant une date de publication ;
        | - dont la date de publication est déjà passée.
        |
        | with('author')
        | ----------------
        | Charge l'auteur de l'article.
        |
        | withCount('likes')
        | ------------------
        | Compte automatiquement les likes de chaque article.
        |
        | Laravel ajoute alors une propriété :
        |
        | $article->likes_count
        |
        | que nous pouvons afficher directement sur les vignettes.
        |
        | withCount(['comments' => ...])
        | --------------------------------
        | Compte les commentaires de l'article en appliquant
        | volontairement un filtre :
        |
        | status = published
        |
        | Cela signifie qu'un commentaire masqué par la modération
        | ou n'étant pas public ne sera pas comptabilisé.
        |
        | Laravel ajoute alors automatiquement :
        |
        | $article->comments_count
        |
        | Cette propriété sera utilisée dans blog.blade.php.
        |
        */

        $query = Article::query()
            ->with('author')

            /*
            |--------------------------------------------------------------------------
            | COMPTEUR DE LIKES
            |--------------------------------------------------------------------------
            */

            ->withCount('likes')

            /*
            |--------------------------------------------------------------------------
            | COMPTEUR DE COMMENTAIRES PUBLICS
            |--------------------------------------------------------------------------
            |
            | Nous ne comptons que les commentaires ayant le statut
            | "published".
            |
            | Exemple :
            |
            | - 4 commentaires publiés ;
            | - 1 commentaire masqué ;
            |
            | Le compteur affiché publiquement sera donc :
            |
            | 4
            |
            */

            ->withCount([
                'comments' => function ($query) {
                    $query->where(
                        'status',
                        'published'
                    );
                },
            ])

            /*
            |--------------------------------------------------------------------------
            | ARTICLE PUBLIÉ
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
            | PUBLICATION DÉJÀ EFFECTIVE
            |--------------------------------------------------------------------------
            */

            ->where(
                'published_at',
                '<=',
                now()
            );


        /*
        |--------------------------------------------------------------------------
        | FILTRAGE PAR CATÉGORIE
        |--------------------------------------------------------------------------
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
            | ARTICLES À LA UNE
            |--------------------------------------------------------------------------
            |
            | Les articles mis en avant apparaissent d'abord.
            |
            | À égalité, les plus récents apparaissent en premier.
            |
            */

            case 'featured':

                $query
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

                $query
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
            */

            case 'recent':
            default:

                $query->orderBy(
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
        | Nous affichons au maximum 12 articles par page.
        |
        | withQueryString() conserve les filtres et le tri lors du
        | passage d'une page à l'autre.
        |
        */

        $articles = $query
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA PAGE BLOG
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
     * AFFICHAGE D'UN ARTICLE
     * ============================================================
     *
     * Cette méthode affiche :
     *
     * /blog/{slug}
     *
     * Elle récupère :
     *
     * - l'article ;
     * - son auteur ;
     * - ses commentaires publics ;
     * - son nombre de likes ;
     * - l'état du like du membre connecté.
     *
     * ============================================================
     */
    public function show(
        Request $request,
        string $slug
    ): View {

        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DE L'ARTICLE
        |--------------------------------------------------------------------------
        |
        | Nous chargeons :
        |
        | - l'auteur ;
        | - les commentaires publiés ;
        | - l'utilisateur de chaque commentaire ;
        | - le nombre total de likes.
        |
        */

        $article = Article::query()
            ->withCount('likes')
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
        | L'UTILISATEUR CONNECTÉ A-T-IL DÉJÀ LIKÉ ?
        |--------------------------------------------------------------------------
        |
        | Par défaut :
        |
        | false = aucun like de cet utilisateur.
        |
        | Pour un visiteur non connecté, cette valeur reste false.
        |
        */

        $hasLiked = false;


        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        |
        | Si un utilisateur est connecté, nous recherchons un like
        | appartenant à cet utilisateur sur cet article.
        |
        */

        if ($request->user()) {

            $hasLiked = $article
                ->likes()
                ->where(
                    'user_id',
                    $request->user()->id
                )
                ->exists();
        }


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE L'ARTICLE
        |--------------------------------------------------------------------------
        */

        return view(
            'blog.show',
            [
                'article' => $article,
                'hasLiked' => $hasLiked,
            ]
        );
    }
}