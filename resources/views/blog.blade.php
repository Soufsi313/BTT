@extends('layouts.app')


@section('title', 'Actualités - Brussels Top Team')


@section(
    'meta_description',
    'Découvrez les dernières actualités du Brussels Top Team : boxe, futsal, HYROX, événements et vie de l’association.'
)


@section('content')

    <!-- =========================================================
         BLOG PUBLIC - BRUSSELS TOP TEAM
         =========================================================
         Cette page affiche dynamiquement les articles publiés
         depuis l'administration.

         Les articles sont récupérés par BlogController@index.

         Chaque vignette est maintenant cliquable et renvoie vers
         la page complète de l'article.
         ========================================================= -->


    <!-- =========================================================
         EN-TÊTE DU BLOG
         ========================================================= -->
    <section
        class="
            relative
            overflow-hidden
            border-b
            border-zinc-800
            bg-zinc-950
        "
    >

        <!-- =====================================================
             ÉLÉMENTS D'AMBIANCE
             ===================================================== -->
        <div
            class="
                pointer-events-none
                absolute
                -right-24
                -top-40
                h-[420px]
                w-[420px]
                rounded-full
                bg-red-600/10
                blur-3xl
            "
        ></div>

        <div
            class="
                pointer-events-none
                absolute
                -bottom-48
                -left-32
                h-[400px]
                w-[400px]
                rounded-full
                bg-red-900/10
                blur-3xl
            "
        ></div>


        <!-- =====================================================
             CONTENU
             ===================================================== -->
        <div
            class="
                relative
                mx-auto
                max-w-7xl
                px-6
                py-16
                sm:py-20
                lg:px-8
                lg:py-24
            "
        >

            <div class="max-w-4xl">

                <p
                    class="
                        text-xs
                        font-black
                        uppercase
                        tracking-[0.35em]
                        text-red-500
                        sm:text-sm
                    "
                >
                    Brussels Top Team
                </p>


                <h1
                    class="
                        mt-5
                        text-4xl
                        font-black
                        uppercase
                        leading-none
                        tracking-tight
                        text-white
                        sm:text-5xl
                        lg:text-7xl
                    "
                >
                    Nos actualités
                </h1>


                <div
                    class="
                        mt-6
                        h-1
                        w-20
                        bg-red-600
                    "
                ></div>


                <p
                    class="
                        mt-7
                        max-w-2xl
                        text-base
                        leading-7
                        text-zinc-400
                        sm:text-lg
                    "
                >
                    Retrouvez toute l'actualité du Brussels Top Team :
                    entraînements, compétitions, événements, vie du club
                    et projets de l'association.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================================================
         BIBLIOTHÈQUE DES ARTICLES
         ========================================================= -->
    <section class="bg-zinc-950">

        <div
            class="
                mx-auto
                max-w-7xl
                px-6
                py-12
                lg:px-8
                lg:py-16
            "
        >


            <!-- =================================================
                 EN-TÊTE DE LA BIBLIOTHÈQUE
                 ================================================= -->
            <div
                class="
                    mb-8
                    flex
                    flex-col
                    gap-4
                    border-b
                    border-zinc-800
                    pb-6
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
                        Le club au quotidien
                    </p>

                    <h2
                        class="
                            mt-2
                            text-2xl
                            font-black
                            uppercase
                            tracking-tight
                            text-white
                            sm:text-3xl
                        "
                    >
                        Toutes les publications
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
                        publications
                    @else
                        publication
                    @endif

                </p>

            </div>


            <!-- =================================================
                 GRILLE DES ARTICLES
                 ================================================= -->
            @if ($articles->count() > 0)

                <div
                    class="
                        grid
                        grid-cols-1
                        gap-5
                        sm:grid-cols-2
                        lg:grid-cols-3
                        xl:grid-cols-4
                    "
                >

                    @foreach ($articles as $article)

                        <!-- =====================================
                             LIEN VERS L'ARTICLE COMPLET
                             =====================================
                             Toute la vignette est maintenant
                             cliquable.
                             ===================================== -->
                        <a
                            href="{{ route('blog.show', $article->slug) }}"
                            class="
                                group
                                block
                                focus:outline-none
                                focus-visible:ring-2
                                focus-visible:ring-red-500
                                focus-visible:ring-offset-2
                                focus-visible:ring-offset-zinc-950
                            "
                        >

                            <!-- =================================
                                 CARTE ARTICLE
                                 ================================= -->
                            <article
                                class="
                                    relative
                                    h-full
                                    overflow-hidden
                                    border
                                    border-zinc-800
                                    bg-zinc-900
                                    transition
                                    duration-300
                                    group-hover:-translate-y-1
                                    group-hover:border-red-600
                                    group-hover:shadow-2xl
                                    group-hover:shadow-black/40
                                "
                            >


                                <!-- =================================
                                     BANNIÈRE DE L'ARTICLE
                                     ================================= -->
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
                                            src="{{ asset('storage/' . $article->banner_image) }}"
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

                                        <div
                                            class="
                                                flex
                                                h-full
                                                w-full
                                                items-center
                                                justify-center
                                                bg-zinc-900
                                                px-6
                                                text-center
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


                                    <!-- =============================
                                         CATÉGORIE
                                         ============================= -->
                                    <div
                                        class="
                                            absolute
                                            left-3
                                            top-3
                                        "
                                    >

                                        <span
                                            class="
                                                inline-flex
                                                bg-red-600
                                                px-2.5
                                                py-1.5
                                                text-[10px]
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-white
                                                shadow-lg
                                            "
                                        >
                                            {{ $article->category }}
                                        </span>

                                    </div>


                                    <!-- =============================
                                         ARTICLE MIS EN AVANT
                                         ============================= -->
                                    @if ($article->is_featured)

                                        <div
                                            class="
                                                absolute
                                                right-3
                                                top-3
                                            "
                                        >

                                            <span
                                                class="
                                                    inline-flex
                                                    bg-black/80
                                                    px-2
                                                    py-1.5
                                                    text-[9px]
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-white
                                                    backdrop-blur
                                                "
                                            >
                                                À la une
                                            </span>

                                        </div>

                                    @endif

                                </div>


                                <!-- =================================
                                     INFORMATIONS DE L'ARTICLE
                                     ================================= -->
                                <div class="p-5">

                                    <p
                                        class="
                                            text-[10px]
                                            font-black
                                            uppercase
                                            tracking-[0.2em]
                                            text-red-500
                                        "
                                    >
                                        {{ $article->published_at->format('d/m/Y') }}
                                    </p>


                                    <h3
                                        class="
                                            mt-2
                                            text-lg
                                            font-black
                                            leading-tight
                                            text-white
                                            transition
                                            group-hover:text-red-500
                                        "
                                    >
                                        {{ $article->title }}
                                    </h3>


                                    @if ($article->excerpt)

                                        <p
                                            class="
                                                mt-3
                                                line-clamp-3
                                                text-sm
                                                leading-6
                                                text-zinc-400
                                            "
                                        >
                                            {{ $article->excerpt }}
                                        </p>

                                    @else

                                        <p
                                            class="
                                                mt-3
                                                text-sm
                                                italic
                                                leading-6
                                                text-zinc-600
                                            "
                                        >
                                            Découvrez cette actualité du
                                            Brussels Top Team.
                                        </p>

                                    @endif


                                    <!-- =============================
                                         AUTEUR + INDICATION DE LECTURE
                                         ============================= -->
                                    <div
                                        class="
                                            mt-5
                                            flex
                                            items-center
                                            justify-between
                                            gap-3
                                            border-t
                                            border-zinc-800
                                            pt-4
                                        "
                                    >

                                        <div class="min-w-0">

                                            <p
                                                class="
                                                    text-[9px]
                                                    font-black
                                                    uppercase
                                                    tracking-[0.2em]
                                                    text-zinc-600
                                                "
                                            >
                                                Publication
                                            </p>


                                            <p
                                                class="
                                                    mt-1
                                                    truncate
                                                    text-xs
                                                    font-bold
                                                    text-zinc-400
                                                "
                                            >

                                                @if ($article->author)

                                                    {{ $article->author->pseudo }}

                                                @else

                                                    Brussels Top Team

                                                @endif

                                            </p>

                                        </div>


                                        <!-- =========================
                                             INDICATION VISUELLE
                                             ========================= -->
                                        <div
                                            class="
                                                flex
                                                items-center
                                                gap-2
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                                transition
                                                group-hover:text-red-500
                                            "
                                        >
                                            Lire

                                            <span
                                                class="
                                                    transition
                                                    duration-300
                                                    group-hover:translate-x-1
                                                "
                                                aria-hidden="true"
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
                     ================================================= -->
                @if ($articles->hasPages())

                    <div
                        class="
                            mt-12
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
                     AUCUN ARTICLE PUBLIÉ
                     ================================================= -->
                <div
                    class="
                        border
                        border-zinc-800
                        bg-zinc-900/50
                        px-6
                        py-20
                        text-center
                    "
                >

                    <div
                        class="
                            mx-auto
                            h-1
                            w-16
                            bg-red-600
                        "
                    ></div>


                    <h2
                        class="
                            mt-6
                            text-2xl
                            font-black
                            uppercase
                            tracking-tight
                            text-white
                        "
                    >
                        Aucune actualité publiée
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
                        Les prochaines actualités du Brussels Top Team
                        apparaîtront ici dès leur publication.
                    </p>

                </div>

            @endif

        </div>

    </section>

@endsection