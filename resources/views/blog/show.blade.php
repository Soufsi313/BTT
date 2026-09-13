@extends('layouts.app')


@section('title', $article->title . ' - Brussels Top Team')


@section(
    'meta_description',
    $article->excerpt
        ?: 'Découvrez cette actualité du Brussels Top Team.'
)


@section('content')

    {{-- =========================================================
         PAGE PUBLIQUE D'UN ARTICLE
         =========================================================
         Cette page affiche le contenu HTML généré par Quill.

         Elle prend en charge :
         - le gras ;
         - l'italique ;
         - le soulignement ;
         - les couleurs ;
         - les titres ;
         - les différentes polices ;
         - les tailles ;
         - les alignements ;
         - les listes ;
         - les citations ;
         - les liens ;
         - les espacements ;
         - les retours à la ligne ;
         - les tabulations.
         ========================================================= --}}

    <section class="min-h-screen bg-zinc-950 text-white">


        {{-- =====================================================
             STYLES DU CONTENU QUILL
             ===================================================== --}}
        <style>

            /* =====================================================
               CONTENEUR PRINCIPAL DU TEXTE
               ===================================================== */
            .article-content {
                font-size: 1.0625rem;
                line-height: 1.9;
                color: #d4d4d8;

                /*
                |--------------------------------------------------------------------------
                | GESTION DES ESPACES ET RETOURS À LA LIGNE
                |--------------------------------------------------------------------------
                |
                | "pre-wrap" permet de conserver :
                |
                | - les retours à la ligne ;
                | - plusieurs espaces successifs ;
                | - les tabulations ;
                |
                | tout en permettant au texte de revenir automatiquement
                | à la ligne sur les petits écrans.
                |
                */
                white-space: pre-wrap;

                /*
                |--------------------------------------------------------------------------
                | LARGEUR D'UNE TABULATION
                |--------------------------------------------------------------------------
                |
                | Une tabulation correspond ici à environ quatre espaces.
                |
                */
                tab-size: 4;

                /*
                |--------------------------------------------------------------------------
                | MOTS TROP LONGS
                |--------------------------------------------------------------------------
                |
                | Évite qu'un mot ou une adresse très longue déborde
                | de la page sur mobile.
                |
                */
                overflow-wrap: break-word;
            }


            /* =====================================================
               PARAGRAPHES
               ===================================================== */
            .article-content p {
                margin-top: 0;
                margin-bottom: 1.5rem;
            }


            /*
            |--------------------------------------------------------------------------
            | PARAGRAPHE VIDE QUILL
            |--------------------------------------------------------------------------
            |
            | Quill utilise parfois :
            |
            | <p><br></p>
            |
            | pour créer une ligne vide.
            |
            | Nous lui laissons une hauteur afin que l'espacement
            | voulu dans l'éditeur reste visible dans l'article.
            |
            */
            .article-content p:has(> br:only-child) {
                min-height: 1.5rem;
            }


            /* =====================================================
               TITRES
               ===================================================== */
            .article-content h1,
            .article-content h2,
            .article-content h3 {
                color: #ffffff;
                font-weight: 900;
                line-height: 1.2;
            }

            .article-content h1 {
                margin-top: 2.5rem;
                margin-bottom: 1.25rem;
                font-size: 2.25rem;
            }

            .article-content h2 {
                margin-top: 2.25rem;
                margin-bottom: 1rem;
                font-size: 1.875rem;
            }

            .article-content h3 {
                margin-top: 2rem;
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }


            /* =====================================================
               GRAS
               ===================================================== */
            .article-content strong {
                color: #ffffff;
                font-weight: 800;
            }


            /* =====================================================
               ITALIQUE
               ===================================================== */
            .article-content em {
                font-style: italic;
            }


            /* =====================================================
               SOULIGNEMENT
               ===================================================== */
            .article-content u {
                text-decoration: underline;
                text-underline-offset: 3px;
            }


            /* =====================================================
               TEXTE BARRÉ
               ===================================================== */
            .article-content s {
                text-decoration: line-through;
            }


            /* =====================================================
               ALIGNEMENTS QUILL
               ===================================================== */

            /* Alignement centré */
            .article-content .ql-align-center {
                text-align: center;
            }

            /* Alignement à droite */
            .article-content .ql-align-right {
                text-align: right;
            }

            /* Alignement justifié */
            .article-content .ql-align-justify {
                text-align: justify;
            }


            /* =====================================================
               TAILLES QUILL
               ===================================================== */

            .article-content .ql-size-small {
                font-size: 0.875em;
            }

            .article-content .ql-size-large {
                font-size: 1.5em;
            }

            .article-content .ql-size-huge {
                font-size: 2.5em;
                line-height: 1.2;
            }


            /* =====================================================
               POLICES QUILL
               ===================================================== */

            .article-content .ql-font-arial {
                font-family: Arial, sans-serif;
            }

            .article-content .ql-font-georgia {
                font-family: Georgia, serif;
            }

            .article-content .ql-font-times-new-roman {
                font-family: "Times New Roman", Times, serif;
            }

            .article-content .ql-font-verdana {
                font-family: Verdana, sans-serif;
            }

            .article-content .ql-font-courier-new {
                font-family: "Courier New", Courier, monospace;
            }


            /* =====================================================
               LISTES
               ===================================================== */
            .article-content ol,
            .article-content ul {
                margin-top: 1.25rem;
                margin-bottom: 1.5rem;
                padding-left: 1.75rem;
            }

            .article-content ol {
                list-style-type: decimal;
            }

            .article-content ul {
                list-style-type: disc;
            }

            .article-content li {
                margin-bottom: 0.5rem;
            }


            /* =====================================================
               LISTES QUILL 2
               =====================================================
               Quill 2 peut enregistrer le type de liste avec
               l'attribut data-list.
               ===================================================== */

            .article-content li[data-list="bullet"] {
                list-style-type: disc;
            }

            .article-content li[data-list="ordered"] {
                list-style-type: decimal;
            }


            /* =====================================================
               INDENTATION QUILL
               =====================================================
               Ces classes correspondent aux boutons :
               - diminuer le retrait ;
               - augmenter le retrait.
               ===================================================== */

            .article-content .ql-indent-1 {
                padding-left: 3em;
            }

            .article-content .ql-indent-2 {
                padding-left: 6em;
            }

            .article-content .ql-indent-3 {
                padding-left: 9em;
            }

            .article-content .ql-indent-4 {
                padding-left: 12em;
            }

            .article-content .ql-indent-5 {
                padding-left: 15em;
            }

            .article-content .ql-indent-6 {
                padding-left: 18em;
            }

            .article-content .ql-indent-7 {
                padding-left: 21em;
            }

            .article-content .ql-indent-8 {
                padding-left: 24em;
            }


            /* =====================================================
               CITATIONS
               ===================================================== */
            .article-content blockquote {
                margin-top: 2rem;
                margin-bottom: 2rem;

                border-left: 4px solid #dc2626;

                background: #18181b;

                padding: 1.25rem 1.5rem;

                color: #e4e4e7;

                font-style: italic;
            }


            /* =====================================================
               LIENS
               ===================================================== */
            .article-content a {
                color: #ef4444;

                text-decoration: underline;
                text-underline-offset: 3px;

                transition: color 0.2s ease;
            }

            .article-content a:hover {
                color: #f87171;
            }


            /* =====================================================
               IMAGES DANS LE CONTENU
               =====================================================
               Cette partie est déjà préparée pour la prochaine
               étape : insertion d'images directement dans Quill.
               ===================================================== */
            .article-content img {
                display: block;

                max-width: 100%;
                height: auto;

                margin: 2rem auto;
            }


            /* =====================================================
               RESPONSIVE MOBILE
               ===================================================== */
            @media (max-width: 640px) {

                .article-content {
                    font-size: 1rem;
                    line-height: 1.8;

                    /*
                    |--------------------------------------------------
                    | Les espaces sont toujours conservés sur mobile,
                    | mais le retour automatique à la ligne reste actif.
                    |--------------------------------------------------
                    */
                    white-space: pre-wrap;
                }


                .article-content h1 {
                    font-size: 1.875rem;
                }


                .article-content h2 {
                    font-size: 1.625rem;
                }


                .article-content h3 {
                    font-size: 1.375rem;
                }


                .article-content .ql-size-huge {
                    font-size: 2rem;
                }


                /*
                |------------------------------------------------------
                | INDENTATIONS SUR MOBILE
                |------------------------------------------------------
                |
                | On réduit volontairement les retraits afin d'éviter
                | qu'un texte très indenté ne devienne trop étroit.
                |
                */
                .article-content .ql-indent-1 {
                    padding-left: 1.5em;
                }

                .article-content .ql-indent-2 {
                    padding-left: 3em;
                }

                .article-content .ql-indent-3 {
                    padding-left: 4.5em;
                }

                .article-content .ql-indent-4,
                .article-content .ql-indent-5,
                .article-content .ql-indent-6,
                .article-content .ql-indent-7,
                .article-content .ql-indent-8 {
                    padding-left: 5em;
                }

            }

        </style>


        {{-- =====================================================
             EN-TÊTE DE L'ARTICLE
             ===================================================== --}}
        <section
            class="
                border-b
                border-zinc-800
                bg-black
                px-6
                py-14
                lg:px-8
                lg:py-20
            "
        >

            <div class="mx-auto max-w-7xl">


                {{-- =================================================
                     RETOUR AU BLOG
                     ================================================= --}}
                <a
                    href="{{ route('blog') }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        text-sm
                        font-bold
                        text-zinc-400
                        transition
                        hover:text-red-500
                    "
                >
                    ← Toutes les actualités
                </a>


                <div class="mt-10 max-w-5xl">


                    {{-- =============================================
                         CATÉGORIE ET MISE EN AVANT
                         ============================================= --}}
                    <div class="flex flex-wrap items-center gap-3">

                        <span
                            class="
                                inline-flex
                                bg-red-600
                                px-3
                                py-1.5
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-white
                            "
                        >
                            {{ $article->category }}
                        </span>


                        @if ($article->is_featured)

                            <span
                                class="
                                    inline-flex
                                    border
                                    border-red-600/50
                                    bg-red-600/10
                                    px-3
                                    py-1.5
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-red-400
                                "
                            >
                                À la une
                            </span>

                        @endif

                    </div>


                    {{-- =============================================
                         TITRE
                         ============================================= --}}
                    <h1
                        class="
                            mt-6
                            text-4xl
                            font-black
                            leading-tight
                            tracking-tight
                            text-white
                            sm:text-5xl
                            lg:text-6xl
                        "
                    >
                        {{ $article->title }}
                    </h1>


                    {{-- =============================================
                         RÉSUMÉ
                         ============================================= --}}
                    @if ($article->excerpt)

                        <p
                            class="
                                mt-7
                                max-w-4xl
                                text-lg
                                leading-8
                                text-zinc-400
                                sm:text-xl
                            "
                        >
                            {{ $article->excerpt }}
                        </p>

                    @endif


                    {{-- =============================================
                         INFORMATIONS DE PUBLICATION
                         ============================================= --}}
                    <div
                        class="
                            mt-8
                            flex
                            flex-wrap
                            items-center
                            gap-x-5
                            gap-y-2
                            text-sm
                            text-zinc-500
                        "
                    >

                        @if ($article->published_at)

                            <span>
                                {{ $article->published_at->format('d/m/Y') }}
                            </span>

                        @endif


                        @if ($article->author)

                            <span class="hidden sm:inline">
                                •
                            </span>

                            <span>
                                Par

                                <strong class="font-bold text-zinc-300">
                                    {{ $article->author->prenom }}
                                    {{ $article->author->nom }}
                                </strong>
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             BANNIÈRE DE L'ARTICLE
             ===================================================== --}}
        @if ($article->banner_image)

            <section
                class="
                    border-b
                    border-zinc-900
                    bg-zinc-950
                    px-4
                    py-8
                    sm:px-6
                    lg:px-8
                    lg:py-12
                "
            >

                <div class="mx-auto max-w-7xl">

                    <div
                        class="
                            overflow-hidden
                            border
                            border-zinc-800
                            bg-black
                        "
                    >

                        <img
                            src="{{ asset('storage/' . $article->banner_image) }}"
                            alt="{{ $article->title }}"
                            class="
                                mx-auto
                                max-h-[650px]
                                w-full
                                object-contain
                            "
                        >

                    </div>

                </div>

            </section>

        @endif


        {{-- =====================================================
             CORPS DE L'ARTICLE
             ===================================================== --}}
        <section
            class="
                bg-zinc-950
                px-6
                py-14
                lg:px-8
                lg:py-20
            "
        >

            <div
                class="
                    mx-auto
                    grid
                    max-w-7xl
                    gap-12
                    lg:grid-cols-[minmax(0,1fr)_280px]
                    lg:gap-16
                "
            >


                {{-- =================================================
                     CONTENU PRINCIPAL
                     ================================================= --}}
                <article class="min-w-0">


                    {{-- =============================================
                         CONTENU HTML QUILL
                         =============================================
                         Le contenu est enregistré par l'éditeur Quill
                         réservé à l'administration.

                         Il doit donc être interprété comme du HTML afin
                         que les balises de mise en forme fonctionnent.

                         Exemple :

                         <strong>Texte</strong>

                         donnera visuellement un texte en gras au lieu
                         d'afficher les balises à l'écran.
                         ============================================= --}}
                    <div class="article-content">{!! $article->content !!}</div>

                </article>


                {{-- =================================================
                     COLONNE LATÉRALE
                     ================================================= --}}
                <aside class="lg:border-l lg:border-zinc-800 lg:pl-8">

                    <div class="lg:sticky lg:top-28">


                        {{-- =========================================
                             BRUSSELS TOP TEAM
                             ========================================= --}}
                        <div class="border-t-2 border-red-600 pt-5">

                            <p
                                class="
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-[0.3em]
                                    text-red-500
                                "
                            >
                                Brussels Top Team
                            </p>

                            <p
                                class="
                                    mt-4
                                    text-sm
                                    leading-6
                                    text-zinc-400
                                "
                            >
                                Retrouvez les actualités, événements
                                et informations du Brussels Top Team.
                            </p>

                        </div>


                        {{-- =========================================
                             CATÉGORIE
                             ========================================= --}}
                        <div
                            class="
                                mt-8
                                border-t
                                border-zinc-800
                                pt-6
                            "
                        >

                            <p
                                class="
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-500
                                "
                            >
                                Catégorie
                            </p>

                            <p
                                class="
                                    mt-2
                                    font-black
                                    text-white
                                "
                            >
                                {{ $article->category }}
                            </p>

                        </div>


                        {{-- =========================================
                             DATE DE PUBLICATION
                             ========================================= --}}
                        @if ($article->published_at)

                            <div
                                class="
                                    mt-6
                                    border-t
                                    border-zinc-800
                                    pt-6
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Publié le
                                </p>

                                <p
                                    class="
                                        mt-2
                                        font-bold
                                        text-zinc-300
                                    "
                                >
                                    {{ $article->published_at->format('d/m/Y') }}
                                </p>

                            </div>

                        @endif

                    </div>

                </aside>

            </div>

        </section>


        {{-- =====================================================
             RETOUR AU BLOG
             ===================================================== --}}
        <section
            class="
                border-t
                border-zinc-900
                bg-black
                px-6
                py-12
                lg:px-8
            "
        >

            <div class="mx-auto max-w-7xl">

                <a
                    href="{{ route('blog') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        bg-red-600
                        px-6
                        py-3
                        text-sm
                        font-black
                        uppercase
                        tracking-wider
                        text-white
                        transition
                        hover:bg-red-700
                    "
                >
                    ← Retour aux actualités
                </a>

            </div>

        </section>

    </section>

@endsection