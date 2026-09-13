<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
 * - d'enregistrer une bannière ;
 * - d'afficher le formulaire de modification ;
 * - de modifier un article existant ;
 * - de remplacer sa bannière.
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
         *
         * withTrashed() permet également d'afficher les articles
         * supprimés grâce à SoftDeletes.
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
         */
        $baseSlug = Str::slug(
            $validated['title']
        );


        /**
         * Sécurité supplémentaire :
         *
         * si un titre ne génère exceptionnellement aucun slug,
         * on utilise "article".
         */
        if ($baseSlug === '') {
            $baseSlug = 'article';
        }


        $slug = $baseSlug;

        $counter = 2;


        /**
         * -----------------------------------------------------------
         * SLUG UNIQUE
         * -----------------------------------------------------------
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
            'author_id' => auth()->id(),

            'title' => $validated['title'],

            'slug' => $slug,

            'category' => $validated['category'],

            'excerpt' => $validated['excerpt'] ?? null,

            'content' => $validated['content'],

            'banner_image' => $bannerPath,

            'status' => $validated['status'],

            'is_featured' => $request->boolean(
                'is_featured'
            ),

            /**
             * Un article publié immédiatement reçoit la date actuelle.
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


    /**
     * ===============================================================
     * FORMULAIRE DE MODIFICATION
     * ===============================================================
     *
     * Laravel récupère automatiquement l'article correspondant
     * au paramètre {article} présent dans l'URL.
     *
     * Exemple :
     *
     * /admin/articles/4/modifier
     *
     * Laravel injectera automatiquement l'article ayant l'ID 4.
     */
    public function edit(Article $article): View
    {
        return view(
            'admin.articles.edit',
            [
                'article' => $article,
            ]
        );
    }


    /**
     * ===============================================================
     * MODIFICATION D'UN ARTICLE
     * ===============================================================
     *
     * Cette méthode permet de modifier :
     *
     * - le titre ;
     * - le slug ;
     * - la catégorie ;
     * - le résumé ;
     * - le contenu ;
     * - la bannière ;
     * - le statut ;
     * - la mise en avant ;
     * - la date de publication.
     */
    public function update(
        Request $request,
        Article $article
    ): RedirectResponse {
        /**
         * -----------------------------------------------------------
         * VALIDATION
         * -----------------------------------------------------------
         *
         * Contrairement à la création, la bannière n'est pas
         * obligatoire.
         *
         * Si aucune nouvelle image n'est envoyée, l'ancienne bannière
         * est simplement conservée.
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
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /**
         * -----------------------------------------------------------
         * NOUVEAU SLUG
         * -----------------------------------------------------------
         *
         * Le slug est recalculé à partir du titre.
         *
         * Exemple :
         *
         * "Tournoi BTT Bruxelles"
         *
         * devient :
         *
         * tournoi-btt-bruxelles
         */
        $baseSlug = Str::slug(
            $validated['title']
        );


        if ($baseSlug === '') {
            $baseSlug = 'article';
        }


        $slug = $baseSlug;

        $counter = 2;


        /**
         * -----------------------------------------------------------
         * VÉRIFICATION DE L'UNICITÉ DU SLUG
         * -----------------------------------------------------------
         *
         * On vérifie également les articles supprimés.
         *
         * En revanche, on ignore l'article actuellement modifié,
         * puisqu'il peut évidemment conserver son propre slug.
         */
        while (
            Article::withTrashed()
                ->where('slug', $slug)
                ->where('id', '!=', $article->id)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;

            $counter++;
        }


        /**
         * -----------------------------------------------------------
         * BANNIÈRE ACTUELLE
         * -----------------------------------------------------------
         *
         * Par défaut, nous conservons l'image déjà enregistrée.
         */
        $bannerPath = $article->banner_image;


        /**
         * -----------------------------------------------------------
         * NOUVELLE BANNIÈRE
         * -----------------------------------------------------------
         */
        if ($request->hasFile('banner_image')) {
            /**
             * On conserve temporairement le chemin de l'ancienne image.
             *
             * Elle sera supprimée seulement après l'enregistrement
             * de la nouvelle bannière.
             */
            $oldBannerPath = $article->banner_image;


            /**
             * Enregistrement de la nouvelle bannière.
             */
            $bannerPath = $request
                ->file('banner_image')
                ->store(
                    'articles/banners',
                    'public'
                );


            /**
             * Suppression de l'ancienne bannière.
             *
             * On vérifie d'abord qu'elle existe réellement.
             */
            if (
                $oldBannerPath
                && Storage::disk('public')->exists($oldBannerPath)
            ) {
                Storage::disk('public')->delete(
                    $oldBannerPath
                );
            }
        }


        /**
         * -----------------------------------------------------------
         * DATE DE PUBLICATION
         * -----------------------------------------------------------
         */
        $publishedAt = null;


        if ($validated['status'] === 'published') {
            /**
             * Si l'article était déjà publié, on conserve sa première
             * date de publication.
             *
             * S'il passe de brouillon à publié, on utilise la date
             * actuelle.
             */
            $publishedAt = $article->published_at ?? now();
        }


        /**
         * -----------------------------------------------------------
         * MISE À JOUR DE L'ARTICLE
         * -----------------------------------------------------------
         */
        $article->update([
            'title' => $validated['title'],

            'slug' => $slug,

            'category' => $validated['category'],

            'excerpt' => $validated['excerpt'] ?? null,

            'content' => $validated['content'],

            'banner_image' => $bannerPath,

            'status' => $validated['status'],

            'is_featured' => $request->boolean(
                'is_featured'
            ),

            'published_at' => $publishedAt,
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
                'L’article a été modifié avec succès.'
            );
    }
}