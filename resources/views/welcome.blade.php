@extends('layouts.app')

@section('title', 'Brussels Top Team')

@section(
    'meta_description',
    'Découvrez Brussels Top Team, ses disciplines sportives, ses coachs et ses activités à Bruxelles.'
)

@section('content')

    <!-- =========================================================
         HERO PRINCIPAL
         ========================================================= -->
    <section class="relative w-full overflow-hidden bg-black">

        <!-- Bannière principale -->
        <img
            src="{{ asset('images/BTTbanniere.png') }}"
            alt="Brussels Top Team - Dépasse tes limites"
            class="block h-auto w-full"
        >

        <!-- Bouton interactif : Découvrir nos disciplines -->
        <a
            href="#disciplines"
            class="
                group
                absolute
                left-[4.6%]
                top-[75.1%]
                flex
                h-[8.1%]
                w-[20.1%]
                items-center
                justify-between
                bg-red-600
                px-[1.8%]
                font-black
                uppercase
                tracking-wide
                text-white
                transition-all
                duration-300
                hover:bg-white
                hover:text-black
            "
        >
            <span class="text-[clamp(0.35rem,1vw,1.05rem)]">
                Découvrir nos disciplines
            </span>

            <svg
                class="h-[35%] w-auto transition-transform duration-300 group-hover:translate-x-1"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M5 12h14"></path>
                <path d="m13 6 6 6-6 6"></path>
            </svg>
        </a>

        <!-- Bouton interactif : Rejoindre BTT -->
        <a
            href="{{ url('/inscription') }}"
            class="
                group
                absolute
                left-[25.9%]
                top-[75.1%]
                flex
                h-[8.1%]
                w-[14.1%]
                items-center
                justify-between
                border-2
                border-red-600
                bg-black
                px-[1.8%]
                font-black
                uppercase
                tracking-wide
                text-white
                transition-all
                duration-300
                hover:bg-red-600
            "
        >
            <span class="text-[clamp(0.35rem,1vw,1.05rem)]">
                Rejoindre BTT
            </span>

            <svg
                class="h-[35%] w-auto transition-transform duration-300 group-hover:translate-x-1"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M5 12h14"></path>
                <path d="m13 6 6 6-6 6"></path>
            </svg>
        </a>

    </section>


    <!-- =========================================================
         SECTION : NOS DISCIPLINES
         ========================================================= -->
    <section
        id="disciplines"
        class="bg-zinc-950 px-6 py-20 lg:px-8 lg:py-28"
    >
        <div class="mx-auto max-w-7xl">

            <!-- En-tête de la section -->
            <div class="max-w-3xl">

                <!-- Petit titre rouge -->
                <p class="text-sm font-black uppercase tracking-[0.3em] text-red-500">
                    Brussels Top Team
                </p>

                <!-- Titre principal -->
                <h2 class="mt-4 text-4xl font-black uppercase tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Nos disciplines
                </h2>

                <!-- Présentation courte -->
                <p class="mt-6 text-lg leading-8 text-zinc-400">
                    Brussels Top Team propose plusieurs activités sportives
                    destinées aux hommes et aux femmes, avec des séances
                    encadrées et adaptées à chaque discipline.
                </p>

            </div>


            <!-- Grille des disciplines -->
            <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-3">

                <!-- =====================================================
                     FUTSAL
                     ===================================================== -->
                <article
                    class="
                        group
                        border
                        border-zinc-800
                        bg-black
                        p-8
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-red-500">
                        Sport collectif
                    </p>

                    <h3 class="mt-4 text-3xl font-black uppercase text-white">
                        Futsal
                    </h3>

                    <p class="mt-4 leading-7 text-zinc-400">
                        L'équipe BTT Futsal évolue en minifoot et permet aux
                        membres de pratiquer un sport collectif dynamique,
                        technique et compétitif.
                    </p>

                    <!-- Horaires -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-white">
                            À confirmer
                        </p>

                    </div>
                </article>


                <!-- =====================================================
                     HYROX
                     ===================================================== -->
                <article
                    class="
                        group
                        border
                        border-zinc-800
                        bg-black
                        p-8
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-red-500">
                        Fitness & endurance
                    </p>

                    <h3 class="mt-4 text-3xl font-black uppercase text-white">
                        HYROX
                    </h3>

                    <p class="mt-4 leading-7 text-zinc-400">
                        Une séance complète combinant endurance, cardio,
                        renforcement musculaire et exercices fonctionnels.
                    </p>

                    <!-- Horaires -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-white">
                            Tous les mardis
                        </p>

                        <p class="mt-1 text-red-500">
                            19h30 - 21h00
                        </p>

                    </div>
                </article>


                <!-- =====================================================
                     BOXE HOMMES
                     ===================================================== -->
                <article
                    class="
                        group
                        border
                        border-zinc-800
                        bg-black
                        p-8
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-red-500">
                        Hommes
                    </p>

                    <h3 class="mt-4 text-3xl font-black uppercase text-white">
                        BTT Boxe
                    </h3>

                    <p class="mt-4 leading-7 text-zinc-400">
                        Séances de boxe anglaise destinées aux hommes,
                        avec travail technique, condition physique,
                        déplacements et apprentissage des fondamentaux.
                    </p>

                    <!-- Horaires -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-white">
                            Tous les jeudis
                        </p>

                        <p class="mt-1 text-red-500">
                            19h30 - 21h00
                        </p>

                    </div>
                </article>


                <!-- =====================================================
                     BOXE FEMMES
                     ===================================================== -->
                <article
                    class="
                        group
                        border
                        border-zinc-800
                        bg-black
                        p-8
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-red-500">
                        Femmes
                    </p>

                    <h3 class="mt-4 text-3xl font-black uppercase text-white">
                        BTT Boxe Femmes
                    </h3>

                    <p class="mt-4 leading-7 text-zinc-400">
                        Des séances de boxe anglaise réservées aux femmes,
                        dans un cadre dédié à l'apprentissage, à la progression
                        technique et à la condition physique.
                    </p>

                    <!-- Horaires -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-zinc-300">
                            Horaires à confirmer
                        </p>

                    </div>
                </article>


                <!-- =====================================================
                     FITNESS FEMMES
                     ===================================================== -->
                <article
                    class="
                        group
                        border
                        border-zinc-800
                        bg-black
                        p-8
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-red-500">
                        Femmes
                    </p>

                    <h3 class="mt-4 text-3xl font-black uppercase text-white">
                        BTT Fitness
                    </h3>

                    <p class="mt-4 leading-7 text-zinc-400">
                        Des séances fitness réservées aux femmes,
                        orientées vers le cardio, le renforcement musculaire
                        et l'amélioration de la condition physique.
                    </p>

                    <!-- Horaires -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-zinc-300">
                            Horaires à confirmer
                        </p>

                    </div>
                </article>

            </div>

        </div>
    </section>

@endsection