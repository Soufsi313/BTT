@extends('layouts.app')


@section('title', 'Blog - Brussels Top Team')


@section(
    'meta_description',
    'Découvrez les actualités, événements et informations du Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         BLOG PUBLIC
         =========================================================

         Cette page affiche tous les articles publics du BTT.

         Fonctionnalités présentes :

         - filtrage par catégorie ;
         - tri des articles ;
         - compteur de commentaires publiés ;
         - compteur de likes ;
         - accès à l'article ;
         - partage Facebook ;
         - partage X ;
         - partage WhatsApp ;
         - copie du lien.

         ========================================================= -->

    <section class="min-h-screen bg-zinc-950 text-white">


        <!-- =====================================================
             HERO
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

            <div class="mx-auto max-w-7xl">

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


                <h1
                    class="
                        mt-4
                        text-5xl
                        font-black
                        uppercase
                        leading-none
                        tracking-tight
                        text-white
                        sm:text-6xl
                        lg:text-7xl
                    "
                >
                    Actualités
                </h1>


                <p
                    class="
                        mt-6
                        max-w-3xl
                        text-lg
                        leading-8
                        text-zinc-400
                    "
                >
                    Retrouvez les dernières actualités du Brussels Top Team,
                    nos événements, nos disciplines et la vie de l'association.
                </p>

            </div>

        </section>


        <!-- =====================================================
             CONTENU PRINCIPAL
             ===================================================== -->

        <section
            class="
                px-6
                py-14
                lg:px-8
                lg:py-16
            "
        >

            <div class="mx-auto max-w-7xl">


                <!-- =================================================
                     FILTRES PAR CATÉGORIE
                     ================================================= -->

                <div
                    class="
                        flex
                        flex-wrap
                        gap-2
                    "
                >

                    <!-- =============================================
                         TOUS LES ARTICLES
                         ============================================= -->

                    <a
                        href="{{ route('blog', [
                            'sort' => $selectedSort
                        ]) }}"
                        class="
                            rounded-full
                            border
                            px-4
                            py-2
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            transition
                            {{ $selectedCategory === null
                                ? 'border-red-600 bg-red-600 text-white'
                                : 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-red-600 hover:text-white'
                            }}
                        "
                    >
                        Tous
                    </a>


                    <!-- =============================================
                         CATÉGORIES
                         ============================================= -->

                    @foreach ($categories as $category)

                        <a
                            href="{{ route('blog', [
                                'category' => $category,
                                'sort' => $selectedSort
                            ]) }}"
                            class="
                                rounded-full
                                border
                                px-4
                                py-2
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                transition
                                {{ $selectedCategory === $category
                                    ? 'border-red-600 bg-red-600 text-white'
                                    : 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-red-600 hover:text-white'
                                }}
                            "
                        >
                            {{ $category }}
                        </a>

                    @endforeach

                </div>


                <!-- =================================================
                     TRI + RÉSUMÉ
                     ================================================= -->

                <div
                    class="
                        mt-10
                        flex
                        flex-col
                        gap-5
                        border-b
                        border-zinc-800
                        pb-7
                        sm:flex-row
                        sm:items-end
                        sm:justify-between
                    "
                >


                    <!-- =============================================
                         RÉSUMÉ DE LA SÉLECTION
                         ============================================= -->

                    <div>

                        <p
                            class="
                                text-xs
                                font-black
                                uppercase
                                tracking-[0.25em]
                                text-red-500
                            "
                        >
                            Articles
                        </p>


                        <h2
                            class="
                                mt-2
                                text-2xl
                                font-black
                                uppercase
                                text-white
                            "
                        >
                            @if ($selectedCategory)

                                {{ $selectedCategory }}

                            @else

                                Tous les articles

                            @endif
                        </h2>


                        <p
                            class="
                                mt-2
                                text-sm
                                text-zinc-500
                            "
                        >
                            {{ $articles->total() }}

                            @if ($articles->total() > 1)

                                articles disponibles

                            @else

                                article disponible

                            @endif
                        </p>

                    </div>


                    <!-- =============================================
                         FORMULAIRE DE TRI
                         ============================================= -->

                    <form
                        action="{{ route('blog') }}"
                        method="GET"
                        class="
                            flex
                            items-center
                            gap-3
                        "
                    >

                        <!--
                            On conserve la catégorie actuellement
                            sélectionnée lorsque le visiteur change
                            simplement le tri.
                        -->

                        @if ($selectedCategory)

                            <input
                                type="hidden"
                                name="category"
                                value="{{ $selectedCategory }}"
                            >

                        @endif


                        <label
                            for="sort"
                            class="
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-500
                            "
                        >
                            Trier
                        </label>


                        <select
                            id="sort"
                            name="sort"
                            onchange="this.form.submit()"
                            class="
                                rounded-md
                                border
                                border-zinc-800
                                bg-black
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-white
                                outline-none
                                transition
                                focus:border-red-600
                            "
                        >

                            <option
                                value="recent"
                                @selected($selectedSort === 'recent')
                            >
                                Plus récents
                            </option>


                            <option
                                value="oldest"
                                @selected($selectedSort === 'oldest')
                            >
                                Plus anciens
                            </option>


                            <option
                                value="featured"
                                @selected($selectedSort === 'featured')
                            >
                                À la une
                            </option>


                            <option
                                value="title"
                                @selected($selectedSort === 'title')
                            >
                                Titre A-Z
                            </option>

                        </select>

                    </form>

                </div>


                <!-- =================================================
                     LISTE DES ARTICLES
                     ================================================= -->

                @if ($articles->count() > 0)

                    <div
                        class="
                            mt-10
                            grid
                            gap-8
                            md:grid-cols-2
                            xl:grid-cols-3
                        "
                    >

                        @foreach ($articles as $article)


                            <!-- =========================================
                                 VIGNETTE D'ARTICLE
                                 ========================================= -->

                            <article
                                class="
                                    group
                                    flex
                                    min-w-0
                                    flex-col
                                    overflow-hidden
                                    border
                                    border-zinc-800
                                    bg-zinc-900
                                    transition
                                    duration-300
                                    hover:-translate-y-1
                                    hover:border-zinc-700
                                "
                            >


                                <!-- =====================================
                                     IMAGE DE L'ARTICLE
                                     ===================================== -->

                                <a
                                    href="{{ route('blog.show', $article->slug) }}"
                                    class="
                                        relative
                                        block
                                        overflow-hidden
                                        bg-black
                                    "
                                >

                                    @if ($article->banner_image)

                                        <img
                                            src="{{ asset('storage/' . $article->banner_image) }}"
                                            alt="{{ $article->title }}"
                                            class="
                                                h-64
                                                w-full
                                                object-cover
                                                transition
                                                duration-500
                                                group-hover:scale-[1.03]
                                            "
                                        >

                                    @else

                                        <!-- =================================
                                             IMAGE DE SECOURS
                                             ================================= -->

                                        <div
                                            class="
                                                flex
                                                h-64
                                                items-center
                                                justify-center
                                                bg-black
                                            "
                                        >

                                            <span
                                                class="
                                                    text-5xl
                                                    font-black
                                                    uppercase
                                                    tracking-tight
                                                    text-zinc-800
                                                "
                                            >
                                                BTT
                                            </span>

                                        </div>

                                    @endif


                                    <!-- =================================
                                         CATÉGORIE
                                         ================================= -->

                                    <span
                                        class="
                                            absolute
                                            bottom-4
                                            left-4
                                            bg-red-600
                                            px-3
                                            py-1.5
                                            text-[10px]
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-white
                                        "
                                    >
                                        {{ $article->category }}
                                    </span>


                                    <!-- =================================
                                         ARTICLE À LA UNE
                                         ================================= -->

                                    @if ($article->is_featured)

                                        <span
                                            class="
                                                absolute
                                                right-4
                                                top-4
                                                rounded-full
                                                bg-black/90
                                                px-3
                                                py-1.5
                                                text-[10px]
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-red-500
                                            "
                                        >
                                            À la une
                                        </span>

                                    @endif

                                </a>


                                <!-- =====================================
                                     CORPS DE LA VIGNETTE
                                     ===================================== -->

                                <div
                                    class="
                                        flex
                                        flex-1
                                        flex-col
                                        p-6
                                    "
                                >


                                    <!-- =================================
                                         DATE DE PUBLICATION
                                         ================================= -->

                                    @if ($article->published_at)

                                        <time
                                            datetime="{{ $article->published_at->toIso8601String() }}"
                                            class="
                                                text-xs
                                                font-bold
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            {{ $article->published_at->format('d/m/Y') }}
                                        </time>

                                    @endif


                                    <!-- =================================
                                         TITRE
                                         ================================= -->

                                    <h2
                                        class="
                                            mt-3
                                            text-2xl
                                            font-black
                                            leading-tight
                                            tracking-tight
                                            text-white
                                        "
                                    >

                                        <a
                                            href="{{ route('blog.show', $article->slug) }}"
                                            class="
                                                transition
                                                hover:text-red-500
                                            "
                                        >
                                            {{ $article->title }}
                                        </a>

                                    </h2>


                                    <!-- =================================
                                         EXTRAIT
                                         ================================= -->

                                    @if ($article->excerpt)

                                        <p
                                            class="
                                                mt-4
                                                line-clamp-3
                                                text-sm
                                                leading-6
                                                text-zinc-400
                                            "
                                        >
                                            {{ $article->excerpt }}
                                        </p>

                                    @endif


                                    <!-- =================================
                                         ZONE BASSE
                                         ================================= -->

                                    <div class="mt-auto pt-7">


                                        <!-- =================================
                                             LIEN + STATISTIQUES
                                             =================================

                                             Cette ligne contient maintenant :

                                             - le lien vers l'article ;
                                             - le compteur de commentaires ;
                                             - le compteur de likes.

                                             Le nombre de commentaires provient
                                             de comments_count calculé directement
                                             par le BlogController.

                                             Seuls les commentaires ayant le
                                             statut "published" sont comptés.
                                             ================================= -->

                                        <div
                                            class="
                                                flex
                                                items-center
                                                justify-between
                                                gap-4
                                                border-t
                                                border-zinc-800
                                                pt-5
                                            "
                                        >


                                            <!-- =============================
                                                 LIRE L'ARTICLE
                                                 ============================= -->

                                            <a
                                                href="{{ route('blog.show', $article->slug) }}"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-2
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-white
                                                    transition
                                                    hover:text-red-500
                                                "
                                            >
                                                Lire l'article

                                                <span aria-hidden="true">
                                                    →
                                                </span>
                                            </a>


                                            <!-- =============================
                                                 STATISTIQUES DE L'ARTICLE
                                                 ============================= -->

                                            <div
                                                class="
                                                    flex
                                                    shrink-0
                                                    items-center
                                                    gap-2
                                                "
                                            >


                                                <!-- =========================
                                                     COMPTEUR DE COMMENTAIRES
                                                     =========================

                                                     comments_count est fourni
                                                     par le contrôleur.

                                                     Il contient uniquement le
                                                     nombre de commentaires
                                                     actuellement publiés.

                                                     Un commentaire masqué par
                                                     la modération disparaît
                                                     donc automatiquement de
                                                     ce compteur.
                                                     ========================= -->

                                                <div
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        gap-2
                                                        rounded-full
                                                        border
                                                        border-zinc-800
                                                        bg-black
                                                        px-3
                                                        py-1.5
                                                    "
                                                    title="{{ $article->comments_count }} {{ $article->comments_count > 1 ? 'commentaires' : 'commentaire' }}"
                                                >

                                                    <!--
                                                        Icône de commentaire.

                                                        SVG utilisé plutôt qu'un
                                                        emoji afin de conserver
                                                        le même rendu graphique
                                                        sur tous les systèmes.
                                                    -->

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="
                                                            h-4
                                                            w-4
                                                            {{ $article->comments_count > 0
                                                                ? 'text-white'
                                                                : 'text-zinc-600'
                                                            }}
                                                        "
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"
                                                        />
                                                    </svg>


                                                    <!-- NOMBRE DE COMMENTAIRES -->

                                                    <span
                                                        class="
                                                            text-xs
                                                            font-black
                                                            {{ $article->comments_count > 0
                                                                ? 'text-white'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        {{ $article->comments_count }}
                                                    </span>

                                                </div>


                                                <!-- =========================
                                                     COMPTEUR DE LIKES
                                                     ========================= -->

                                                <div
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        gap-2
                                                        rounded-full
                                                        border
                                                        border-zinc-800
                                                        bg-black
                                                        px-3
                                                        py-1.5
                                                    "
                                                    title="{{ $article->likes_count }} {{ $article->likes_count > 1 ? 'likes' : 'like' }}"
                                                >

                                                    <!-- CŒUR -->

                                                    <span
                                                        class="
                                                            text-base
                                                            leading-none
                                                            {{ $article->likes_count > 0
                                                                ? 'text-red-500'
                                                                : 'text-zinc-600'
                                                            }}
                                                        "
                                                        aria-hidden="true"
                                                    >
                                                        ♥
                                                    </span>


                                                    <!-- NOMBRE DE LIKES -->

                                                    <span
                                                        class="
                                                            text-xs
                                                            font-black
                                                            {{ $article->likes_count > 0
                                                                ? 'text-white'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        {{ $article->likes_count }}
                                                    </span>

                                                </div>

                                            </div>

                                        </div>


                                        <!-- =================================
                                             PARTAGE
                                             =================================

                                             Les boutons sont volontairement
                                             petits afin de ne pas voler la
                                             priorité au lien vers l'article.

                                             ================================= -->

                                        <div
                                            class="
                                                mt-5
                                                flex
                                                items-center
                                                justify-between
                                                gap-4
                                            "
                                        >

                                            <p
                                                class="
                                                    text-[10px]
                                                    font-black
                                                    uppercase
                                                    tracking-[0.18em]
                                                    text-zinc-600
                                                "
                                            >
                                                Partager
                                            </p>


                                            <div
                                                class="
                                                    flex
                                                    items-center
                                                    gap-2
                                                "
                                            >


                                                <!-- =========================
                                                     FACEBOOK
                                                     ========================= -->

                                                <a
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $article->slug)) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    aria-label="Partager {{ $article->title }} sur Facebook"
                                                    title="Partager sur Facebook"
                                                    class="
                                                        flex
                                                        h-9
                                                        w-9
                                                        items-center
                                                        justify-center
                                                        rounded-full
                                                        text-white
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
                                                        class="h-5 w-5"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            d="M13.5 22v-8h2.8l.42-3.2H13.5V8.75c0-.93.26-1.56 1.6-1.56h1.72V4.33a23.2 23.2 0 0 0-2.5-.13c-2.47 0-4.16 1.5-4.16 4.28v2.32H7.37V14h2.79v8h3.34Z"
                                                        />
                                                    </svg>

                                                </a>


                                                <!-- =========================
                                                     X
                                                     ========================= -->

                                                <a
                                                    href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(route('blog.show', $article->slug)) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    aria-label="Partager {{ $article->title }} sur X"
                                                    title="Partager sur X"
                                                    class="
                                                        flex
                                                        h-9
                                                        w-9
                                                        items-center
                                                        justify-center
                                                        rounded-full
                                                        border
                                                        border-zinc-700
                                                        bg-black
                                                        text-white
                                                        transition
                                                        duration-200
                                                        hover:scale-110
                                                        hover:border-zinc-500
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


                                                <!-- =========================
                                                     WHATSAPP
                                                     ========================= -->

                                                <a
                                                    href="https://wa.me/?text={{ urlencode($article->title . ' - ' . route('blog.show', $article->slug)) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    aria-label="Partager {{ $article->title }} sur WhatsApp"
                                                    title="Partager sur WhatsApp"
                                                    class="
                                                        flex
                                                        h-9
                                                        w-9
                                                        items-center
                                                        justify-center
                                                        rounded-full
                                                        text-white
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
                                                        class="h-5 w-5"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            d="M12.04 2a9.84 9.84 0 0 0-8.4 14.96L2 22l5.2-1.62A9.96 9.96 0 1 0 12.04 2Zm0 17.98a8.1 8.1 0 0 1-4.13-1.13l-.3-.18-3.08.96 1-3-.2-.3A8.03 8.03 0 1 1 12.04 19.98Zm4.42-6.02c-.24-.12-1.43-.7-1.65-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.92-1.18-.71-.63-1.19-1.42-1.33-1.66-.14-.24-.02-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.47-.4-.4-.54-.41h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.4 1.37.51.58.18 1.1.16 1.51.1.46-.07 1.43-.58 1.63-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z"
                                                        />
                                                    </svg>

                                                </a>


                                                <!-- =========================
                                                     COPIER LE LIEN
                                                     ========================= -->

                                                <button
                                                    type="button"
                                                    class="
                                                        blog-copy-link-button
                                                        flex
                                                        h-9
                                                        w-9
                                                        items-center
                                                        justify-center
                                                        rounded-full
                                                        border
                                                        border-zinc-700
                                                        bg-black
                                                        text-zinc-400
                                                        transition
                                                        duration-200
                                                        hover:scale-110
                                                        hover:border-red-600
                                                        hover:text-white
                                                    "
                                                    data-url="{{ route('blog.show', $article->slug) }}"
                                                    aria-label="Copier le lien de {{ $article->title }}"
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
                                                        class="h-4 w-4"
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

                                        </div>


                                        <!-- =================================
                                             MESSAGE COPIE DU LIEN
                                             ================================= -->

                                        <p
                                            class="
                                                blog-copy-message
                                                mt-3
                                                hidden
                                                text-right
                                                text-xs
                                                font-bold
                                                text-green-500
                                            "
                                        >
                                            Lien copié.
                                        </p>

                                    </div>

                                </div>

                            </article>

                        @endforeach

                    </div>


                    <!-- =================================================
                         PAGINATION
                         ================================================= -->

                    @if ($articles->hasPages())

                        <div class="mt-12">
                            {{ $articles->links() }}
                        </div>

                    @endif


                @else


                    <!-- =================================================
                         AUCUN ARTICLE
                         ================================================= -->

                    <div
                        class="
                            mt-12
                            border
                            border-zinc-800
                            bg-zinc-900
                            px-6
                            py-16
                            text-center
                        "
                    >

                        <p
                            class="
                                text-xl
                                font-black
                                uppercase
                                text-white
                            "
                        >
                            Aucun article
                        </p>


                        <p
                            class="
                                mx-auto
                                mt-3
                                max-w-xl
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Aucun article ne correspond actuellement
                            à votre sélection.
                        </p>


                        @if ($selectedCategory)

                            <a
                                href="{{ route('blog', [
                                    'sort' => $selectedSort
                                ]) }}"
                                class="
                                    mt-6
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
                                Voir tous les articles
                            </a>

                        @endif

                    </div>

                @endif

            </div>

        </section>

    </section>


    <!-- =========================================================
         JAVASCRIPT - COPIE DES LIENS
         =========================================================

         Chaque vignette possède son propre bouton de copie.

         Nous utilisons une classe commune afin de gérer tous les
         articles sans avoir besoin d'un identifiant HTML différent
         pour chaque bouton.

         ========================================================= -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | RÉCUPÉRATION DES BOUTONS
            |--------------------------------------------------------------------------
            */

            const copyButtons =
                document.querySelectorAll(
                    '.blog-copy-link-button'
                );


            /*
            |--------------------------------------------------------------------------
            | GESTION DE CHAQUE BOUTON
            |--------------------------------------------------------------------------
            */

            copyButtons.forEach(function (button) {

                button.addEventListener(
                    'click',
                    async function () {

                        /*
                         * URL exacte de l'article concerné.
                         */

                        const articleUrl =
                            button.dataset.url;


                        /*
                         * On recherche la vignette contenant le bouton.
                         */

                        const articleCard =
                            button.closest('article');


                        /*
                         * Puis le message de confirmation de cette vignette.
                         */

                        const confirmationMessage =
                            articleCard
                                ? articleCard.querySelector(
                                    '.blog-copy-message'
                                )
                                : null;


                        try {

                            /*
                             * Copie moderne dans le presse-papiers.
                             */

                            await navigator.clipboard.writeText(
                                articleUrl
                            );


                            /*
                             * Message temporaire.
                             */

                            if (confirmationMessage) {

                                confirmationMessage.classList.remove(
                                    'hidden'
                                );


                                window.setTimeout(
                                    function () {

                                        confirmationMessage.classList.add(
                                            'hidden'
                                        );

                                    },
                                    2500
                                );

                            }

                        } catch (error) {

                            /*
                             * Solution de secours pour les navigateurs
                             * ne permettant pas Clipboard API.
                             */

                            window.prompt(
                                'Copiez le lien de cet article :',
                                articleUrl
                            );

                        }

                    }
                );

            });

        });

    </script>

@endsection