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
 * Il permet actuellement :
 *
 * - d'afficher la liste des articles ;
 * - d'afficher les articles supprimés ;
 * - de trier les articles ;
 * - d'afficher le formulaire de création ;
 * - d'enregistrer un nouvel article ;
 * - d'enregistrer une bannière pour l'article.
 *
 * Les prochaines étapes ajouteront :
 *
 * - la modification d'un article ;
 * - la suppression ;
 * - la restauration ;
 * - les images intégrées dans le contenu ;
 * - la publication sur le Blog public.
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
     * 1. vérifie les informations du formulaire ;
     * 2. vérifie la bannière ;
     * 3. enregistre la bannière dans le stockage public ;
     * 4. génère automatiquement un slug unique ;
     * 5. associe l'article à l'administrateur connecté ;
     * 6. détermine la date de publication ;
     * 7. crée l'article dans la base de données.
     */
    public function store(Request $request): RedirectResponse
    {
        /**
         * -----------------------------------------------------------
         * VALIDATION DU FORMULAIRE
         * -----------------------------------------------------------
         *
         * La bannière est maintenant obligatoire.
         *
         * Formats autorisés :
         *
         * - JPG / JPEG
         * - PNG
         * - WEBP
         *
         * Taille maximale :
         *
         * 5 Mo
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

            'banner_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /**
         * -----------------------------------------------------------
         * GÉNÉRATION DU SLUG
         * -----------------------------------------------------------
         *
         * Exemple :
         *
         * Brussels Top Team au tournoi
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
         * CRÉATION D'UN SLUG UNIQUE
         * -----------------------------------------------------------
         *
         * Exemple :
         *
         * mon-article
         * mon-article-2
         * mon-article-3
         *
         * Les articles supprimés sont également vérifiés.
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
         * ENREGISTREMENT DE LA BANNIÈRE
         * -----------------------------------------------------------
         *
         * Laravel crée automatiquement un nom de fichier unique.
         *
         * L'image sera stockée dans :
         *
         * storage/app/public/articles/banners
         *
         * Grâce à "php artisan storage:link", elle sera ensuite
         * accessible publiquement via :
         *
         * public/storage/articles/banners
         */
        $bannerPath = $request
            ->file('banner_image')
            ->store(
                'articles/banners',
                'public'
            );


        /**
         * -----------------------------------------------------------
         * CRÉATION DE L'ARTICLE
         * -----------------------------------------------------------
         */
        Article::create([
            /**
             * Administrateur ayant créé l'article.
             */
            'author_id' => auth()->id(),

            /**
             * Informations principales.
             */
            'title' => $validated['title'],

            'slug' => $slug,

            'category' => $validated['category'],

            'excerpt' => $validated['excerpt'] ?? null,

            'content' => $validated['content'],

            /**
             * Chemin de la bannière.
             *
             * Exemple :
             *
             * articles/banners/abc123.webp
             */
            'banner_image' => $bannerPath,

            /**
             * Brouillon ou publié.
             */
            'status' => $validated['status'],

            /**
             * Une case HTML non cochée n'est pas envoyée.
             *
             * boolean() permet donc d'obtenir proprement :
             *
             * true ou false.
             */
            'is_featured' => $request->boolean(
                'is_featured'
            ),

            /**
             * Si l'article est publié immédiatement,
             * la date actuelle devient sa date de publication.
             *
             * Un brouillon garde une valeur NULL.
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