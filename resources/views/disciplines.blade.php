@extends('layouts.app')

@section('title', 'Nos disciplines - Brussels Top Team')

@section(
    'meta_description',
    'Découvrez les disciplines proposées par Brussels Top Team à Bruxelles : futsal, HYROX, boxe anglaise hommes et boxe anglaise femmes.'
)

@section('content')

    <!-- =========================================================
         HERO DE LA PAGE DISCIPLINES
         ========================================================= -->
    <section
        class="
            relative
            overflow-hidden
            border-b
            border-zinc-900
            bg-black
            px-6
            py-20
            lg:px-8
            lg:py-28
        "
    >

        <!--
            Élément décoratif rouge.
            Il reste volontairement discret afin de conserver
            l'identité noire / rouge / blanche de BTT.
        -->
        <div
            class="
                pointer-events-none
                absolute
                -right-24
                -top-24
                h-80
                w-80
                rounded-full
                bg-red-600/10
                blur-3xl
            "
        ></div>


        <div class="relative mx-auto max-w-7xl">

            <!-- Petit texte d'introduction -->
            <p
                class="
                    text-sm
                    font-black
                    uppercase
                    tracking-[0.3em]
                    text-red-500
                "
            >
                Brussels Top Team
            </p>

            <!-- Titre principal -->
            <h1
                class="
                    mt-4
                    max-w-4xl
                    text-5xl
                    font-black
                    uppercase
                    tracking-tight
                    text-white
                    sm:text-6xl
                    lg:text-7xl
                "
            >
                Nos disciplines
            </h1>

            <!-- Présentation générale -->
            <p
                class="
                    mt-6
                    max-w-3xl
                    text-lg
                    leading-8
                    text-zinc-400
                "
            >
                Brussels Top Team propose plusieurs disciplines sportives
                permettant de développer la technique, la condition physique,
                l'endurance et l'esprit d'équipe dans un cadre encadré.
            </p>

        </div>

    </section>


    <!-- =========================================================
         LISTE DES DISCIPLINES
         ========================================================= -->
    <section class="bg-zinc-950 px-6 py-20 lg:px-8 lg:py-28">

        <div class="mx-auto max-w-7xl">

            <!-- =====================================================
                 DISCIPLINE 1 : FUTSAL
                 ===================================================== -->
            <article
                class="
                    grid
                    overflow-hidden
                    border
                    border-zinc-800
                    bg-black
                    lg:grid-cols-2
                "
            >

                <!-- Image Futsal -->
                <div class="relative min-h-[320px] bg-black lg:min-h-[500px]">

                    <img
                        src="{{ asset('images/BTTfutsal.png') }}"
                        alt="Brussels Top Team Futsal"
                        class="
                            absolute
                            inset-0
                            h-full
                            w-full
                            object-contain
                            p-4
                            lg:p-8
                        "
                    >

                </div>


                <!-- Contenu Futsal -->
                <div class="flex flex-col justify-center p-8 lg:p-14">

                    <p
                        class="
                            text-sm
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-red-500
                        "
                    >
                        Sport collectif
                    </p>

                    <h2
                        class="
                            mt-4
                            text-4xl
                            font-black
                            uppercase
                            text-white
                            lg:text-5xl
                        "
                    >
                        Futsal
                    </h2>

                    <p class="mt-6 leading-8 text-zinc-400">
                        L'équipe BTT Futsal évolue en minifoot et permet aux
                        membres de pratiquer un sport collectif dynamique,
                        technique et compétitif.
                    </p>


                    <!-- Horaires Futsal -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-[0.2em]
                                text-zinc-500
                            "
                        >
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-zinc-300">
                            Horaires à confirmer
                        </p>

                    </div>

                </div>

            </article>


            <!-- =====================================================
                 DISCIPLINE 2 : HYROX
                 ===================================================== -->
            <article
                class="
                    mt-10
                    grid
                    overflow-hidden
                    border
                    border-zinc-800
                    bg-black
                    lg:grid-cols-2
                "
            >

                <!--
                    Sur grand écran, le texte passe à gauche
                    et l'image à droite afin d'alterner la composition.
                -->
                <div
                    class="
                        order-2
                        flex
                        flex-col
                        justify-center
                        p-8
                        lg:order-1
                        lg:p-14
                    "
                >

                    <p
                        class="
                            text-sm
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-red-500
                        "
                    >
                        Fitness & endurance
                    </p>

                    <h2
                        class="
                            mt-4
                            text-4xl
                            font-black
                            uppercase
                            text-white
                            lg:text-5xl
                        "
                    >
                        HYROX
                    </h2>

                    <p class="mt-6 leading-8 text-zinc-400">
                        Une séance complète combinant endurance, cardio,
                        renforcement musculaire et exercices fonctionnels.
                        L'objectif est de développer une condition physique
                        complète tout en progressant dans l'effort.
                    </p>


                    <!-- Horaires HYROX -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-[0.2em]
                                text-zinc-500
                            "
                        >
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-white">
                            Tous les mardis
                        </p>

                        <p class="mt-1 font-semibold text-red-500">
                            19h30 - 21h00
                        </p>

                    </div>

                </div>


                <!-- Image HYROX -->
                <div
                    class="
                        relative
                        order-1
                        min-h-[320px]
                        bg-black
                        lg:order-2
                        lg:min-h-[500px]
                    "
                >

                    <img
                        src="{{ asset('images/BTThyrox.png') }}"
                        alt="Entraînement HYROX Brussels Top Team"
                        class="
                            absolute
                            inset-0
                            h-full
                            w-full
                            object-contain
                            p-4
                            lg:p-8
                        "
                    >

                </div>

            </article>


            <!-- =====================================================
                 DISCIPLINE 3 : BTT BOXE HOMMES
                 ===================================================== -->
            <article
                class="
                    mt-10
                    grid
                    overflow-hidden
                    border
                    border-zinc-800
                    bg-black
                    lg:grid-cols-2
                "
            >

                <!-- Photo de la salle / ring BTT -->
                <div class="relative min-h-[320px] bg-zinc-900 lg:min-h-[500px]">

                    <img
                        src="{{ asset('images/BTTring.jpg') }}"
                        alt="Salle de boxe Brussels Top Team"
                        class="
                            absolute
                            inset-0
                            h-full
                            w-full
                            object-cover
                        "
                    >

                    <!--
                        Léger voile sombre pour mieux intégrer
                        la photo dans le design global.
                    -->
                    <div
                        class="
                            pointer-events-none
                            absolute
                            inset-0
                            bg-gradient-to-t
                            from-black/40
                            via-transparent
                            to-transparent
                        "
                    ></div>

                </div>


                <!-- Contenu Boxe Hommes -->
                <div class="flex flex-col justify-center p-8 lg:p-14">

                    <p
                        class="
                            text-sm
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-red-500
                        "
                    >
                        Hommes
                    </p>

                    <h2
                        class="
                            mt-4
                            text-4xl
                            font-black
                            uppercase
                            text-white
                            lg:text-5xl
                        "
                    >
                        BTT Boxe
                    </h2>

                    <p class="mt-6 leading-8 text-zinc-400">
                        Les séances de boxe anglaise destinées aux hommes
                        permettent de travailler la technique, les déplacements,
                        la condition physique et les fondamentaux de la discipline.
                    </p>


                    <!-- Horaires Boxe Hommes -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-[0.2em]
                                text-zinc-500
                            "
                        >
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-white">
                            Tous les jeudis
                        </p>

                        <p class="mt-1 font-semibold text-red-500">
                            19h30 - 21h00
                        </p>

                    </div>

                </div>

            </article>


            <!-- =====================================================
                 DISCIPLINE 4 : BTT BOXE FEMMES
                 ===================================================== -->
            <article
                class="
                    mt-10
                    grid
                    overflow-hidden
                    border
                    border-zinc-800
                    bg-black
                    lg:grid-cols-2
                "
            >

                <!-- Contenu Boxe Femmes -->
                <div
                    class="
                        order-2
                        flex
                        flex-col
                        justify-center
                        p-8
                        lg:order-1
                        lg:p-14
                    "
                >

                    <p
                        class="
                            text-sm
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-red-500
                        "
                    >
                        Femmes
                    </p>

                    <h2
                        class="
                            mt-4
                            text-4xl
                            font-black
                            uppercase
                            text-white
                            lg:text-5xl
                        "
                    >
                        BTT Boxe Femmes
                    </h2>

                    <p class="mt-6 leading-8 text-zinc-400">
                        Des séances de boxe anglaise réservées aux femmes,
                        avec un travail axé sur l'apprentissage, la progression
                        technique et l'amélioration de la condition physique.
                    </p>


                    <!-- Horaires Boxe Femmes -->
                    <div class="mt-8 border-t border-zinc-800 pt-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-[0.2em]
                                text-zinc-500
                            "
                        >
                            Horaires
                        </p>

                        <p class="mt-2 font-bold text-zinc-300">
                            Horaires à confirmer
                        </p>

                    </div>

                </div>


                <!-- Image BTT Boxe Femmes -->
                <div
                    class="
                        relative
                        order-1
                        min-h-[320px]
                        bg-zinc-900
                        lg:order-2
                        lg:min-h-[500px]
                    "
                >

                    <img
                        src="{{ asset('images/BTTgirl2.jpg') }}"
                        alt="BTT Boxe Femmes"
                        class="
                            absolute
                            inset-0
                            h-full
                            w-full
                            object-cover
                        "
                    >

                    <!-- Voile sombre léger -->
                    <div
                        class="
                            pointer-events-none
                            absolute
                            inset-0
                            bg-gradient-to-t
                            from-black/40
                            via-transparent
                            to-transparent
                        "
                    ></div>

                </div>

            </article>

        </div>

    </section>

@endsection