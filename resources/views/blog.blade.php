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

         Seuls les articles :
         - publiés ;
         - non supprimés ;
         - dont la date de publication est atteinte ;

         arrivent jusqu'à cette vue.
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

                <!-- PETIT TITRE -->
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


                <!-- TITRE PRINCIPAL -->
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


                <!-- LIGNE ROUGE -->
                <div
                    class="
                        mt-6
                        h-1
                        w-20
                        bg-red-600
                    "
                ></div>


                <!-- DESCRIPTION -->
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


                <!-- =============================================
                     NOMBRE D'ARTICLES
                     ============================================= -->
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
                             CARTE ARTICLE
                             =====================================
                             La carte utilise maintenant un format
                             horizontal adapté aux bannières.

                             L'image complète est conservée afin
                             d'éviter de rogner les éléments présents
                             sur la bannière.
                             ===================================== -->
                        <article
                            class="
                                group
                                relative
                                overflow-hidden
                                border
                                border-zinc-800
                                bg-zinc-900
                                transition
                                duration-300
                                hover:-translate-y-1
                                hover:border-red-600
                                hover:shadow-2xl
                                hover:shadow-black/40
                            "
                        >


                            <!-- =================================
                                 BANNIÈRE DE L'ARTICLE
                                 =================================
                                 aspect-video correspond à un cadre
                                 16:9.

                                 object-contain garantit que l'image
                                 complète reste visible.

                                 Contrairement à object-cover,
                                 aucune partie de la bannière n'est
                                 volontairement découpée.
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

                                    <!-- =========================
                                         ANCIEN ARTICLE SANS
                                         BANNIÈRE
                                         ========================= -->
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


                                <!-- =============================
                                     DATE
                                     ============================= -->
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


                                <!-- =============================
                                     TITRE
                                     ============================= -->
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


                                <!-- =============================
                                     RÉSUMÉ
                                     ============================= -->
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
                                     AUTEUR
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
                                         MARQUE VISUELLE BTT
                                         ========================= -->
                                    <div
                                        class="
                                            flex
                                            h-8
                                            w-8
                                            shrink-0
                                            items-center
                                            justify-center
                                            bg-red-600
                                            text-[10px]
                                            font-black
                                            text-white
                                        "
                                    >
                                        BTT
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