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
    <article class="bg-zinc-950 text-white">


        <!-- =====================================================
             HERO DE L'ARTICLE
             ===================================================== -->
        <section
            class="
                relative
                overflow-hidden
                border-b
                border-zinc-900
                bg-black
            "
        >

            <!-- Élément graphique rouge -->
            <div
                class="
                    pointer-events-none
                    absolute
                    -right-32
                    top-0
                    h-96
                    w-96
                    rounded-full
                    bg-red-600/10
                    blur-3xl
                "
            ></div>


            <div
                class="
                    relative
                    mx-auto
                    max-w-7xl
                    px-6
                    py-16
                    lg:px-8
                    lg:py-24
                "
            >

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
                    ← Retour aux articles
                </a>


                <!-- =============================================
                     CATÉGORIE
                     ============================================= -->
                <div class="mt-10">

                    <span
                        class="
                            inline-flex
                            rounded-full
                            bg-red-600
                            px-4
                            py-2
                            text-xs
                            font-black
                            uppercase
                            tracking-widest
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
                        lg:text-7xl
                    "
                >
                    {{ $article->title }}
                </h1>


                <!-- =============================================
                     RÉSUMÉ
                     ============================================= -->
                @if ($article->excerpt)

                    <p
                        class="
                            mt-8
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


                <!-- =============================================
                     INFORMATIONS DE PUBLICATION
                     ============================================= -->
                <div
                    class="
                        mt-10
                        flex
                        flex-wrap
                        items-center
                        gap-x-8
                        gap-y-3
                        border-t
                        border-zinc-800
                        pt-6
                        text-sm
                        text-zinc-500
                    "
                >

                    <!-- Auteur -->
                    <p>

                        <span class="font-bold text-zinc-300">
                            Auteur :
                        </span>

                        @if ($article->author)

                            {{ $article->author->prenom }}
                            {{ $article->author->nom }}

                        @else

                            Brussels Top Team

                        @endif

                    </p>


                    <!-- Date -->
                    @if ($article->published_at)

                        <p>

                            <span class="font-bold text-zinc-300">
                                Publié le :
                            </span>

                            {{ $article->published_at->format('d/m/Y à H:i') }}

                        </p>

                    @endif


                    <!-- Mise en avant -->
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

            <section class="border-b border-zinc-900 bg-zinc-950">

                <div
                    class="
                        mx-auto
                        max-w-7xl
                        px-6
                        py-10
                        lg:px-8
                        lg:py-14
                    "
                >

                    <div
                        class="
                            overflow-hidden
                            rounded-xl
                            border
                            border-zinc-800
                            bg-black
                        "
                    >

                        <img
                            src="{{ asset('storage/' . $article->banner_image) }}"
                            alt="{{ $article->title }}"
                            class="
                                max-h-[700px]
                                w-full
                                object-contain
                            "
                        >

                    </div>

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
                lg:py-24
            "
        >

            <div class="mx-auto max-w-4xl">

                <!-- =============================================
                     CONTENU QUILL
                     ============================================= -->
                <div class="article-content">
                    {!! $article->content !!}
                </div>

            </div>

        </section>


        <!-- =====================================================
             COMMENTAIRES
             ===================================================== -->
        <section
            id="commentaires"
            class="
                border-t
                border-zinc-900
                bg-black
                px-6
                py-16
                lg:px-8
                lg:py-24
            "
        >

            <div class="mx-auto max-w-4xl">


                <!-- =============================================
                     TITRE DE LA SECTION
                     ============================================= -->
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
                            Communauté BTT
                        </p>


                        <h2
                            class="
                                mt-3
                                text-3xl
                                font-black
                                uppercase
                                tracking-tight
                                text-white
                                sm:text-4xl
                            "
                        >
                            Commentaires
                        </h2>

                    </div>


                    <!-- Nombre de commentaires -->
                    <p class="text-sm font-bold text-zinc-500">

                        {{ $article->comments->count() }}

                        @if ($article->comments->count() > 1)

                            commentaires

                        @else

                            commentaire

                        @endif

                    </p>

                </div>


                <!-- =============================================
                     MESSAGE DE SUCCÈS
                     ============================================= -->
                @if (session('success'))

                    <div
                        class="
                            mt-8
                            rounded-lg
                            border
                            border-green-900
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


                <!-- =============================================
                     ERREURS DE VALIDATION
                     ============================================= -->
                @if ($errors->any())

                    <div
                        class="
                            mt-8
                            rounded-lg
                            border
                            border-red-900
                            bg-red-950/40
                            px-5
                            py-4
                        "
                    >

                        <p class="font-black text-red-400">
                            Le commentaire n'a pas pu être publié.
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


                <!-- =============================================
                     FORMULAIRE POUR UTILISATEUR CONNECTÉ
                     ============================================= -->
                @auth

                    <div
                        class="
                            mt-10
                            rounded-xl
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
                                justify-between
                                gap-4
                            "
                        >

                            <div>

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-red-500
                                    "
                                >
                                    Participer
                                </p>

                                <h3
                                    class="
                                        mt-2
                                        text-xl
                                        font-black
                                        text-white
                                    "
                                >
                                    Ajouter un commentaire
                                </h3>

                            </div>


                            <p class="text-sm text-zinc-500">
                                {{ auth()->user()->pseudo }}
                            </p>

                        </div>


                        <form
                            action="{{ route('comments.store', $article->slug) }}"
                            method="POST"
                            class="mt-6"
                        >

                            @csrf


                            <!-- =====================================
                                 COMMENTAIRE
                                 ===================================== -->
                            <label
                                for="body"
                                class="
                                    block
                                    text-sm
                                    font-bold
                                    text-zinc-300
                                "
                            >
                                Votre commentaire
                            </label>


                            <textarea
                                id="body"
                                name="body"
                                rows="6"
                                maxlength="2000"
                                required
                                placeholder="Partagez votre avis..."
                                class="
                                    mt-3
                                    w-full
                                    resize-y
                                    rounded-lg
                                    border
                                    border-zinc-700
                                    bg-black
                                    px-4
                                    py-4
                                    text-base
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
                                    gap-4
                                    sm:flex-row
                                    sm:items-center
                                    sm:justify-between
                                "
                            >

                                <p class="text-xs text-zinc-600">
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

                @else

                    <!-- =============================================
                         VISITEUR NON CONNECTÉ
                         ============================================= -->
                    <div
                        class="
                            mt-10
                            border-l-4
                            border-red-600
                            bg-zinc-950
                            px-6
                            py-6
                        "
                    >

                        <p class="font-black text-white">
                            Vous souhaitez participer à la discussion ?
                        </p>


                        <p
                            class="
                                mt-2
                                text-sm
                                leading-6
                                text-zinc-400
                            "
                        >
                            Vous devez être connecté à votre compte BTT
                            pour publier un commentaire.
                        </p>


                        <div
                            class="
                                mt-5
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
                                    text-white
                                    transition
                                    hover:border-red-600
                                    hover:text-red-500
                                "
                            >
                                S'inscrire
                            </a>

                        </div>

                    </div>

                @endauth


                <!-- =============================================
                     LISTE DES COMMENTAIRES
                     ============================================= -->
                <div class="mt-12">

                    @forelse ($article->comments as $comment)

                        <article
                            class="
                                border-b
                                border-zinc-800
                                py-8
                                first:pt-0
                            "
                        >

                            <!-- =====================================
                                 EN-TÊTE DU COMMENTAIRE
                                 ===================================== -->
                            <div
                                class="
                                    flex
                                    flex-col
                                    gap-2
                                    sm:flex-row
                                    sm:items-center
                                    sm:justify-between
                                "
                            >

                                <div class="flex items-center gap-3">

                                    <!-- Avatar simple -->
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

                                        @if ($comment->user)

                                            {{ mb_substr($comment->user->pseudo, 0, 1) }}

                                        @else

                                            B

                                        @endif

                                    </div>


                                    <div>

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


                                        <p
                                            class="
                                                mt-1
                                                text-xs
                                                text-zinc-600
                                            "
                                        >
                                            {{ $comment->created_at->format('d/m/Y à H:i') }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <!-- =====================================
                                 CONTENU DU COMMENTAIRE
                                 ===================================== -->
                            <div
                                class="
                                    mt-5
                                    whitespace-pre-line
                                    break-words
                                    text-base
                                    leading-7
                                    text-zinc-300
                                "
                            >{{ $comment->body }}</div>

                        </article>

                    @empty

                        <!-- =========================================
                             AUCUN COMMENTAIRE
                             ========================================= -->
                        <div
                            class="
                                py-14
                                text-center
                            "
                        >

                            <p
                                class="
                                    text-xl
                                    font-black
                                    text-white
                                "
                            >
                                Aucun commentaire pour le moment.
                            </p>


                            <p
                                class="
                                    mx-auto
                                    mt-3
                                    max-w-lg
                                    text-sm
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                Soyez le premier membre du Brussels Top Team
                                à participer à la discussion.
                            </p>

                        </div>

                    @endforelse

                </div>


                <!-- =============================================
                     RETOUR AUX ARTICLES
                     ============================================= -->
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
                        ← Retour au blog
                    </a>

                </div>

            </div>

        </section>

    </article>


    <!-- =========================================================
         STYLE DU CONTENU RICHE QUILL
         =========================================================
         Ces règles sont nécessaires car le contenu des articles
         contient du HTML généré par Quill.
         ========================================================= -->
    <style>

        /*
        |--------------------------------------------------------------------------
        | CONTENU GLOBAL
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
            margin-top: 1.25rem;
            margin-bottom: 1.25rem;
        }


        /*
        |--------------------------------------------------------------------------
        | TITRES
        |--------------------------------------------------------------------------
        */

        .article-content h1,
        .article-content h2,
        .article-content h3 {
            color: white;
            font-weight: 900;
            line-height: 1.2;
        }

        .article-content h1 {
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
        }

        .article-content h2 {
            margin-top: 2.75rem;
            margin-bottom: 1.25rem;
            font-size: 2rem;
        }

        .article-content h3 {
            margin-top: 2.25rem;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }


        /*
        |--------------------------------------------------------------------------
        | GRAS / ITALIQUE / SOULIGNÉ
        |--------------------------------------------------------------------------
        */

        .article-content strong {
            color: white;
            font-weight: 900;
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
            text-underline-offset: 3px;
        }

        .article-content a:hover {
            color: #dc2626;
        }


        /*
        |--------------------------------------------------------------------------
        | LISTES
        |--------------------------------------------------------------------------
        */

        .article-content ul {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            padding-left: 1.75rem;
            list-style-type: disc;
        }

        .article-content ol {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            padding-left: 1.75rem;
            list-style-type: decimal;
        }

        .article-content li {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
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
            background: #18181b;
            padding: 1.25rem 1.5rem;
            color: #d4d4d8;
            font-style: italic;
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGES INSÉRÉES DANS L'ARTICLE
        |--------------------------------------------------------------------------
        */

        .article-content img {
            display: block;
            width: auto;
            max-width: 100%;
            max-height: 750px;
            margin: 2.5rem auto;
            border-radius: 0.75rem;
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
        | RETRAITS QUILL
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
        | TAILLES QUILL
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
                font-size: 2rem;
            }

            .article-content h2 {
                font-size: 1.65rem;
            }

            .article-content h3 {
                font-size: 1.35rem;
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