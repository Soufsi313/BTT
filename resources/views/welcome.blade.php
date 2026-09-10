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

        <!-- Bannière principale du site BTT -->
        <img
            src="{{ asset('images/BTTbanniere.png') }}"
            alt="Brussels Top Team - Dépasse tes limites"
            class="block h-auto w-full"
        >

        <!-- =====================================================
             BOUTON : DÉCOUVRIR NOS DISCIPLINES
             Descend directement vers la section des disciplines.
             ===================================================== -->
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

            <!-- Flèche du bouton -->
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


        <!-- =====================================================
             BOUTON : REJOINDRE BTT
             Pointera vers la future page d'inscription.
             ===================================================== -->
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

            <!-- Flèche du bouton -->
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

            <!-- =====================================================
                 EN-TÊTE DE LA SECTION
                 ===================================================== -->
            <div class="max-w-3xl">

                <p class="text-sm font-black uppercase tracking-[0.3em] text-red-500">
                    Brussels Top Team
                </p>

                <h2 class="mt-4 text-4xl font-black uppercase tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Nos disciplines
                </h2>

                <p class="mt-6 text-lg leading-8 text-zinc-400">
                    Brussels Top Team propose plusieurs activités sportives
                    destinées aux hommes et aux femmes, avec des séances
                    encadrées et adaptées à chaque discipline.
                </p>

            </div>


            <!-- =====================================================
                 GRILLE DES DISCIPLINES

                 Mobile      : 1 colonne
                 Tablette    : 2 colonnes
                 Grand écran : 3 colonnes
                 ===================================================== -->
            <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-3">


                <!-- =================================================
                     DISCIPLINE : FUTSAL

                     Image utilisée :
                     public/images/BTTfutsal.png

                     object-contain permet d'afficher l'image complète
                     sans couper le haut ou les côtés.
                     ================================================= -->
                <article
                    class="
                        group
                        overflow-hidden
                        border
                        border-zinc-800
                        bg-black
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >

                    <!-- Image Futsal -->
                    <div class="relative aspect-square overflow-hidden bg-black">

                        <img
                            src="{{ asset('images/BTTfutsal.png') }}"
                            alt="Équipe Futsal Brussels Top Team"
                            class="
                                h-full
                                w-full
                                object-contain
                                transition-transform
                                duration-500
                                group-hover:scale-[1.02]
                            "
                            loading="lazy"
                        >

                        <!-- Dégradé léger en bas de l'image -->
                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-x-0
                                bottom-0
                                h-16
                                bg-gradient-to-t
                                from-black
                                to-transparent
                            "
                        ></div>

                    </div>


                    <!-- Contenu Futsal -->
                    <div class="p-8">

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

                        <!-- Horaires Futsal -->
                        <div class="mt-8 border-t border-zinc-800 pt-6">

                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">
                                Horaires
                            </p>

                            <p class="mt-2 font-bold text-zinc-300">
                                Horaires à confirmer
                            </p>

                        </div>

                    </div>

                </article>


                <!-- =================================================
                     DISCIPLINE : HYROX

                     Image utilisée :
                     public/images/BTThyrox.png

                     object-contain est conservé pour empêcher
                     le rognage de l'image.
                     ================================================= -->
                <article
                    class="
                        group
                        overflow-hidden
                        border
                        border-zinc-800
                        bg-black
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >

                    <!-- Image HYROX -->
                    <div class="relative aspect-square overflow-hidden bg-black">

                        <img
                            src="{{ asset('images/BTThyrox.png') }}"
                            alt="Entraînement HYROX Brussels Top Team"
                            class="
                                h-full
                                w-full
                                object-contain
                                transition-transform
                                duration-500
                                group-hover:scale-[1.02]
                            "
                            loading="lazy"
                        >

                        <!-- Dégradé léger en bas de l'image -->
                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-x-0
                                bottom-0
                                h-16
                                bg-gradient-to-t
                                from-black
                                to-transparent
                            "
                        ></div>

                    </div>


                    <!-- Contenu HYROX -->
                    <div class="p-8">

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

                        <!-- Horaires HYROX -->
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

                    </div>

                </article>


                <!-- =================================================
                     DISCIPLINE : BTT BOXE HOMMES

                     Image utilisée :
                     public/images/BTTring.jpg
                     ================================================= -->
                <article
                    class="
                        group
                        overflow-hidden
                        border
                        border-zinc-800
                        bg-black
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >

                    <!-- Photo du ring / salle BTT -->
                    <div class="relative aspect-square overflow-hidden bg-zinc-900">

                        <img
                            src="{{ asset('images/BTTring.jpg') }}"
                            alt="Salle de boxe Brussels Top Team"
                            class="
                                h-full
                                w-full
                                object-cover
                                transition-transform
                                duration-500
                                group-hover:scale-105
                            "
                            loading="lazy"
                        >

                        <!-- Dégradé entre la photo et le contenu -->
                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-x-0
                                bottom-0
                                h-24
                                bg-gradient-to-t
                                from-black
                                to-transparent
                            "
                        ></div>

                    </div>


                    <!-- Contenu BTT Boxe Hommes -->
                    <div class="p-8">

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

                        <!-- Horaires Boxe Hommes -->
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

                    </div>

                </article>


                <!-- =================================================
                     DISCIPLINE : BTT BOXE FEMMES

                     Image utilisée :
                     public/images/BTTgirl2.jpg
                     ================================================= -->
                <article
                    class="
                        group
                        overflow-hidden
                        border
                        border-zinc-800
                        bg-black
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-red-600
                    "
                >

                    <!-- Image BTT Boxe Femmes -->
                    <div class="relative aspect-square overflow-hidden bg-zinc-900">

                        <img
                            src="{{ asset('images/BTTgirl2.jpg') }}"
                            alt="BTT Boxe et remise en forme 100% féminine"
                            class="
                                h-full
                                w-full
                                object-cover
                                transition-transform
                                duration-500
                                group-hover:scale-105
                            "
                            loading="lazy"
                        >

                        <!-- Dégradé entre l'image et le contenu -->
                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-x-0
                                bottom-0
                                h-24
                                bg-gradient-to-t
                                from-black
                                to-transparent
                            "
                        ></div>

                    </div>


                    <!-- Contenu BTT Boxe Femmes -->
                    <div class="p-8">

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

                        <!-- Horaires Boxe Femmes -->
                        <div class="mt-8 border-t border-zinc-800 pt-6">

                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">
                                Horaires
                            </p>

                            <p class="mt-2 font-bold text-zinc-300">
                                Horaires à confirmer
                            </p>

                        </div>

                    </div>

                </article>


                

            </div>

        </div>
    </section>

@endsection