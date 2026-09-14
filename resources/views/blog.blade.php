@extends('layouts.app')


@section('title', 'Blog - Brussels Top Team')


@section(
    'meta_description',
    'Découvrez les actualités, événements et informations du Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         BLOG PUBLIC
         ========================================================= -->
    <section class="min-h-screen bg-zinc-950 text-white">


        <!-- =====================================================
             HERO DU BLOG
             ===================================================== -->
        <div
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
                        tracking-[0.35em]
                        text-red-500
                    "
                >
                    Brussels Top Team
                </p>


                <h1
                    class="
                        mt-4
                        text-4xl
                        font-black
                        uppercase
                        tracking-tight
                        text-white
                        sm:text-5xl
                        lg:text-6xl
                    "
                >
                    Actualités
                </h1>


                <p
                    class="
                        mt-6
                        max-w-3xl
                        text-base
                        leading-8
                        text-zinc-400
                        sm:text-lg
                    "
                >
                    Retrouvez les dernières actualités, événements,
                    informations et projets du Brussels Top Team.
                </p>

            </div>

        </div>


        <!-- =====================================================
             CONTENU DU BLOG
             ===================================================== -->
        <div
            class="
                mx-auto
                max-w-7xl
                px-6
                py-14
                lg:px-8
                lg:py-16
            "
        >


            <!-- =================================================
                 FILTRES ET TRI
                 ================================================= -->
            <section
                class="
                    border-b
                    border-zinc-800
                    pb-10
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        gap-8
                        lg:flex-row
                        lg:items-end
                        lg:justify-between
                    "
                >


                    <!-- =========================================
                         FILTRES PAR CATÉGORIE
                         ========================================= -->
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
                            Catégories
                        </p>


                        <div
                            class="
                                mt-4
                                flex
                                flex-wrap
                                gap-2
                            "
                        >

                            <!-- =============================
                                 TOUS LES ARTICLES
                                 ============================= -->
                            <a
                                href="{{ route('blog', [
                                    'sort' => $selectedSort,
                                ]) }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    border
                                    px-4
                                    py-2.5
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


                            <!-- =============================
                                 CATÉGORIES
                                 ============================= -->
                            @foreach ($categories as $category)

                                <a
                                    href="{{ route('blog', [
                                        'category' => $category,
                                        'sort' => $selectedSort,
                                    ]) }}"
                                    class="
                                        inline-flex
                                        items-center
                                        justify-center
                                        rounded-md
                                        border
                                        px-4
                                        py-2.5
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

                    </div>


                    <!-- =========================================
                         TRI DES ARTICLES
                         ========================================= -->
                    <div class="w-full lg:w-auto">

                        <p
                            class="
                                text-xs
                                font-black
                                uppercase
                                tracking-[0.25em]
                                text-zinc-500
                            "
                        >
                            Trier par
                        </p>


                        <form
                            action="{{ route('blog') }}"
                            method="GET"
                            class="mt-4"
                        >

                            <!--
                                Nous conservons la catégorie actuelle
                                lorsque l'utilisateur change uniquement
                                le tri.
                            -->
                            @if ($selectedCategory !== null)

                                <input
                                    type="hidden"
                                    name="category"
                                    value="{{ $selectedCategory }}"
                                >

                            @endif


                            <select
                                name="sort"
                                onchange="this.form.submit()"
                                class="
                                    w-full
                                    min-w-[220px]
                                    rounded-md
                                    border
                                    border-zinc-800
                                    bg-zinc-900
                                    px-4
                                    py-3
                                    text-sm
                                    font-bold
                                    text-white
                                    outline-none
                                    transition
                                    focus:border-red-600
                                    lg:w-auto
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
                                    Titre A → Z
                                </option>

                            </select>

                        </form>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 RÉSUMÉ DES RÉSULTATS
                 ================================================= -->
            <div
                class="
                    mt-10
                    flex
                    flex-col
                    gap-3
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                "
            >

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
                        Blog BTT
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

                        @if ($selectedCategory !== null)

                            {{ $selectedCategory }}

                        @else

                            Tous les articles

                        @endif

                    </h2>

                </div>


                <p
                    class="
                        text-sm
                        font-bold
                        text-zinc-500
                    "
                >

                    {{ $articles->total() }}

                    @if ($articles->total() > 1)

                        articles

                    @else

                        article

                    @endif

                </p>

            </div>


            <!-- =================================================
                 GRILLE DES ARTICLES
                 ================================================= -->
            @if ($articles->count() > 0)

                <div
                    class="
                        mt-8
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
                                h-full
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
                                 IMAGE CLIQUABLE
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
                                            group-hover:scale-105
                                        "
                                    >

                                @else

                                    <!-- =========================
                                         ARTICLE SANS BANNIÈRE
                                         ========================= -->
                                    <div
                                        class="
                                            flex
                                            h-64
                                            items-center
                                            justify-center
                                            bg-zinc-950
                                        "
                                    >

                                        <span
                                            class="
                                                text-sm
                                                font-black
                                                uppercase
                                                tracking-[0.25em]
                                                text-zinc-700
                                            "
                                        >
                                            Brussels Top Team
                                        </span>

                                    </div>

                                @endif


                                <!-- =============================
                                     VOILE AU SURVOL
                                     ============================= -->
                                <div
                                    class="
                                        absolute
                                        inset-0
                                        bg-black/0
                                        transition
                                        duration-300
                                        group-hover:bg-black/10
                                    "
                                ></div>


                                <!-- =============================
                                     CATÉGORIE SUR L'IMAGE
                                     ============================= -->
                                <span
                                    class="
                                        absolute
                                        left-4
                                        top-4
                                        bg-red-600
                                        px-3
                                        py-1.5
                                        text-[11px]
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-white
                                    "
                                >
                                    {{ $article->category }}
                                </span>


                                <!-- =============================
                                     ARTICLE À LA UNE
                                     ============================= -->
                                @if ($article->is_featured)

                                    <span
                                        class="
                                            absolute
                                            right-4
                                            top-4
                                            bg-black/85
                                            px-3
                                            py-1.5
                                            text-[11px]
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-white
                                            backdrop-blur-sm
                                        "
                                    >
                                        À la une
                                    </span>

                                @endif

                            </a>


                            <!-- =====================================
                                 CONTENU DE LA VIGNETTE
                                 ===================================== -->
                            <div
                                class="
                                    flex
                                    flex-1
                                    flex-col
                                    p-6
                                "
                            >


                                <!-- =============================
                                     DATE DE PUBLICATION
                                     ============================= -->
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


                                <!-- =============================
                                     TITRE
                                     ============================= -->
                                <h3
                                    class="
                                        mt-4
                                        text-xl
                                        font-black
                                        uppercase
                                        leading-tight
                                        text-white
                                        transition
                                        group-hover:text-red-500
                                    "
                                >

                                    <a
                                        href="{{ route('blog.show', $article->slug) }}"
                                    >
                                        {{ $article->title }}
                                    </a>

                                </h3>


                                <!-- =============================
                                     RÉSUMÉ
                                     ============================= -->
                                @if ($article->excerpt)

                                    <p
                                        class="
                                            mt-4
                                            line-clamp-3
                                            text-sm
                                            leading-7
                                            text-zinc-400
                                        "
                                    >
                                        {{ $article->excerpt }}
                                    </p>

                                @endif


                                <!-- =============================
                                     PIED DE LA VIGNETTE
                                     ============================= -->
                                <div
                                    class="
                                        mt-auto
                                        pt-7
                                    "
                                >

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


                                        <!-- =========================
                                             LIEN VERS L'ARTICLE
                                             ========================= -->
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

                                            <span
                                                class="
                                                    transition
                                                    group-hover:translate-x-1
                                                "
                                            >
                                                →
                                            </span>
                                        </a>


                                        <!-- =========================
                                             COMPTEUR DE LIKES
                                             =========================
                                             Ce compteur est uniquement
                                             informatif sur la vignette.

                                             Le bouton permettant de liker
                                             reste sur la page détaillée
                                             de l'article.
                                             ========================= -->
                                        <div
                                            class="
                                                inline-flex
                                                shrink-0
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


                                            <!-- NOMBRE -->
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

                            </div>

                        </article>

                    @endforeach

                </div>


                <!-- =================================================
                     PAGINATION
                     ================================================= -->
                @if ($articles->hasPages())

                    <div
                        class="
                            mt-14
                            border-t
                            border-zinc-800
                            pt-8
                        "
                    >
                        {{ $articles->links() }}
                    </div>

                @endif

            @else

                <!-- =================================================
                     AUCUN ARTICLE
                     ================================================= -->
                <div
                    class="
                        mt-10
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
                            leading-7
                            text-zinc-500
                        "
                    >
                        Aucun article publié ne correspond actuellement
                        aux critères sélectionnés.
                    </p>


                    @if ($selectedCategory !== null)

                        <a
                            href="{{ route('blog') }}"
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

@endsection