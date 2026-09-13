<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


/**
 * ================================================================
 * CONTRÔLEUR DE GESTION DES ARTICLES - ADMINISTRATION
 * ================================================================
 *
 * Ce contrôleur gère les articles du blog Brussels Top Team
 * depuis l'espace d'administration.
 *
 * À ce stade, il permet :
 *
 * - d'afficher la liste des articles ;
 * - d'afficher les articles supprimés ;
 * - de trier les articles ;
 * - d'afficher le formulaire de création ;
 * - d'enregistrer un nouvel article.
 *
 * Les prochaines étapes ajouteront :
 *
 * - la modification ;
 * - la suppression ;
 * - la restauration ;
 * - la bannière ;
 * - les images intégrées dans le contenu ;
 * - la publication publique du blog.
 *
 * ================================================================
 */
class AdminArticleController extends Controller
{
    /**
     * ===============================================================
     * LISTE DES ARTICLES
     * ===============================================================
     */
    public function index(Request $request): View
    {
        /**
         * -----------------------------------------------------------
         * TRI PAR DÉFAUT
         * -----------------------------------------------------------
         */
        $sort = $request->query(
            'sort',
            'created_at'
        );


        /**
         * -----------------------------------------------------------
         * DIRECTION DU TRI
         * -----------------------------------------------------------
         */
        $direction = $request->query(
            'direction',
            'desc'
        );


        /**
         * -----------------------------------------------------------
         * COLONNES AUTORISÉES POUR LE TRI
         * -----------------------------------------------------------
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
         * AFFICHAGE DE LA LISTE
         * -----------------------------------------------------------
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


    /**
     * ===============================================================
     * FORMULAIRE DE CRÉATION
     * ===============================================================
     *
     * Affiche la page permettant de créer un nouvel article.
     */
    public function create(): View
    {
        return view('admin.articles.create');
    }


    /**
     * ===============================================================
     * ENREGISTREMENT D'UN NOUVEL ARTICLE
     * ===============================================================
     *
     * Cette méthode :
     *
     * 1. vérifie les données du formulaire ;
     * 2. génère automatiquement un slug ;
     * 3. associe l'article à l'administrateur connecté ;
     * 4. définit la date de publication si nécessaire ;
     * 5. crée l'article dans la base de données.
     */
    public function store(Request $request): RedirectResponse
    {
        /**
         * -----------------------------------------------------------
         * VALIDATION
         * -----------------------------------------------------------
         */
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
                'in:Actualité,Futsal,Boxe,HYROX,Association,Événement',
            ],

            'excerpt' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'content' => [
                'required',
                'string',
                'min:10',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],
        ]);


        /**
         * -----------------------------------------------------------
         * GÉNÉRATION DU SLUG
         * -----------------------------------------------------------
         *
         * Exemple :
         *
         * "Brussels Top Team au tournoi"
         *
         * devient :
         *
         * brussels-top-team-au-tournoi
         */
        $baseSlug = Str::slug(
            $validated['title']
        );

        $slug = $baseSlug;

        $counter = 2;


        /**
         * -----------------------------------------------------------
         * SLUG UNIQUE
         * -----------------------------------------------------------
         *
         * Si un article possède déjà le même slug :
         *
         * article
         * article-2
         * article-3
         * etc.
         *
         * Nous vérifions également les articles supprimés afin
         * d'éviter une collision avec leur slug.
         */
        while (
            Article::withTrashed()
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;

            $counter++;
        }


        /**
         * -----------------------------------------------------------
         * CRÉATION DE L'ARTICLE
         * -----------------------------------------------------------
         */
        Article::create([
            'author_id' => auth()->id(),

            'title' => $validated['title'],

            'slug' => $slug,

            'category' => $validated['category'],

            'excerpt' => $validated['excerpt'] ?? null,

            'content' => $validated['content'],

            /**
             * La bannière sera ajoutée plus tard.
             */
            'banner_image' => null,

            'status' => $validated['status'],

            /**
             * Une case non cochée n'est pas envoyée par HTML.
             */
            'is_featured' => $request->boolean(
                'is_featured'
            ),

            /**
             * Si l'article est publié immédiatement,
             * nous enregistrons la date actuelle.
             *
             * Un brouillon n'a pas encore de date de publication.
             */
            'published_at' => $validated['status'] === 'published'
                ? now()
                : null,
        ]);


        /**
         * -----------------------------------------------------------
         * RETOUR À LA LISTE
         * -----------------------------------------------------------
         */
        return redirect()
            ->route('admin.articles.index')
            ->with(
                'success',
                'L’article a été créé avec succès.'
            );
    }
}