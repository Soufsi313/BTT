@extends('layouts.app')


@section('title', $article->title . ' - Brussels Top Team')


@section(
    'meta_description',
    $article->excerpt
)


@section('content')

    <!-- =========================================================
         ARTICLE DU BLOG
         ========================================================= -->
    <article class="bg-zinc-950">


        <!-- =====================================================
             EN-TÊTE DE L'ARTICLE
             ===================================================== -->
        <section
            class="
                border-b
                border-zinc-900
                bg-black
                px-6
                py-16
                lg:px-8
                lg:py-20
            "
        >

            <div class="mx-auto max-w-5xl">


                <!-- =============================================
                     RETOUR AU BLOG
                     ============================================= -->
                <a
                    href="{{ route('blog') }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        text-sm
                        font-black
                        uppercase
                        tracking-wider
                        text-zinc-400
                        transition
                        hover:text-red-500
                    "
                >
                    ← Retour aux actualités
                </a>


                <!-- =============================================
                     CATÉGORIE
                     ============================================= -->
                <div class="mt-10">

                    <span
                        class="
                            inline-flex
                            bg-red-600
                            px-4
                            py-2
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                        "
                    >
                        {{ $article->category }}
                    </span>

                </div>


                <!-- =============================================
                     TITRE
                     ============================================= -->
                <h1
                    class="
                        mt-6
                        max-w-5xl
                        text-4xl
                        font-black
                        uppercase
                        leading-tight
                        tracking-tight
                        text-white
                        sm:text-5xl
                        lg:text-6xl
                    "
                >
                    {{ $article->title }}
                </h1>


                <!-- =============================================
                     EXTRAIT
                     ============================================= -->
                @if ($article->excerpt)

                    <p
                        class="
                            mt-7
                            max-w-4xl
                            text-lg
                            leading-8
                            text-zinc-400
                        "
                    >
                        {{ $article->excerpt }}
                    </p>

                @endif


                <!-- =============================================
                     INFORMATIONS DE PUBLICATION
                     ============================================= -->
                <div
                    class="
                        mt-10
                        flex
                        flex-wrap
                        items-center
                        gap-x-6
                        gap-y-3
                        border-t
                        border-zinc-800
                        pt-6
                        text-sm
                        text-zinc-500
                    "
                >

                    <!-- AUTEUR -->
                    <span>

                        Par

                        <strong class="text-zinc-300">

                            @if ($article->author)

                                {{ $article->author->prenom }}
                                {{ $article->author->nom }}

                            @else

                                Brussels Top Team

                            @endif

                        </strong>

                    </span>


                    <!-- DATE -->
                    @if ($article->published_at)

                        <span>
                            {{ $article->published_at->format('d/m/Y à H:i') }}
                        </span>

                    @endif


                    <!-- ARTICLE À LA UNE -->
                    @if ($article->is_featured)

                        <span
                            class="
                                font-black
                                uppercase
                                tracking-wider
                                text-red-500
                            "
                        >
                            À la une
                        </span>

                    @endif

                </div>

            </div>

        </section>


        <!-- =====================================================
             BANNIÈRE DE L'ARTICLE
             ===================================================== -->
        @if ($article->banner_image)

            <section
                class="
                    border-b
                    border-zinc-900
                    bg-black
                    px-6
                    py-8
                    lg:px-8
                "
            >

                <div class="mx-auto max-w-6xl">

                    <img
                        src="{{ asset('storage/' . $article->banner_image) }}"
                        alt="{{ $article->title }}"
                        class="
                            mx-auto
                            max-h-[700px]
                            w-full
                            object-contain
                        "
                    >

                </div>

            </section>

        @endif


        <!-- =====================================================
             CONTENU DE L'ARTICLE
             ===================================================== -->
        <section
            class="
                bg-zinc-950
                px-6
                py-16
                lg:px-8
                lg:py-20
            "
        >

            <div class="mx-auto max-w-4xl">


                <!-- =============================================
                     CONTENU HTML GÉNÉRÉ PAR QUILL
                     ============================================= -->
                <div class="article-content">
                    {!! $article->content !!}
                </div>


                <!-- =============================================
                     LIKES DE L'ARTICLE
                     ============================================= -->
                <div
                    class="
                        mt-16
                        border-y
                        border-zinc-800
                        py-8
                    "
                >

                    <div
                        class="
                            flex
                            flex-col
                            gap-5
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <!-- =====================================
                             COMPTEUR
                             ===================================== -->
                        <div>

                            <p
                                class="
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-[0.25em]
                                    text-zinc-500
                                "
                            >
                                Vous avez aimé cet article ?
                            </p>


                            <div
                                class="
                                    mt-2
                                    flex
                                    items-center
                                    gap-3
                                "
                            >

                                <!-- CŒUR -->
                                <span
                                    class="
                                        text-2xl
                                        {{ $article->likes_count > 0
                                            ? 'text-red-500'
                                            : 'text-zinc-600'
                                        }}
                                    "
                                >
                                    ♥
                                </span>


                                <!-- NOMBRE DE LIKES -->
                                <p
                                    class="
                                        text-sm
                                        font-bold
                                        text-zinc-300
                                    "
                                >

                                    <span
                                        class="
                                            text-lg
                                            font-black
                                            text-white
                                        "
                                    >
                                        {{ $article->likes_count }}
                                    </span>

                                    @if ($article->likes_count > 1)

                                        personnes aiment cet article

                                    @elseif ($article->likes_count === 1)

                                        personne aime cet article

                                    @else

                                        Aucun like pour le moment

                                    @endif

                                </p>

                            </div>

                        </div>


                        <!-- =====================================
                             UTILISATEUR CONNECTÉ
                             ===================================== -->
                        @auth

                            <form
                                action="{{ route('article.likes.toggle', $article->slug) }}"
                                method="POST"
                            >

                                @csrf


                                @if ($hasLiked)

                                    <!-- =============================
                                         RETIRER SON LIKE
                                         ============================= -->
                                    <button
                                        type="submit"
                                        class="
                                            inline-flex
                                            items-center
                                            justify-center
                                            gap-2
                                            rounded-md
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
                                        <span class="text-lg">
                                            ♥
                                        </span>

                                        J'aime
                                    </button>

                                @else

                                    <!-- =============================
                                         AJOUTER UN LIKE
                                         ============================= -->
                                    <button
                                        type="submit"
                                        class="
                                            inline-flex
                                            items-center
                                            justify-center
                                            gap-2
                                            rounded-md
                                            border
                                            border-zinc-700
                                            bg-zinc-900
                                            px-6
                                            py-3
                                            text-sm
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-white
                                            transition
                                            hover:border-red-600
                                            hover:bg-red-600
                                        "
                                    >
                                        <span class="text-lg">
                                            ♡
                                        </span>

                                        J'aime
                                    </button>

                                @endif

                            </form>

                        @endauth


                        <!-- =====================================
                             VISITEUR NON CONNECTÉ
                             ===================================== -->
                        @guest

                            <a
                                href="{{ route('login') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-md
                                    border
                                    border-zinc-700
                                    px-6
                                    py-3
                                    text-sm
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-300
                                    transition
                                    hover:border-red-600
                                    hover:text-red-500
                                "
                            >
                                <span class="text-lg">
                                    ♡
                                </span>

                                Connectez-vous pour aimer
                            </a>

                        @endguest

                    </div>

                </div>

            </div>

        </section>

    </article>


    <!-- =========================================================
         COMMENTAIRES
         ========================================================= -->
    <section
        id="commentaires"
        class="
            border-t
            border-zinc-900
            bg-black
            px-6
            py-16
            lg:px-8
            lg:py-20
        "
    >

        <div class="mx-auto max-w-4xl">


            <!-- =================================================
                 EN-TÊTE DES COMMENTAIRES
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-4
                    border-b
                    border-zinc-800
                    pb-8
                    sm:flex-row
                    sm:items-end
                    sm:justify-between
                "
            >

                <div>

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.3em]
                            text-red-500
                        "
                    >
                        Discussions
                    </p>


                    <h2
                        class="
                            mt-3
                            text-3xl
                            font-black
                            uppercase
                            tracking-tight
                            text-white
                        "
                    >
                        Commentaires
                    </h2>

                </div>


                <!-- =============================================
                     NOMBRE DE COMMENTAIRES
                     ============================================= -->
                <p
                    class="
                        text-sm
                        font-bold
                        text-zinc-500
                    "
                >

                    {{ $article->comments->count() }}

                    @if ($article->comments->count() > 1)

                        commentaires

                    @else

                        commentaire

                    @endif

                </p>

            </div>


            <!-- =================================================
                 MESSAGE DE SUCCÈS
                 ================================================= -->
            @if (session('success'))

                <div
                    class="
                        mt-8
                        border
                        border-green-800
                        bg-green-950/40
                        px-5
                        py-4
                        text-sm
                        font-bold
                        text-green-400
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            <!-- =================================================
                 ERREURS DE VALIDATION
                 ================================================= -->
            @if ($errors->any())

                <div
                    class="
                        mt-8
                        border
                        border-red-900
                        bg-red-950/30
                        px-5
                        py-4
                    "
                >

                    <p
                        class="
                            text-sm
                            font-black
                            text-red-400
                        "
                    >
                        Votre commentaire n'a pas pu être publié.
                    </p>


                    <ul
                        class="
                            mt-3
                            list-disc
                            space-y-1
                            pl-5
                            text-sm
                            text-red-300
                        "
                    >

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- =================================================
                 FORMULAIRE MEMBRE CONNECTÉ
                 ================================================= -->
            @auth

                <div
                    class="
                        mt-10
                        border
                        border-zinc-800
                        bg-zinc-950
                        p-6
                        sm:p-8
                    "
                >

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                        "
                    >

                        <!-- AVATAR -->
                        <div
                            class="
                                flex
                                h-10
                                w-10
                                shrink-0
                                items-center
                                justify-center
                                rounded-full
                                bg-red-600
                                text-sm
                                font-black
                                uppercase
                                text-white
                            "
                        >
                            {{ mb_substr(auth()->user()->pseudo, 0, 1) }}
                        </div>


                        <div>

                            <p
                                class="
                                    text-sm
                                    font-black
                                    text-white
                                "
                            >
                                {{ auth()->user()->pseudo }}
                            </p>


                            <p class="text-xs text-zinc-500">
                                Publier un commentaire
                            </p>

                        </div>

                    </div>


                    <!-- =============================================
                         FORMULAIRE
                         ============================================= -->
                    <form
                        action="{{ route('comments.store', $article->slug) }}"
                        method="POST"
                        class="mt-6"
                    >

                        @csrf


                        <label
                            for="body"
                            class="sr-only"
                        >
                            Votre commentaire
                        </label>


                        <textarea
                            id="body"
                            name="body"
                            rows="5"
                            required
                            maxlength="2000"
                            placeholder="Écrivez votre commentaire..."
                            class="
                                w-full
                                resize-y
                                rounded-md
                                border
                                border-zinc-800
                                bg-black
                                px-5
                                py-4
                                text-sm
                                leading-7
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-red-600
                            "
                        >{{ old('body') }}</textarea>


                        <div
                            class="
                                mt-4
                                flex
                                flex-col
                                gap-3
                                sm:flex-row
                                sm:items-center
                                sm:justify-between
                            "
                        >

                            <p
                                class="
                                    text-xs
                                    text-zinc-600
                                "
                            >
                                Maximum 2 000 caractères.
                            </p>


                            <button
                                type="submit"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-md
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
                                Publier
                            </button>

                        </div>

                    </form>

                </div>

            @endauth


            <!-- =================================================
                 VISITEUR NON CONNECTÉ
                 ================================================= -->
            @guest

                <div
                    class="
                        mt-10
                        border
                        border-zinc-800
                        bg-zinc-950
                        px-6
                        py-8
                    "
                >

                    <p
                        class="
                            text-lg
                            font-black
                            text-white
                        "
                    >
                        Participez à la discussion
                    </p>


                    <p
                        class="
                            mt-3
                            max-w-2xl
                            text-sm
                            leading-6
                            text-zinc-500
                        "
                    >
                        Vous devez être connecté à votre compte Brussels Top Team
                        pour publier un commentaire.
                    </p>


                    <div
                        class="
                            mt-6
                            flex
                            flex-wrap
                            gap-3
                        "
                    >

                        <a
                            href="{{ route('login') }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-md
                                bg-red-600
                                px-5
                                py-3
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-white
                                transition
                                hover:bg-red-700
                            "
                        >
                            Se connecter
                        </a>


                        <a
                            href="{{ route('register') }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-md
                                border
                                border-zinc-700
                                px-5
                                py-3
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-300
                                transition
                                hover:border-red-600
                                hover:text-red-500
                            "
                        >
                            Créer un compte
                        </a>

                    </div>

                </div>

            @endguest


            <!-- =================================================
                 LISTE DES COMMENTAIRES
                 ================================================= -->
            <div class="mt-12">

                @forelse ($article->comments as $comment)

                    <article
                        class="
                            border-t
                            border-zinc-800
                            py-8
                            first:border-t-0
                            first:pt-0
                        "
                    >

                        <div
                            class="
                                flex
                                items-start
                                gap-4
                            "
                        >

                            <!-- =====================================
                                 AVATAR
                                 ===================================== -->
                            <div
                                class="
                                    flex
                                    h-11
                                    w-11
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-red-600
                                    text-sm
                                    font-black
                                    uppercase
                                    text-white
                                "
                            >

                                @if ($comment->user)

                                    {{ mb_substr($comment->user->pseudo, 0, 1) }}

                                @else

                                    B

                                @endif

                            </div>


                            <!-- =====================================
                                 COMMENTAIRE
                                 ===================================== -->
                            <div class="min-w-0 flex-1">


                                <!-- =================================
                                     AUTEUR ET DATE
                                     ================================= -->
                                <div
                                    class="
                                        flex
                                        flex-col
                                        gap-1
                                        sm:flex-row
                                        sm:items-center
                                        sm:justify-between
                                    "
                                >

                                    <p
                                        class="
                                            font-black
                                            text-white
                                        "
                                    >

                                        @if ($comment->user)

                                            {{ $comment->user->pseudo }}

                                        @else

                                            Ancien membre BTT

                                        @endif

                                    </p>


                                    <time
                                        datetime="{{ $comment->created_at->toIso8601String() }}"
                                        class="
                                            text-xs
                                            text-zinc-600
                                        "
                                    >
                                        {{ $comment->created_at->format('d/m/Y à H:i') }}
                                    </time>

                                </div>


                                <!-- =================================
                                     TEXTE
                                     ================================= -->
                                <div
                                    class="
                                        mt-4
                                        whitespace-pre-line
                                        break-words
                                        text-sm
                                        leading-7
                                        text-zinc-300
                                    "
                                >{{ $comment->body }}</div>

                            </div>

                        </div>

                    </article>

                @empty

                    <!-- =============================================
                         AUCUN COMMENTAIRE
                         ============================================= -->
                    <div
                        class="
                            border-t
                            border-zinc-800
                            py-12
                            text-center
                        "
                    >

                        <p
                            class="
                                font-black
                                text-white
                            "
                        >
                            Aucun commentaire pour le moment
                        </p>


                        <p
                            class="
                                mt-2
                                text-sm
                                text-zinc-500
                            "
                        >
                            Soyez le premier à réagir à cet article.
                        </p>

                    </div>

                @endforelse

            </div>


            <!-- =================================================
                 RETOUR AU BLOG
                 ================================================= -->
            <div
                class="
                    mt-12
                    border-t
                    border-zinc-800
                    pt-8
                "
            >

                <a
                    href="{{ route('blog') }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        text-sm
                        font-black
                        uppercase
                        tracking-wider
                        text-zinc-400
                        transition
                        hover:text-red-500
                    "
                >
                    ← Retour aux actualités
                </a>

            </div>

        </div>

    </section>


    <!-- =========================================================
         STYLES DU CONTENU QUILL
         =========================================================
         Le contenu des articles est enregistré sous forme de HTML.

         Ces styles permettent de restituer publiquement :
         - les paragraphes ;
         - les titres ;
         - les listes ;
         - les alignements ;
         - les citations ;
         - les tailles de texte ;
         - les polices ;
         - les images insérées dans l'article.
         ========================================================= -->
    <style>

        /*
        |--------------------------------------------------------------------------
        | CONTENEUR PRINCIPAL
        |--------------------------------------------------------------------------
        */
        .article-content {
            color: #d4d4d8;
            font-size: 1.05rem;
            line-height: 1.9;
            overflow-wrap: anywhere;
        }


        /*
        |--------------------------------------------------------------------------
        | PARAGRAPHES
        |--------------------------------------------------------------------------
        */
        .article-content p {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .article-content p:first-child {
            margin-top: 0;
        }

        .article-content p:last-child {
            margin-bottom: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | TITRES
        |--------------------------------------------------------------------------
        */
        .article-content h1 {
            margin-top: 3rem;
            margin-bottom: 1.25rem;
            color: #ffffff;
            font-size: 2.25rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .article-content h2 {
            margin-top: 2.75rem;
            margin-bottom: 1.25rem;
            color: #ffffff;
            font-size: 1.875rem;
            font-weight: 900;
            line-height: 1.2;
        }

        .article-content h3 {
            margin-top: 2.25rem;
            margin-bottom: 1rem;
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 900;
            line-height: 1.3;
        }


        /*
        |--------------------------------------------------------------------------
        | STYLE DU TEXTE
        |--------------------------------------------------------------------------
        */
        .article-content strong {
            color: #ffffff;
            font-weight: 800;
        }

        .article-content em {
            font-style: italic;
        }

        .article-content u {
            text-decoration: underline;
        }

        .article-content s {
            text-decoration: line-through;
        }


        /*
        |--------------------------------------------------------------------------
        | LIENS
        |--------------------------------------------------------------------------
        */
        .article-content a {
            color: #ef4444;
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .article-content a:hover {
            color: #dc2626;
        }


        /*
        |--------------------------------------------------------------------------
        | LISTES
        |--------------------------------------------------------------------------
        */
        .article-content ul,
        .article-content ol {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .article-content ul {
            list-style-type: disc;
        }

        .article-content ol {
            list-style-type: decimal;
        }

        .article-content li {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            padding-left: 0.3rem;
        }


        /*
        |--------------------------------------------------------------------------
        | CITATIONS
        |--------------------------------------------------------------------------
        */
        .article-content blockquote {
            margin-top: 2rem;
            margin-bottom: 2rem;
            border-left: 4px solid #dc2626;
            background: #09090b;
            padding: 1.5rem 1.75rem;
            color: #a1a1aa;
            font-style: italic;
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGES INSÉRÉES AVEC QUILL
        |--------------------------------------------------------------------------
        */
        .article-content img {
            display: block;
            max-width: 100%;
            max-height: 750px;
            margin: 2.5rem auto;
            object-fit: contain;
        }


        /*
        |--------------------------------------------------------------------------
        | ALIGNEMENTS QUILL
        |--------------------------------------------------------------------------
        */
        .article-content .ql-align-center {
            text-align: center;
        }

        .article-content .ql-align-right {
            text-align: right;
        }

        .article-content .ql-align-justify {
            text-align: justify;
        }


        /*
        |--------------------------------------------------------------------------
        | INDENTATIONS QUILL
        |--------------------------------------------------------------------------
        */
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


        /*
        |--------------------------------------------------------------------------
        | TAILLES DE TEXTE QUILL
        |--------------------------------------------------------------------------
        */
        .article-content .ql-size-small {
            font-size: 0.75em;
        }

        .article-content .ql-size-large {
            font-size: 1.5em;
        }

        .article-content .ql-size-huge {
            font-size: 2.5em;
            line-height: 1.2;
        }


        /*
        |--------------------------------------------------------------------------
        | POLICES QUILL
        |--------------------------------------------------------------------------
        */
        .article-content .ql-font-serif {
            font-family: Georgia, "Times New Roman", serif;
        }

        .article-content .ql-font-monospace {
            font-family:
                Monaco,
                "Courier New",
                monospace;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */
        @media (max-width: 640px) {

            .article-content {
                font-size: 1rem;
                line-height: 1.8;
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

            .article-content .ql-indent-1,
            .article-content .ql-indent-2,
            .article-content .ql-indent-3,
            .article-content .ql-indent-4,
            .article-content .ql-indent-5,
            .article-content .ql-indent-6,
            .article-content .ql-indent-7,
            .article-content .ql-indent-8 {
                padding-left: 1.5rem;
            }

        }

    </style>

@endsection