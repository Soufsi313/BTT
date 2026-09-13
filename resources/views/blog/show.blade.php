
@extends('layouts.app')


@section('title', $article->title . ' - Brussels Top Team')


@section(
    'meta_description',
    $article->excerpt
        ?: 'Découvrez cette actualité du Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         ARTICLE PUBLIC - BRUSSELS TOP TEAM
         =========================================================
         Cette page affiche un article individuel.

         L'article est récupéré par :

         BlogController@show

         L'accès public est autorisé uniquement si l'article :
         - est publié ;
         - possède une date de publication valide ;
         - n'est pas supprimé.
         ========================================================= -->


    <!-- =========================================================
         EN-TÊTE DE L'ARTICLE
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
             AMBIANCE VISUELLE
             ===================================================== -->
        <div
            class="
                pointer-events-none
                absolute
                -right-32
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


        <div
            class="
                relative
                mx-auto
                max-w-6xl
                px-6
                py-10
                lg:px-8
                lg:py-14
            "
        >


            <!-- =================================================
                 RETOUR AU BLOG
                 ================================================= -->
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
                <span aria-hidden="true">
                    ←
                </span>

                Toutes les actualités
            </a>


            <!-- =================================================
                 INFORMATIONS DE L'ARTICLE
                 ================================================= -->
            <div class="mt-10 max-w-4xl">


                <!-- =============================================
                     CATÉGORIE
                     ============================================= -->
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


                <!-- =============================================
                     ARTICLE MIS EN AVANT
                     ============================================= -->
                @if ($article->is_featured)

                    <span
                        class="
                            ml-2
                            inline-flex
                            border
                            border-zinc-700
                            bg-zinc-900
                            px-3
                            py-1.5
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-300
                        "
                    >
                        À la une
                    </span>

                @endif


                <!-- =============================================
                     TITRE
                     ============================================= -->
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


                <!-- =============================================
                     RÉSUMÉ
                     ============================================= -->
                @if ($article->excerpt)

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
                        {{ $article->excerpt }}
                    </p>

                @endif


                <!-- =============================================
                     INFORMATIONS DE PUBLICATION
                     ============================================= -->
                <div
                    class="
                        mt-8
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


                    <!-- DATE -->
                    <div>

                        <span
                            class="
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Publié le
                        </span>

                        <span class="ml-2 font-bold text-zinc-300">
                            {{ $article->published_at->format('d/m/Y') }}
                        </span>

                    </div>


                    <!-- AUTEUR -->
                    <div>

                        <span
                            class="
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Par
                        </span>

                        <span class="ml-2 font-bold text-zinc-300">

                            @if ($article->author)

                                {{ $article->author->pseudo }}

                            @else

                                Brussels Top Team

                            @endif

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         BANNIÈRE DE L'ARTICLE
         ========================================================= -->
    @if ($article->banner_image)

        <section class="bg-black">

            <div
                class="
                    mx-auto
                    max-w-6xl
                    px-6
                    py-8
                    lg:px-8
                    lg:py-10
                "
            >

                <!-- =============================================
                     CONTENEUR DE LA BANNIÈRE
                     =============================================
                     object-contain est utilisé volontairement.

                     Cela permet de voir l'intégralité de la bannière
                     sans rogner les côtés ou le haut de l'image.
                     ============================================= -->
                <div
                    class="
                        overflow-hidden
                        border
                        border-zinc-800
                        bg-zinc-950
                    "
                >

                    <img
                        src="{{ asset('storage/' . $article->banner_image) }}"
                        alt="{{ $article->title }}"
                        class="
                            mx-auto
                            block
                            max-h-[650px]
                            w-full
                            object-contain
                        "
                    >

                </div>

            </div>

        </section>

    @endif


    <!-- =========================================================
         CONTENU DE L'ARTICLE
         ========================================================= -->
    <section class="bg-zinc-950">

        <div
            class="
                mx-auto
                max-w-6xl
                px-6
                py-12
                lg:px-8
                lg:py-16
            "
        >

            <div
                class="
                    grid
                    gap-10
                    lg:grid-cols-[minmax(0,1fr)_220px]
                "
            >


                <!-- =================================================
                     TEXTE PRINCIPAL
                     ================================================= -->
                <article
                    class="
                        min-w-0
                        border-t
                        border-zinc-800
                        pt-8
                    "
                >

                    <!-- =============================================
                         CONTENU
                         =============================================
                         Le contenu est actuellement enregistré sous
                         forme de texte dans la base de données.

                         e() protège le contenu contre l'injection HTML.

                         nl2br() transforme les retours à la ligne en
                         sauts de ligne HTML afin de conserver une
                         lecture agréable.

                         Plus tard, cette partie pourra évoluer pour
                         accepter des images intégrées au milieu du
                         contenu.
                         ============================================= -->
                    <div
                        class="
                            text-base
                            leading-8
                            text-zinc-300
                            sm:text-lg
                            sm:leading-9
                        "
                    >
                        {!! nl2br(e($article->content)) !!}
                    </div>

                </article>


                <!-- =================================================
                     COLONNE LATÉRALE
                     ================================================= -->
                <aside
                    class="
                        border-t
                        border-zinc-800
                        pt-8
                        lg:border-l
                        lg:border-t-0
                        lg:pl-8
                        lg:pt-0
                    "
                >


                    <!-- =============================================
                         IDENTITÉ BTT
                         ============================================= -->
                    <div>

                        <div
                            class="
                                flex
                                h-14
                                w-14
                                items-center
                                justify-center
                                bg-red-600
                                text-sm
                                font-black
                                text-white
                            "
                        >
                            BTT
                        </div>


                        <p
                            class="
                                mt-5
                                text-xs
                                font-black
                                uppercase
                                tracking-[0.25em]
                                text-red-500
                            "
                        >
                            Brussels Top Team
                        </p>


                        <p
                            class="
                                mt-3
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Retrouvez les dernières nouvelles,
                            événements et informations de la vie
                            du club.
                        </p>

                    </div>


                    <!-- =============================================
                         CATÉGORIE
                         ============================================= -->
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
                                text-[10px]
                                font-black
                                uppercase
                                tracking-[0.25em]
                                text-zinc-600
                            "
                        >
                            Catégorie
                        </p>

                        <p
                            class="
                                mt-2
                                text-sm
                                font-black
                                text-white
                            "
                        >
                            {{ $article->category }}
                        </p>

                    </div>


                    <!-- =============================================
                         DATE
                         ============================================= -->
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
                                text-[10px]
                                font-black
                                uppercase
                                tracking-[0.25em]
                                text-zinc-600
                            "
                        >
                            Publication
                        </p>

                        <p
                            class="
                                mt-2
                                text-sm
                                font-bold
                                text-zinc-400
                            "
                        >
                            {{ $article->published_at->format('d/m/Y') }}
                        </p>

                    </div>

                </aside>

            </div>


            <!-- =================================================
                 RETOUR AUX ACTUALITÉS
                 ================================================= -->
            <div
                class="
                    mt-16
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

        </div>

    </section>

@endsection