@extends('layouts.app')


@section('title', 'Blog - Brussels Top Team')


@section(
    'meta_description',
    'Découvrez les actualités, événements et informations du Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         BLOG PUBLIC BTT
         =========================================================
         Cette page affiche la bibliothèque publique des articles.

         Elle permet maintenant :
         - de filtrer les articles par catégorie ;
         - de trier les articles ;
         - de combiner catégorie + tri ;
         - de conserver les filtres pendant la pagination.
         ========================================================= -->


    <!-- =========================================================
         HERO DU BLOG
         ========================================================= -->
    <section
        class="
            relative
            overflow-hidden
            border-b
            border-zinc-900
            bg-black
            px-6
            py-16
            lg:px-8
            lg:py-20
        "
    >

        <!-- Élément graphique rouge discret -->
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


        <div class="relative mx-auto max-w-7xl">

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
                    max-w-5xl
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
                Nos
                <span class="text-red-600">
                    actualités
                </span>
            </h1>


            <p
                class="
                    mt-7
                    max-w-3xl
                    text-lg
                    leading-8
                    text-zinc-400
                "
            >
                Retrouvez les actualités, événements, projets et informations
                du Brussels Top Team.
            </p>

        </div>

    </section>


    <!-- =========================================================
         BIBLIOTHÈQUE DES ARTICLES
         ========================================================= -->
    <section
        class="
            min-h-[60vh]
            bg-zinc-950
            px-4
            py-12
            sm:px-6
            lg:px-8
            lg:py-16
        "
    >

        <div class="mx-auto max-w-7xl">


            <!-- =================================================
                 EN-TÊTE DE LA BIBLIOTHÈQUE
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-5
                    border-b
                    border-zinc-800
                    pb-7
                    lg:flex-row
                    lg:items-end
                    lg:justify-between
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
                        Bibliothèque
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
                        Les articles BTT
                    </h2>

                </div>


                <!-- =============================================
                     NOMBRE D'ARTICLES
                     ============================================= -->
                <p class="text-sm font-bold text-zinc-500">

                    {{ $articles->total() }}

                    @if ($articles->total() > 1)
                        articles
                    @else
                        article
                    @endif

                </p>

            </div>


            <!-- =================================================
                 FILTRES ET TRI
                 ================================================= -->
            <div
                class="
                    mt-8
                    border-y
                    border-zinc-800
                    bg-black
                "
            >


                <!-- =============================================
                     FILTRE PAR CATÉGORIE
                     ============================================= -->
                <div
                    class="
                        border-b
                        border-zinc-800
                        px-5
                        py-5
                        sm:px-6
                    "
                >

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


                        <!-- =========================================
                             TOUTES LES CATÉGORIES
                             ========================================= -->
                        <a
                            href="{{ route('blog', [
                                'sort' => $selectedSort,
                            ]) }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
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
                                    : 'border-zinc-700 bg-zinc-950 text-zinc-400 hover:border-red-600 hover:text-white'
                                }}
                            "
                        >
                            Tous
                        </a>


                        <!-- =========================================
                             CATÉGORIES DISPONIBLES
                             ========================================= -->
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
                                        : 'border-zinc-700 bg-zinc-950 text-zinc-400 hover:border-red-600 hover:text-white'
                                    }}
                                "
                            >
                                {{ $category }}
                            </a>

                        @endforeach

                    </div>

                </div>


                <!-- =============================================
                     TRI
                     ============================================= -->
                <div
                    class="
                        flex
                        flex-col
                        gap-4
                        px-5
                        py-5
                        sm:px-6
                        md:flex-row
                        md:items-end
                        md:justify-between
                    "
                >

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
                            Trier les articles
                        </p>


                        <!-- =========================================
                             RÉSUMÉ DU FILTRE ACTIF
                             ========================================= -->
                        <p
                            class="
                                mt-2
                                text-sm
                                text-zinc-400
                            "
                        >

                            @if ($selectedCategory)

                                Catégorie :

                                <strong class="text-white">
                                    {{ $selectedCategory }}
                                </strong>

                            @else

                                Toutes les catégories

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
                            flex-col
                            gap-3
                            sm:flex-row
                            sm:items-center
                        "
                    >

                        <!-- =========================================
                             CONSERVATION DE LA CATÉGORIE
                             ========================================= -->
                        @if ($selectedCategory)

                            <input
                                type="hidden"
                                name="category"
                                value="{{ $selectedCategory }}"
                            >

                        @endif


                        <!-- =========================================
                             CHOIX DU TRI
                             ========================================= -->
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
                            Ordre
                        </label>


                        <select
                            id="sort"
                            name="sort"
                            class="
                                min-w-[210px]
                                border
                                border-zinc-700
                                bg-zinc-950
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
                                {{ $selectedSort === 'recent' ? 'selected' : '' }}
                            >
                                Plus récents
                            </option>


                            <option
                                value="oldest"
                                {{ $selectedSort === 'oldest' ? 'selected' : '' }}
                            >
                                Plus anciens
                            </option>


                            <option
                                value="featured"
                                {{ $selectedSort === 'featured' ? 'selected' : '' }}
                            >
                                À la une
                            </option>


                            <option
                                value="title"
                                {{ $selectedSort === 'title' ? 'selected' : '' }}
                            >
                                Titre A → Z
                            </option>

                        </select>


                        <!-- =========================================
                             APPLIQUER LE TRI
                             ========================================= -->
                        <button
                            type="submit"
                            class="
                                inline-flex
                                items-center
                                justify-center
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
                            Trier
                        </button>

                    </form>

                </div>

            </div>


            <!-- =================================================
                 GRILLE DES ARTICLES
                 ================================================= -->
            @if ($articles->count() > 0)

                <div
                    class="
                        mt-10
                        grid
                        grid-cols-1
                        gap-5
                        sm:grid-cols-2
                        lg:grid-cols-3
                        xl:grid-cols-4
                    "
                >

                    @foreach ($articles as $article)


                        <!-- =========================================
                             CARTE ARTICLE CLIQUABLE
                             ========================================= -->
                        <a
                            href="{{ route(
                                'blog.show',
                                $article->slug
                            ) }}"
                            class="
                                group
                                block
                                focus:outline-none
                                focus-visible:ring-2
                                focus-visible:ring-red-600
                            "
                        >

                            <article
                                class="
                                    flex
                                    h-full
                                    flex-col
                                    overflow-hidden
                                    border
                                    border-zinc-800
                                    bg-black
                                    transition
                                    duration-300
                                    group-hover:-translate-y-1
                                    group-hover:border-red-600
                                "
                            >


                                <!-- =====================================
                                     BANNIÈRE
                                     ===================================== -->
                                <div
                                    class="
                                        relative
                                        aspect-video
                                        overflow-hidden
                                        bg-black
                                    "
                                >

                                    @if ($article->banner_image)

                                        <img
                                            src="{{ asset(
                                                'storage/' . $article->banner_image
                                            ) }}"
                                            alt="{{ $article->title }}"
                                            loading="lazy"
                                            class="
                                                h-full
                                                w-full
                                                object-contain
                                                transition
                                                duration-500
                                                group-hover:scale-[1.02]
                                            "
                                        >

                                    @else

                                        <!-- =================================
                                             IMAGE NON DISPONIBLE
                                             ================================= -->
                                        <div
                                            class="
                                                flex
                                                h-full
                                                w-full
                                                items-center
                                                justify-center
                                                bg-zinc-900
                                            "
                                        >

                                            <span
                                                class="
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-[0.25em]
                                                    text-zinc-600
                                                "
                                            >
                                                Brussels Top Team
                                            </span>

                                        </div>

                                    @endif


                                    <!-- =================================
                                         BADGE À LA UNE
                                         ================================= -->
                                    @if ($article->is_featured)

                                        <span
                                            class="
                                                absolute
                                                right-3
                                                top-3
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
                                            À la une
                                        </span>

                                    @endif

                                </div>


                                <!-- =====================================
                                     CONTENU DE LA CARTE
                                     ===================================== -->
                                <div
                                    class="
                                        flex
                                        flex-1
                                        flex-col
                                        p-5
                                    "
                                >


                                    <!-- =================================
                                         CATÉGORIE + DATE
                                         ================================= -->
                                    <div
                                        class="
                                            flex
                                            flex-wrap
                                            items-center
                                            justify-between
                                            gap-3
                                        "
                                    >

                                        <span
                                            class="
                                                text-[11px]
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-red-500
                                            "
                                        >
                                            {{ $article->category }}
                                        </span>


                                        @if ($article->published_at)

                                            <span
                                                class="
                                                    text-xs
                                                    font-bold
                                                    text-zinc-600
                                                "
                                            >
                                                {{ $article
                                                    ->published_at
                                                    ->format('d/m/Y') }}
                                            </span>

                                        @endif

                                    </div>


                                    <!-- =================================
                                         TITRE
                                         ================================= -->
                                    <h2
                                        class="
                                            mt-4
                                            text-xl
                                            font-black
                                            leading-tight
                                            text-white
                                            transition
                                            group-hover:text-red-500
                                        "
                                    >
                                        {{ $article->title }}
                                    </h2>


                                    <!-- =================================
                                         RÉSUMÉ
                                         ================================= -->
                                    @if ($article->excerpt)

                                        <p
                                            class="
                                                mt-4
                                                line-clamp-3
                                                text-sm
                                                leading-6
                                                text-zinc-500
                                            "
                                        >
                                            {{ $article->excerpt }}
                                        </p>

                                    @endif


                                    <!-- =================================
                                         PIED DE CARTE
                                         ================================= -->
                                    <div
                                        class="
                                            mt-auto
                                            border-t
                                            border-zinc-900
                                            pt-5
                                        "
                                    >


                                        <!-- =============================
                                             AUTEUR
                                             ============================= -->
                                        @if ($article->author)

                                            <p
                                                class="
                                                    text-xs
                                                    text-zinc-600
                                                "
                                            >
                                                Par

                                                <span
                                                    class="
                                                        font-bold
                                                        text-zinc-400
                                                    "
                                                >
                                                    {{ $article->author->prenom }}
                                                    {{ $article->author->nom }}
                                                </span>

                                            </p>

                                        @endif


                                        <!-- =============================
                                             LIRE L'ARTICLE
                                             ============================= -->
                                        <div
                                            class="
                                                mt-4
                                                flex
                                                items-center
                                                justify-between
                                            "
                                        >

                                            <span
                                                class="
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-white
                                                    transition
                                                    group-hover:text-red-500
                                                "
                                            >
                                                Lire
                                            </span>


                                            <span
                                                class="
                                                    text-lg
                                                    text-red-500
                                                    transition
                                                    duration-300
                                                    group-hover:translate-x-1
                                                "
                                            >
                                                →
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </article>

                        </a>

                    @endforeach

                </div>


                <!-- =================================================
                     PAGINATION
                     =================================================
                     Les paramètres category et sort sont conservés
                     automatiquement par le BlogController grâce à
                     withQueryString().
                     ================================================= -->
                @if ($articles->hasPages())

                    <div class="mt-12">
                        {{ $articles->links() }}
                    </div>

                @endif


            @else

                <!-- =================================================
                     AUCUN ARTICLE POUR LE FILTRE
                     ================================================= -->
                <div
                    class="
                        mt-10
                        border
                        border-zinc-800
                        bg-black
                        px-6
                        py-16
                        text-center
                    "
                >

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.3em]
                            text-red-500
                        "
                    >
                        Blog BTT
                    </p>


                    <h2
                        class="
                            mt-4
                            text-2xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        Aucun article trouvé
                    </h2>


                    <p
                        class="
                            mx-auto
                            mt-4
                            max-w-xl
                            text-sm
                            leading-6
                            text-zinc-500
                        "
                    >

                        @if ($selectedCategory)

                            Aucun article publié n'est actuellement disponible
                            dans la catégorie

                            <strong class="text-zinc-300">
                                {{ $selectedCategory }}
                            </strong>.

                        @else

                            Aucun article publié n'est actuellement disponible.

                        @endif

                    </p>


                    @if ($selectedCategory)

                        <a
                            href="{{ route('blog', [
                                'sort' => $selectedSort,
                            ]) }}"
                            class="
                                mt-7
                                inline-flex
                                items-center
                                justify-center
                                border
                                border-red-600
                                px-5
                                py-3
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-red-500
                                transition
                                hover:bg-red-600
                                hover:text-white
                            "
                        >
                            Voir toutes les catégories
                        </a>

                    @endif

                </div>

            @endif

        </div>

    </section>

@endsection