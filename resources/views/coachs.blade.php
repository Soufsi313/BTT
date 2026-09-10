@extends('layouts.app')

@section('title', 'Nos coachs - Brussels Top Team')

@section(
    'meta_description',
    'Découvrez les coachs de Brussels Top Team et les entraînements de boxe, renforcement musculaire et HYROX proposés à Bruxelles.'
)

@section('content')


    <!-- =========================================================
         HERO DE LA PAGE COACHS
         ========================================================= -->
    <section
        class="
            relative
            overflow-hidden
            border-b
            border-zinc-900
            bg-zinc-950
            px-6
            py-20
            lg:px-8
            lg:py-28
        "
    >

        <!--
            Élément graphique rouge très discret.
            Il rappelle l'identité visuelle BTT sans utiliser
            une bannière supplémentaire.
        -->
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
                    text-sm
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
                Ceux qui vous font
                <span class="text-red-600">progresser</span>
            </h1>


            <p
                class="
                    mt-8
                    max-w-2xl
                    text-lg
                    leading-8
                    text-zinc-400
                "
            >
                Technique, condition physique, discipline et dépassement
                de soi. Les coachs de Brussels Top Team accompagnent
                les pratiquants à chaque entraînement et à chaque étape
                de leur progression.
            </p>

        </div>

    </section>


    <!-- =========================================================
         COACH HASSAN
         ========================================================= -->
    <section class="overflow-hidden bg-black">

        <div
            class="
                mx-auto
                grid
                max-w-7xl
                lg:min-h-[720px]
                lg:grid-cols-2
            "
        >


            <!-- =====================================================
                 PHOTO DU COACH HASSAN
                 ===================================================== -->
            <div
                class="
                    relative
                    flex
                    items-end
                    justify-center
                    overflow-hidden
                    bg-black
                "
            >

                <!--
                    Photo officielle utilisée pour le profil.

                    Fichier :
                    public/images/BTThassan.png
                -->
                <img
                    src="{{ asset('images/BTThassan.png') }}"
                    alt="Coach Hassan - Brussels Top Team"
                    class="
                        block
                        h-auto
                        w-full
                        object-contain
                        lg:h-full
                        lg:object-cover
                    "
                >


                <!--
                    Léger dégradé uniquement sur ordinateur.
                    Il permet à l'image de se fondre naturellement
                    dans le fond noir de la partie texte.
                -->
                <div
                    class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        right-0
                        hidden
                        w-32
                        bg-gradient-to-r
                        from-transparent
                        to-black
                        lg:block
                    "
                ></div>

            </div>


            <!-- =====================================================
                 PRÉSENTATION DU COACH
                 ===================================================== -->
            <div
                class="
                    flex
                    items-center
                    px-6
                    py-16
                    lg:px-14
                    lg:py-20
                "
            >

                <div class="max-w-xl">


                    <!-- Fonction -->
                    <p
                        class="
                            text-sm
                            font-black
                            uppercase
                            tracking-[0.3em]
                            text-red-500
                        "
                    >
                        Coach BTT
                    </p>


                    <!-- Nom -->
                    <h2
                        class="
                            mt-4
                            text-5xl
                            font-black
                            uppercase
                            tracking-tight
                            text-white
                            sm:text-6xl
                        "
                    >
                        Hassan
                    </h2>


                    <!-- Accroche -->
                    <p
                        class="
                            mt-5
                            text-xl
                            font-bold
                            leading-8
                            text-white
                            sm:text-2xl
                        "
                    >
                        Professeur le jour,
                        <span class="text-red-500">
                            entraîneur de choc la nuit.
                        </span>
                    </p>


                    <!-- Ligne décorative -->
                    <div class="my-8 h-px w-full bg-zinc-800">

                        <div class="h-px w-20 bg-red-600"></div>

                    </div>


                    <!-- Description -->
                    <div class="space-y-5 leading-8 text-zinc-400">

                        <p>
                            Coach Hassan encadre les entraînements BTT
                            du mardi et du jeudi avec deux approches
                            complémentaires : développer les capacités
                            physiques et athlétiques d'un côté, perfectionner
                            la technique de boxe de l'autre.
                        </p>

                        <p>
                            Deux séances différentes, mais un même objectif :
                            permettre à chacun de progresser à son rythme,
                            d'améliorer sa condition physique et de développer
                            ses qualités techniques.
                        </p>

                    </div>


                    <!-- Horaires rapides -->
                    <div
                        class="
                            mt-10
                            flex
                            flex-wrap
                            gap-x-10
                            gap-y-5
                            border-t
                            border-zinc-800
                            pt-7
                        "
                    >

                        <div>

                            <p
                                class="
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-[0.2em]
                                    text-zinc-500
                                "
                            >
                                Mardi
                            </p>

                            <p class="mt-2 font-bold text-white">
                                19h30 — 21h00
                            </p>

                        </div>


                        <div>

                            <p
                                class="
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-[0.2em]
                                    text-zinc-500
                                "
                            >
                                Jeudi
                            </p>

                            <p class="mt-2 font-bold text-white">
                                19h30 — 21h00
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         LES DEUX ENTRAÎNEMENTS DU COACH HASSAN
         ========================================================= -->
    <section
        class="
            border-y
            border-zinc-900
            bg-zinc-950
            px-6
            py-20
            lg:px-8
            lg:py-28
        "
    >

        <div class="mx-auto max-w-7xl">


            <!-- =====================================================
                 TITRE
                 ===================================================== -->
            <div class="max-w-3xl">

                <p
                    class="
                        text-sm
                        font-black
                        uppercase
                        tracking-[0.3em]
                        text-red-500
                    "
                >
                    Les entraînements
                </p>


                <h2
                    class="
                        mt-4
                        text-4xl
                        font-black
                        uppercase
                        tracking-tight
                        text-white
                        sm:text-5xl
                    "
                >
                    Deux jours.
                    <br>
                    Deux objectifs.
                </h2>

            </div>


            <!-- =====================================================
                 MARDI : RENFORCEMENT / HYROX
                 ===================================================== -->
            <div
                class="
                    mt-16
                    grid
                    border-t
                    border-zinc-800
                    py-12
                    lg:grid-cols-[0.45fr_1.55fr]
                    lg:gap-20
                    lg:py-16
                "
            >

                <!-- Jour et horaire -->
                <div>

                    <p
                        class="
                            text-3xl
                            font-black
                            uppercase
                            text-red-600
                        "
                    >
                        Mardi
                    </p>

                    <p
                        class="
                            mt-2
                            text-sm
                            font-bold
                            uppercase
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        19h30 — 21h00
                    </p>

                </div>


                <!-- Contenu de la séance -->
                <div class="mt-8 lg:mt-0">

                    <h3
                        class="
                            text-3xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        Renforcement & HYROX
                    </h3>


                    <p
                        class="
                            mt-6
                            max-w-4xl
                            text-lg
                            leading-8
                            text-zinc-400
                        "
                    >
                        Une séance intensive axée sur la préparation physique
                        générale. Les entraînements prennent la forme d'ateliers
                        et de parcours permettant de travailler l'ensemble
                        du corps.
                    </p>


                    <!--
                        Liste des principaux exercices.
                        Ils sont volontairement présentés de manière sobre,
                        sans grosses cartes.
                    -->
                    <div
                        class="
                            mt-8
                            grid
                            gap-x-8
                            gap-y-4
                            sm:grid-cols-2
                        "
                    >

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Renforcement musculaire
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Frappes au sac
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Pompes & abdominaux
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Shadow boxing
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Musculation
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Parcours HYROX
                        </p>

                    </div>


                    <p
                        class="
                            mt-8
                            max-w-4xl
                            font-semibold
                            leading-8
                            text-white
                        "
                    >
                        Objectif : développer l'endurance, la puissance,
                        l'explosivité et le dépassement de soi.
                    </p>

                </div>

            </div>


            <!-- =====================================================
                 JEUDI : BOXE ANGLAISE
                 ===================================================== -->
            <div
                class="
                    grid
                    border-y
                    border-zinc-800
                    py-12
                    lg:grid-cols-[0.45fr_1.55fr]
                    lg:gap-20
                    lg:py-16
                "
            >

                <!-- Jour et horaire -->
                <div>

                    <p
                        class="
                            text-3xl
                            font-black
                            uppercase
                            text-red-600
                        "
                    >
                        Jeudi
                    </p>

                    <p
                        class="
                            mt-2
                            text-sm
                            font-bold
                            uppercase
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        19h30 — 21h00
                    </p>

                </div>


                <!-- Contenu de la séance -->
                <div class="mt-8 lg:mt-0">

                    <h3
                        class="
                            text-3xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        Boxe anglaise
                    </h3>


                    <p
                        class="
                            mt-6
                            max-w-4xl
                            text-lg
                            leading-8
                            text-zinc-400
                        "
                    >
                        Le jeudi, place à la boxe. La séance est davantage
                        consacrée au travail technique, à l'apprentissage
                        des fondamentaux et à leur mise en pratique.
                    </p>


                    <!-- Exercices du jeudi -->
                    <div
                        class="
                            mt-8
                            grid
                            gap-x-8
                            gap-y-4
                            sm:grid-cols-2
                        "
                    >

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Échauffement & shadow boxing
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Boxe éducative
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Travail en binôme
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Déplacements
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Saut à la corde
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Travail explosif
                        </p>

                        <p class="border-l-2 border-red-600 pl-4 text-zinc-300">
                            Sparring léger
                        </p>

                    </div>


                    <p
                        class="
                            mt-8
                            max-w-4xl
                            font-semibold
                            leading-8
                            text-white
                        "
                    >
                        Objectif : apprendre, répéter et maîtriser progressivement
                        les fondamentaux de la boxe dans un cadre encadré.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         COACH LAMIA
         ========================================================= -->
    <section class="bg-black px-6 py-20 lg:px-8 lg:py-28">

        <div class="mx-auto max-w-7xl">


            <!--
                Pour le moment, aucune photographie de Coach Lamia
                n'est disponible.

                On évite volontairement d'utiliser une fausse photo
                ou une image générée.
            -->
            <div
                class="
                    grid
                    gap-12
                    lg:grid-cols-[0.75fr_1.25fr]
                    lg:items-center
                    lg:gap-20
                "
            >


                <!-- =================================================
                     IDENTITÉ VISUELLE TEMPORAIRE
                     ================================================= -->
                <div
                    class="
                        flex
                        min-h-[360px]
                        items-center
                        justify-center
                        rounded-2xl
                        border
                        border-zinc-800
                        bg-zinc-950
                        px-8
                        text-center
                    "
                >

                    <div>

                        <p
                            class="
                                text-sm
                                font-black
                                uppercase
                                tracking-[0.3em]
                                text-red-500
                            "
                        >
                            BTT Femmes
                        </p>

                        <p
                            class="
                                mt-4
                                text-5xl
                                font-black
                                uppercase
                                text-white
                            "
                        >
                            Coach
                            <br>
                            Lamia
                        </p>

                    </div>

                </div>


                <!-- =================================================
                     DESCRIPTION DE COACH LAMIA
                     ================================================= -->
                <div>

                    <p
                        class="
                            text-sm
                            font-black
                            uppercase
                            tracking-[0.3em]
                            text-red-500
                        "
                    >
                        Section femmes
                    </p>


                    <h2
                        class="
                            mt-4
                            text-5xl
                            font-black
                            uppercase
                            tracking-tight
                            text-white
                            sm:text-6xl
                        "
                    >
                        Coach Lamia
                    </h2>


                    <p
                        class="
                            mt-6
                            text-xl
                            font-bold
                            text-zinc-300
                        "
                    >
                        Boxe & Kickboxing
                    </p>


                    <div class="my-8 h-px w-full max-w-xl bg-zinc-800">

                        <div class="h-px w-20 bg-red-600"></div>

                    </div>


                    <p
                        class="
                            max-w-2xl
                            leading-8
                            text-zinc-400
                        "
                    >
                        Coach Lamia encadre les pratiquantes de la section
                        féminine de Brussels Top Team à travers des entraînements
                        de boxe et de kickboxing.
                    </p>


                    <p
                        class="
                            mt-5
                            max-w-2xl
                            leading-8
                            text-zinc-500
                        "
                    >
                        Les informations complémentaires concernant ses séances
                        seront prochainement disponibles.
                    </p>

                </div>

            </div>

        </div>

    </section>


@endsection