@extends('layouts.app')


@section('title', $article->title . ' - Brussels Top Team')


@section(
    'meta_description',
    $article->excerpt
)


@section('content')

    <!-- =========================================================
         ARTICLE PUBLIC DU BLOG
         =========================================================
         Cette page reprend une présentation éditoriale de type
         "article de presse", tout en conservant l'identité BTT.

         Toute la logique métier existante est conservée :
         - catégorie ;
         - auteur ;
         - date ;
         - bannière ;
         - contenu Quill ;
         - images intégrées au contenu ;
         - likes ;
         - partage ;
         - commentaires ;
         - signalement des commentaires.
         ========================================================= -->
    <article class="min-h-screen bg-zinc-950 text-white">


        <!-- =====================================================
             EN-TÊTE ÉDITORIAL
             ===================================================== -->
        <section
            class="
                border-b
                border-zinc-900
                bg-black
                px-5
                pb-10
                pt-10
                sm:px-6
                lg:px-8
                lg:pb-14
                lg:pt-14
            "
        >

            <div class="mx-auto max-w-6xl">


                <!-- =============================================
                     FIL D'ARIANE / RETOUR AU BLOG
                     ============================================= -->
                <div
                    class="
                        flex
                        flex-wrap
                        items-center
                        gap-2
                        text-xs
                        font-black
                        uppercase
                        tracking-[0.18em]
                    "
                >

                    <a
                        href="{{ route('blog') }}"
                        class="
                            text-zinc-500
                            transition
                            hover:text-white
                        "
                    >
                        Actualités
                    </a>

                    <span class="text-red-600">
                        /
                    </span>

                    <span class="text-red-500">
                        {{ $article->category }}
                    </span>

                </div>


                <!-- =============================================
                     TITRE PRINCIPAL
                     ============================================= -->
                <h1
                    class="
                        mt-5
                        max-w-5xl
                        text-4xl
                        font-black
                        leading-[0.98]
                        tracking-[-0.04em]
                        text-white
                        sm:text-5xl
                        md:text-6xl
                        lg:text-7xl
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
                            text-base
                            font-medium
                            leading-7
                            text-zinc-400
                            sm:text-lg
                            sm:leading-8
                        "
                    >
                        {{ $article->excerpt }}
                    </p>

                @endif

            </div>

        </section>


        <!-- =====================================================
             GRANDE BANNIÈRE DE L'ARTICLE
             ===================================================== -->
        @if ($article->banner_image)

            <section
                class="
                    bg-zinc-950
                    px-0
                    sm:px-6
                    lg:px-8
                "
            >

                <div class="mx-auto max-w-6xl">

                    <div
                        class="
                            overflow-hidden
                            bg-black
                            sm:mt-8
                            sm:rounded-sm
                        "
                    >

                        <img
                            src="{{ asset('storage/' . $article->banner_image) }}"
                            alt="{{ $article->title }}"
                            class="
                                block
                                max-h-[780px]
                                w-full
                                object-cover
                            "
                        >

                    </div>

                </div>

            </section>

        @endif


        <!-- =====================================================
             INFORMATIONS DE PUBLICATION
             ===================================================== -->
        <section
            class="
                bg-zinc-950
                px-5
                sm:px-6
                lg:px-8
            "
        >

            <div class="mx-auto max-w-6xl">

                <div
                    class="
                        flex
                        flex-col
                        gap-5
                        border-b
                        border-zinc-800
                        py-7
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                    "
                >

                    <!-- =========================================
                         AUTEUR
                         ========================================= -->
                    <div class="flex items-center gap-4">

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

                            @if ($article->author)

                                {{ mb_substr($article->author->prenom ?? $article->author->pseudo, 0, 1) }}

                            @else

                                B

                            @endif

                        </div>


                        <div>

                            <p
                                class="
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-[0.16em]
                                    text-red-500
                                "
                            >
                                Article publié par
                            </p>


                            <p
                                class="
                                    mt-1
                                    text-sm
                                    font-black
                                    text-white
                                "
                            >

                                @if ($article->author)

                                    {{ $article->author->prenom }}
                                    {{ $article->author->nom }}

                                @else

                                    Brussels Top Team

                                @endif

                            </p>

                        </div>

                    </div>


                    <!-- =========================================
                         DATE + STATUT
                         ========================================= -->
                    <div
                        class="
                            flex
                            flex-wrap
                            items-center
                            gap-x-5
                            gap-y-2
                            text-xs
                            font-bold
                            text-zinc-500
                        "
                    >

                        @if ($article->published_at)

                            <time
                                datetime="{{ $article->published_at->toIso8601String() }}"
                            >
                                Publié le
                                {{ $article->published_at->format('d/m/Y à H:i') }}
                            </time>

                        @endif


                        @if ($article->is_featured)

                            <span
                                class="
                                    rounded-full
                                    bg-red-600
                                    px-3
                                    py-1
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-white
                                "
                            >
                                À la une
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </section>


        <!-- =====================================================
             CORPS PRINCIPAL DE L'ARTICLE
             ===================================================== -->
        <section
            class="
                bg-zinc-950
                px-5
                py-12
                sm:px-6
                lg:px-8
                lg:py-16
            "
        >

            <div
                class="
                    mx-auto
                    max-w-6xl
                    lg:grid
                    lg:grid-cols-[90px_minmax(0,760px)]
                    lg:justify-center
                    lg:gap-10
                    xl:grid-cols-[110px_minmax(0,820px)]
                    xl:gap-12
                "
            >


                <!-- =================================================
                     PARTAGE DESKTOP
                     ================================================= -->
                <aside
                    class="
                        hidden
                        lg:block
                    "
                >

                    <div
                        class="
                            sticky
                            top-28
                        "
                    >

                        <p
                            class="
                                mb-4
                                text-center
                                text-[10px]
                                font-black
                                uppercase
                                tracking-[0.2em]
                                text-zinc-500
                            "
                        >
                            Partage
                        </p>


                        <div
                            class="
                                flex
                                flex-col
                                items-center
                                gap-3
                            "
                        >

                            <!-- FACEBOOK -->
                            <a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Partager sur Facebook"
                                title="Partager sur Facebook"
                                class="
                                    flex
                                    h-11
                                    w-11
                                    items-center
                                    justify-center
                                    rounded-full
                                    text-white
                                    shadow-sm
                                    transition
                                    duration-200
                                    hover:scale-110
                                    hover:brightness-110
                                "
                                style="background-color: #1877F2;"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-6 w-6"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M13.5 22v-8h2.8l.42-3.2H13.5V8.75c0-.93.26-1.56 1.6-1.56h1.72V4.33a23.2 23.2 0 0 0-2.5-.13c-2.47 0-4.16 1.5-4.16 4.28v2.32H7.37V14h2.79v8h3.34Z"
                                    />
                                </svg>

                            </a>


                            <!-- X -->
                            <a
                                href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Partager sur X"
                                title="Partager sur X"
                                class="
                                    flex
                                    h-11
                                    w-11
                                    items-center
                                    justify-center
                                    rounded-full
                                    border
                                    border-zinc-700
                                    bg-black
                                    text-white
                                    shadow-sm
                                    transition
                                    duration-200
                                    hover:scale-110
                                    hover:border-zinc-500
                                    hover:bg-zinc-900
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.657l-5.214-6.817-5.965 6.817H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"
                                    />
                                </svg>

                            </a>


                            <!-- WHATSAPP -->
                            <a
                                href="https://wa.me/?text={{ urlencode($article->title . ' - ' . url()->current()) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Partager sur WhatsApp"
                                title="Partager sur WhatsApp"
                                class="
                                    flex
                                    h-11
                                    w-11
                                    items-center
                                    justify-center
                                    rounded-full
                                    text-white
                                    shadow-sm
                                    transition
                                    duration-200
                                    hover:scale-110
                                    hover:brightness-110
                                "
                                style="background-color: #25D366;"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-6 w-6"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M12.04 2a9.84 9.84 0 0 0-8.4 14.96L2 22l5.2-1.62A9.96 9.96 0 1 0 12.04 2Zm0 17.98a8.1 8.1 0 0 1-4.13-1.13l-.3-.18-3.08.96 1-3-.2-.3A8.03 8.03 0 1 1 12.04 19.98Zm4.42-6.02c-.24-.12-1.43-.7-1.65-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.92-1.18-.71-.63-1.19-1.42-1.33-1.66-.14-.24-.02-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.47-.4-.4-.54-.41h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.4 1.37.51.58.18 1.1.16 1.51.1.46-.07 1.43-.58 1.63-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z"
                                    />
                                </svg>

                            </a>


                            <!-- PARTAGE NATIF -->
                            <button
                                type="button"
                                id="native-share-button-desktop"
                                aria-label="Partager avec une application"
                                title="Partager avec une application"
                                class="
                                    hidden
                                    h-11
                                    w-11
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-red-600
                                    text-white
                                    shadow-sm
                                    transition
                                    duration-200
                                    hover:scale-110
                                    hover:bg-red-700
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <circle cx="18" cy="5" r="3" />
                                    <circle cx="6" cy="12" r="3" />
                                    <circle cx="18" cy="19" r="3" />
                                    <path d="m8.59 13.51 6.83 3.98" />
                                    <path d="m15.41 6.51-6.82 3.98" />
                                </svg>

                            </button>


                            <!-- COPIER LE LIEN -->
                            <button
                                type="button"
                                class="
                                    article-copy-link-button
                                    flex
                                    h-11
                                    w-11
                                    items-center
                                    justify-center
                                    rounded-full
                                    border
                                    border-zinc-700
                                    bg-zinc-900
                                    text-zinc-300
                                    shadow-sm
                                    transition
                                    duration-200
                                    hover:scale-110
                                    hover:border-red-600
                                    hover:text-white
                                "
                                data-url="{{ url()->current() }}"
                                aria-label="Copier le lien de l'article"
                                title="Copier le lien"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <rect
                                        width="14"
                                        height="14"
                                        x="8"
                                        y="8"
                                        rx="2"
                                        ry="2"
                                    />

                                    <path
                                        d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"
                                    />
                                </svg>

                            </button>

                        </div>


                        <!-- MESSAGE APRÈS COPIE -->
                        <p
                            class="
                                article-copy-message
                                mt-4
                                hidden
                                text-center
                                text-[10px]
                                font-bold
                                leading-4
                                text-green-500
                            "
                        >
                            Lien copié
                        </p>

                    </div>

                </aside>


                <!-- =================================================
                     CONTENU PRINCIPAL
                     ================================================= -->
                <div class="min-w-0">


                    <!-- =============================================
                         PARTAGE MOBILE / TABLETTE
                         ============================================= -->
                    <div
                        class="
                            mb-10
                            border-y
                            border-zinc-800
                            py-5
                            lg:hidden
                        "
                    >

                        <div
                            class="
                                flex
                                flex-wrap
                                items-center
                                gap-3
                            "
                        >

                            <span
                                class="
                                    mr-1
                                    text-[10px]
                                    font-black
                                    uppercase
                                    tracking-[0.2em]
                                    text-zinc-500
                                "
                            >
                                Partager
                            </span>


                            <!-- FACEBOOK -->
                            <a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Partager sur Facebook"
                                title="Partager sur Facebook"
                                class="
                                    flex
                                    h-10
                                    w-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    text-white
                                    transition
                                    hover:scale-105
                                "
                                style="background-color: #1877F2;"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M13.5 22v-8h2.8l.42-3.2H13.5V8.75c0-.93.26-1.56 1.6-1.56h1.72V4.33a23.2 23.2 0 0 0-2.5-.13c-2.47 0-4.16 1.5-4.16 4.28v2.32H7.37V14h2.79v8h3.34Z"
                                    />
                                </svg>

                            </a>


                            <!-- X -->
                            <a
                                href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Partager sur X"
                                title="Partager sur X"
                                class="
                                    flex
                                    h-10
                                    w-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    border
                                    border-zinc-700
                                    bg-black
                                    text-white
                                    transition
                                    hover:scale-105
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-4 w-4"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.657l-5.214-6.817-5.965 6.817H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"
                                    />
                                </svg>

                            </a>


                            <!-- WHATSAPP -->
                            <a
                                href="https://wa.me/?text={{ urlencode($article->title . ' - ' . url()->current()) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Partager sur WhatsApp"
                                title="Partager sur WhatsApp"
                                class="
                                    flex
                                    h-10
                                    w-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    text-white
                                    transition
                                    hover:scale-105
                                "
                                style="background-color: #25D366;"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M12.04 2a9.84 9.84 0 0 0-8.4 14.96L2 22l5.2-1.62A9.96 9.96 0 1 0 12.04 2Zm0 17.98a8.1 8.1 0 0 1-4.13-1.13l-.3-.18-3.08.96 1-3-.2-.3A8.03 8.03 0 1 1 12.04 19.98Zm4.42-6.02c-.24-.12-1.43-.7-1.65-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.92-1.18-.71-.63-1.19-1.42-1.33-1.66-.14-.24-.02-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.47-.4-.4-.54-.41h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.4 1.37.51.58.18 1.1.16 1.51.1.46-.07 1.43-.58 1.63-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z"
                                    />
                                </svg>

                            </a>


                            <!-- PARTAGE NATIF MOBILE -->
                            <button
                                type="button"
                                id="native-share-button-mobile"
                                aria-label="Partager avec une application"
                                title="Partager avec une application"
                                class="
                                    hidden
                                    h-10
                                    w-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-red-600
                                    text-white
                                    transition
                                    hover:bg-red-700
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <circle cx="18" cy="5" r="3" />
                                    <circle cx="6" cy="12" r="3" />
                                    <circle cx="18" cy="19" r="3" />
                                    <path d="m8.59 13.51 6.83 3.98" />
                                    <path d="m15.41 6.51-6.82 3.98" />
                                </svg>

                            </button>


                            <!-- COPIE DU LIEN -->
                            <button
                                type="button"
                                class="
                                    article-copy-link-button
                                    flex
                                    h-10
                                    w-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    border
                                    border-zinc-700
                                    bg-zinc-900
                                    text-zinc-300
                                    transition
                                    hover:border-red-600
                                    hover:text-white
                                "
                                data-url="{{ url()->current() }}"
                                aria-label="Copier le lien de l'article"
                                title="Copier le lien"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <rect
                                        width="14"
                                        height="14"
                                        x="8"
                                        y="8"
                                        rx="2"
                                        ry="2"
                                    />

                                    <path
                                        d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"
                                    />
                                </svg>

                            </button>

                        </div>


                        <p
                            class="
                                article-copy-message
                                mt-3
                                hidden
                                text-xs
                                font-bold
                                text-green-500
                            "
                        >
                            Lien copié dans le presse-papiers.
                        </p>

                    </div>


                    <!-- =============================================
                         TEXTE DE L'ARTICLE
                         ============================================= -->
                    <div class="article-content">
                        {!! $article->content !!}
                    </div>


                    <!-- =================================================
                         LIKES
                         ================================================= -->
                    <section
                        class="
                            mt-14
                            border-y
                            border-zinc-800
                            py-7
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

                            <!-- COMPTEUR -->
                            <div>

                                <p
                                    class="
                                        text-[10px]
                                        font-black
                                        uppercase
                                        tracking-[0.2em]
                                        text-zinc-500
                                    "
                                >
                                    Votre réaction
                                </p>


                                <div
                                    class="
                                        mt-2
                                        flex
                                        items-center
                                        gap-3
                                    "
                                >

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


                                    <p
                                        class="
                                            text-sm
                                            font-bold
                                            text-zinc-400
                                        "
                                    >

                                        <span
                                            class="
                                                mr-1
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


                            <!-- MEMBRE CONNECTÉ -->
                            @auth

                                <form
                                    action="{{ route('article.likes.toggle', $article->slug) }}"
                                    method="POST"
                                >

                                    @csrf


                                    @if ($hasLiked)

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


                            <!-- VISITEUR -->
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

                                    <span class="text-lg">
                                        ♡
                                    </span>

                                    Connectez-vous pour aimer

                                </a>

                            @endguest

                        </div>

                    </section>


                    <!-- =============================================
                         RETOUR AUX ACTUALITÉS
                         ============================================= -->
                    <div
                        class="
                            mt-8
                            flex
                            justify-end
                        "
                    >

                        <a
                            href="{{ route('blog') }}"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                text-xs
                                font-black
                                uppercase
                                tracking-[0.16em]
                                text-zinc-500
                                transition
                                hover:text-red-500
                            "
                        >
                            ← Retour aux actualités
                        </a>

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
            border-zinc-800
            bg-black
            px-5
            py-14
            sm:px-6
            lg:px-8
            lg:py-16
        "
    >

        <div class="mx-auto max-w-4xl">


            <!-- =================================================
                 TITRE DE LA ZONE COMMENTAIRES
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-4
                    border-b
                    border-zinc-800
                    pb-7
                    sm:flex-row
                    sm:items-end
                    sm:justify-between
                "
            >

                <div>

                    <p
                        class="
                            text-[10px]
                            font-black
                            uppercase
                            tracking-[0.25em]
                            text-red-500
                        "
                    >
                        Discussions
                    </p>


                    <h2
                        class="
                            mt-2
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
                        Une erreur est survenue.
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
                 FORMULAIRE POUR UN MEMBRE CONNECTÉ
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


                            <p
                                class="
                                    text-xs
                                    text-zinc-500
                                "
                            >
                                Publier un commentaire
                            </p>

                        </div>

                    </div>


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

                            <!-- AVATAR -->
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


                            <!-- CONTENU DU COMMENTAIRE -->
                            <div
                                class="
                                    min-w-0
                                    flex-1
                                "
                            >

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


                                <!-- =====================================
                                     SIGNALEMENT DU COMMENTAIRE
                                     =====================================
                                     Le signalement est réservé aux membres
                                     connectés.

                                     Un membre ne peut pas signaler son propre
                                     commentaire depuis l'interface.
                                     ===================================== -->
                                @auth

                                    @if ($comment->user_id !== auth()->id())

                                        <details
                                            class="
                                                mt-5
                                                border-t
                                                border-zinc-900
                                                pt-4
                                            "
                                        >

                                            <summary
                                                class="
                                                    inline-flex
                                                    cursor-pointer
                                                    list-none
                                                    items-center
                                                    gap-2
                                                    text-xs
                                                    font-bold
                                                    text-zinc-600
                                                    transition
                                                    hover:text-red-500
                                                "
                                            >

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="h-4 w-4"
                                                    aria-hidden="true"
                                                >
                                                    <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                                                    <path d="M4 22v-7" />
                                                </svg>

                                                Signaler

                                            </summary>


                                            <form
                                                action="{{ route(
                                                    'comments.reports.store',
                                                    [
                                                        'slug' => $article->slug,
                                                        'comment' => $comment->id,
                                                    ]
                                                ) }}"
                                                method="POST"
                                                class="
                                                    mt-4
                                                    rounded-md
                                                    border
                                                    border-zinc-800
                                                    bg-zinc-950
                                                    p-5
                                                "
                                            >

                                                @csrf


                                                <p
                                                    class="
                                                        text-sm
                                                        font-black
                                                        text-white
                                                    "
                                                >
                                                    Signaler ce commentaire
                                                </p>


                                                <p
                                                    class="
                                                        mt-2
                                                        text-xs
                                                        leading-5
                                                        text-zinc-500
                                                    "
                                                >
                                                    Le signalement sera transmis
                                                    à l'équipe de modération BTT.
                                                </p>


                                                <!-- =========================
                                                     MOTIF DU SIGNALEMENT
                                                     ========================= -->
                                                <div class="mt-5">

                                                    <label
                                                        for="reason-{{ $comment->id }}"
                                                        class="
                                                            block
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-zinc-400
                                                        "
                                                    >
                                                        Motif
                                                    </label>


                                                    <select
                                                        id="reason-{{ $comment->id }}"
                                                        name="reason"
                                                        required
                                                        class="
                                                            mt-2
                                                            w-full
                                                            rounded-md
                                                            border
                                                            border-zinc-800
                                                            bg-black
                                                            px-4
                                                            py-3
                                                            text-sm
                                                            text-white
                                                            outline-none
                                                            transition
                                                            focus:border-red-600
                                                        "
                                                    >

                                                        <option value="">
                                                            Choisissez un motif
                                                        </option>

                                                        <option value="insultes">
                                                            Insultes
                                                        </option>

                                                        <option value="harcelement">
                                                            Harcèlement
                                                        </option>

                                                        <option value="spam">
                                                            Spam
                                                        </option>

                                                        <option value="contenu_inapproprie">
                                                            Contenu inapproprié
                                                        </option>

                                                        <option value="autre">
                                                            Autre
                                                        </option>

                                                    </select>

                                                </div>


                                                <!-- =========================
                                                     PRÉCISIONS FACULTATIVES
                                                     ========================= -->
                                                <div class="mt-5">

                                                    <label
                                                        for="details-{{ $comment->id }}"
                                                        class="
                                                            block
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-zinc-400
                                                        "
                                                    >
                                                        Précisions

                                                        <span
                                                            class="
                                                                font-medium
                                                                normal-case
                                                                tracking-normal
                                                                text-zinc-600
                                                            "
                                                        >
                                                            (facultatif)
                                                        </span>
                                                    </label>


                                                    <textarea
                                                        id="details-{{ $comment->id }}"
                                                        name="details"
                                                        rows="3"
                                                        maxlength="1000"
                                                        placeholder="Ajoutez une précision si nécessaire..."
                                                        class="
                                                            mt-2
                                                            w-full
                                                            resize-y
                                                            rounded-md
                                                            border
                                                            border-zinc-800
                                                            bg-black
                                                            px-4
                                                            py-3
                                                            text-sm
                                                            leading-6
                                                            text-white
                                                            outline-none
                                                            transition
                                                            placeholder:text-zinc-600
                                                            focus:border-red-600
                                                        "
                                                    ></textarea>

                                                </div>


                                                <!-- =========================
                                                     VALIDATION
                                                     ========================= -->
                                                <div
                                                    class="
                                                        mt-5
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
                                                        Un seul signalement par
                                                        membre et par commentaire.
                                                    </p>


                                                    <button
                                                        type="submit"
                                                        class="
                                                            inline-flex
                                                            items-center
                                                            justify-center
                                                            rounded-md
                                                            border
                                                            border-red-900
                                                            bg-red-950/30
                                                            px-5
                                                            py-3
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-red-400
                                                            transition
                                                            hover:border-red-600
                                                            hover:bg-red-600
                                                            hover:text-white
                                                        "
                                                    >
                                                        Envoyer le signalement
                                                    </button>

                                                </div>

                                            </form>

                                        </details>

                                    @endif

                                @endauth

                            </div>

                        </div>

                    </article>

                @empty

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

        </div>

    </section>


    <!-- =========================================================
         STYLES DU CONTENU QUILL
         ========================================================= -->
    <style>

        .article-content {
            color: #d4d4d8;
            font-size: 1.075rem;
            line-height: 1.95;
            overflow-wrap: anywhere;
        }

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

        .article-content h1 {
            margin-top: 3.5rem;
            margin-bottom: 1.25rem;
            color: #ffffff;
            font-size: 2.4rem;
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -0.025em;
        }

        .article-content h2 {
            margin-top: 3.25rem;
            margin-bottom: 1.25rem;
            color: #ffffff;
            font-size: 2rem;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .article-content h3 {
            margin-top: 2.75rem;
            margin-bottom: 1rem;
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 900;
            line-height: 1.3;
        }

        .article-content strong {
            color: #ffffff;
            font-weight: 800;
        }

        .article-content em {
            font-style: italic;
        }

        .article-content u {
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .article-content s {
            text-decoration: line-through;
        }

        .article-content a {
            color: #ef4444;
            font-weight: 700;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 4px;
        }

        .article-content a:hover {
            color: #dc2626;
        }

        .article-content ul,
        .article-content ol {
            margin-top: 1.75rem;
            margin-bottom: 1.75rem;
            padding-left: 2rem;
        }

        .article-content ul {
            list-style-type: disc;
        }

        .article-content ol {
            list-style-type: decimal;
        }

        .article-content li {
            margin-top: 0.6rem;
            margin-bottom: 0.6rem;
            padding-left: 0.3rem;
        }

        .article-content blockquote {
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            border-left: 4px solid #dc2626;
            background: #09090b;
            padding: 1.5rem 1.75rem;
            color: #a1a1aa;
            font-size: 1.05em;
            font-style: italic;
        }

        .article-content img {
            display: block;
            width: auto;
            max-width: 100%;
            max-height: 780px;
            margin: 2.75rem auto;
            object-fit: contain;
        }

        .article-content .ql-align-center {
            text-align: center;
        }

        .article-content .ql-align-right {
            text-align: right;
        }

        .article-content .ql-align-justify {
            text-align: justify;
        }

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

        .article-content .ql-font-serif {
            font-family:
                Georgia,
                "Times New Roman",
                serif;
        }

        .article-content .ql-font-monospace {
            font-family:
                Monaco,
                "Courier New",
                monospace;
        }


        /* ========================================================
           RESPONSIVE MOBILE
           ======================================================== */
        @media (max-width: 640px) {

            .article-content {
                font-size: 1rem;
                line-height: 1.85;
            }

            .article-content h1 {
                font-size: 1.9rem;
            }

            .article-content h2 {
                font-size: 1.65rem;
            }

            .article-content h3 {
                font-size: 1.4rem;
            }

            .article-content img {
                margin-top: 2rem;
                margin-bottom: 2rem;
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


    <!-- =========================================================
         JAVASCRIPT DU PARTAGE
         ========================================================= -->
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | URL ET INFORMATIONS DE L'ARTICLE
            |--------------------------------------------------------------------------
            */

            const articleUrl =
                @json(url()->current());

            const articleTitle =
                @json($article->title);

            const articleText =
                @json($article->excerpt ?? $article->title);


            /*
            |--------------------------------------------------------------------------
            | PARTAGE NATIF
            |--------------------------------------------------------------------------
            */

            const nativeShareButtons = [
                document.getElementById('native-share-button-desktop'),
                document.getElementById('native-share-button-mobile')
            ];


            if (navigator.share) {

                nativeShareButtons.forEach(function (button) {

                    if (!button) {
                        return;
                    }


                    /*
                     * Le bouton était masqué par défaut.
                     * On l'affiche uniquement si le navigateur sait
                     * réellement gérer le partage natif.
                     */
                    button.classList.remove('hidden');
                    button.classList.add('flex');


                    button.addEventListener(
                        'click',
                        async function () {

                            try {

                                await navigator.share({
                                    title: articleTitle,
                                    text: articleText,
                                    url: articleUrl,
                                });

                            } catch (error) {

                                /*
                                 * Si l'utilisateur ferme simplement
                                 * la fenêtre de partage, aucune erreur
                                 * visible n'est nécessaire.
                                 */

                            }

                        }
                    );

                });

            }


            /*
            |--------------------------------------------------------------------------
            | COPIER LE LIEN
            |--------------------------------------------------------------------------
            */

            const copyButtons =
                document.querySelectorAll(
                    '.article-copy-link-button'
                );


            copyButtons.forEach(function (button) {

                button.addEventListener(
                    'click',
                    async function () {

                        const url =
                            button.dataset.url;


                        /*
                         * On recherche le message de confirmation situé
                         * dans la même zone que le bouton utilisé.
                         */
                        const container =
                            button.closest('aside')
                            || button.closest('.lg\\:hidden')
                            || button.parentElement.parentElement;

                        const message =
                            container
                                ? container.querySelector(
                                    '.article-copy-message'
                                )
                                : null;


                        try {

                            await navigator.clipboard.writeText(
                                url
                            );


                            if (message) {

                                message.classList.remove(
                                    'hidden'
                                );


                                window.setTimeout(
                                    function () {

                                        message.classList.add(
                                            'hidden'
                                        );

                                    },
                                    3000
                                );

                            }

                        } catch (error) {

                            /*
                             * Solution de secours pour les navigateurs
                             * qui ne permettent pas Clipboard API.
                             */
                            window.prompt(
                                'Copiez le lien de cet article :',
                                url
                            );

                        }

                    }
                );

            });

        });

    </script>

@endsection