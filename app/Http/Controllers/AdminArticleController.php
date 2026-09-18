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
 * - d'afficher les statistiques des articles ;
 * - de trier les articles ;
 * - d'afficher le formulaire de création ;
 * - d'enregistrer un nouvel article ;
 * - d'enregistrer une bannière ;
 * - d'afficher le formulaire de modification ;
 * - de modifier un article existant ;
 * - de remplacer sa bannière ;
 * - de supprimer temporairement un article ;
 * - de restaurer un article supprimé.
 *
 * Les suppressions utilisent SoftDeletes.
 *
 * Cela signifie qu'un article supprimé reste dans la base de
 * données avec une date renseignée dans la colonne deleted_at.
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
         * STATISTIQUES DES ARTICLES
         * -----------------------------------------------------------
         *
         * Les statistiques sont calculées indépendamment :
         *
         * - du tri du tableau ;
         * - de la pagination.
         *
         * Le total comprend également les articles supprimés
         * grâce à withTrashed().
         *
         * Les compteurs Publiés, Brouillons et À la une excluent
         * volontairement les articles supprimés.
         *
         * Les articles supprimés disposent de leur propre compteur.
         */


        /**
         * Nombre total d'articles.
         *
         * Comprend :
         *
         * - les articles publiés ;
         * - les brouillons ;
         * - les articles supprimés.
         */
        $totalArticlesCount = Article::withTrashed()
            ->count();


        /**
         * Nombre d'articles actuellement publiés.
         *
         * Article::query() exclut automatiquement les articles
         * supprimés par SoftDeletes.
         */
        $publishedArticlesCount = Article::query()
            ->where(
                'status',
                'published'
            )
            ->count();


        /**
         * Nombre d'articles actuellement enregistrés
         * comme brouillons.
         */
        $draftArticlesCount = Article::query()
            ->where(
                'status',
                'draft'
            )
            ->count();


        /**
         * Nombre d'articles actuellement mis en avant.
         *
         * Les articles supprimés ne sont pas comptabilisés.
         */
        $featuredArticlesCount = Article::query()
            ->where(
                'is_featured',
                true
            )
            ->count();


        /**
         * Nombre d'articles supprimés temporairement.
         *
         * onlyTrashed() récupère uniquement les articles dont
         * la colonne deleted_at contient une date.
         */
        $deletedArticlesCount = Article::onlyTrashed()
            ->count();


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

                /**
                 * Statistiques globales des articles.
                 */
                'totalArticlesCount' => $totalArticlesCount,

                'publishedArticlesCount' => $publishedArticlesCount,

                'draftArticlesCount' => $draftArticlesCount,

                'featuredArticlesCount' => $featuredArticlesCount,

                'deletedArticlesCount' => $deletedArticlesCount,
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
         * si le titre ne génère exceptionnellement aucun slug,
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
         *
         * On vérifie également les articles supprimés afin d'éviter
         * deux articles possédant le même slug en cas de restauration.
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
         * La bannière n'est pas obligatoire lors d'une modification.
         *
         * Si aucune nouvelle bannière n'est envoyée,
         * l'ancienne est conservée.
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
         * On ignore l'article actuellement modifié.
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
         */
        $bannerPath = $article->banner_image;


        /**
         * -----------------------------------------------------------
         * NOUVELLE BANNIÈRE
         * -----------------------------------------------------------
         */
        if ($request->hasFile('banner_image')) {
            /**
             * On mémorise le chemin de l'ancienne bannière.
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
             * Suppression de l'ancienne bannière physique.
             *
             * Ici c'est logique car elle vient réellement d'être
             * remplacée par une nouvelle image.
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
             * Si l'article était déjà publié, on conserve sa
             * première date de publication.
             *
             * S'il passe de brouillon à publié, on utilise maintenant.
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


    /**
     * ===============================================================
     * SUPPRESSION D'UN ARTICLE
     * ===============================================================
     *
     * Grâce à SoftDeletes, delete() ne supprime pas définitivement
     * l'article de la base de données.
     *
     * Laravel renseigne simplement la colonne deleted_at.
     *
     * Exemple :
     *
     * deleted_at = 2026-09-13 14:30:00
     *
     * L'article pourra donc être restauré plus tard.
     *
     * IMPORTANT :
     *
     * Nous ne supprimons PAS la bannière du stockage ici.
     *
     * Pourquoi ?
     *
     * Parce qu'une suppression douce doit rester réversible.
     * Si l'article est restauré, sa bannière doit également
     * réapparaître immédiatement.
     * ===============================================================
     */
    public function destroy(Article $article): RedirectResponse
    {
        /**
         * -----------------------------------------------------------
         * SUPPRESSION DOUCE
         * -----------------------------------------------------------
         */
        $article->delete();


        /**
         * -----------------------------------------------------------
         * RETOUR À LA LISTE
         * -----------------------------------------------------------
         */
        return redirect()
            ->route('admin.articles.index')
            ->with(
                'success',
                'L’article a été supprimé avec succès.'
            );
    }


    /**
     * ===============================================================
     * RESTAURATION D'UN ARTICLE SUPPRIMÉ
     * ===============================================================
     *
     * Contrairement aux méthodes edit(), update() et destroy(),
     * nous n'utilisons pas directement :
     *
     * Article $article
     *
     * dans les paramètres.
     *
     * Pourquoi ?
     *
     * Le Route Model Binding classique de Laravel ne récupère pas
     * automatiquement les modèles supprimés par SoftDeletes.
     *
     * Nous récupérons donc manuellement l'article grâce à son ID
     * avec withTrashed().
     * ===============================================================
     */
    public function restore(int $id): RedirectResponse
    {
        /**
         * -----------------------------------------------------------
         * RECHERCHE DE L'ARTICLE
         * -----------------------------------------------------------
         *
         * withTrashed() permet de rechercher également parmi les
         * articles dont deleted_at n'est pas NULL.
         *
         * findOrFail() provoque une erreur 404 si l'article
         * demandé n'existe pas.
         */
        $article = Article::withTrashed()
            ->findOrFail($id);


        /**
         * -----------------------------------------------------------
         * VÉRIFICATION
         * -----------------------------------------------------------
         *
         * Nous ne lançons la restauration que si l'article est
         * réellement supprimé.
         */
        if ($article->trashed()) {
            $article->restore();
        }


        /**
         * -----------------------------------------------------------
         * RETOUR À LA LISTE
         * -----------------------------------------------------------
         */
        return redirect()
            ->route('admin.articles.index')
            ->with(
                'success',
                'L’article a été restauré avec succès.'
            );
    }
}