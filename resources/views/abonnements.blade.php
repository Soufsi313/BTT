@extends('layouts.app')

@section('title', 'Affiliation & tarifs - Brussels Top Team')

@section(
    'meta_description',
    'Découvrez le fonctionnement de l’affiliation Brussels Top Team : séances à 5 €, paiement en espèces et crédit de séances valable pendant un an.'
)

@section('content')


    <!-- =========================================================
         HERO - AFFILIATION BTT
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
                Une affiliation
                <span class="text-red-600">simple & flexible</span>
            </h1>


            <p
                class="
                    mt-8
                    max-w-3xl
                    text-lg
                    leading-8
                    text-zinc-400
                "
            >
                Vous participez aux séances selon vos disponibilités,
                sans abonnement mensuel obligatoire.
            </p>

        </div>

    </section>


    <!-- =========================================================
         INFORMATIONS ESSENTIELLES
         ========================================================= -->
    <section
        class="
            border-b
            border-zinc-900
            bg-zinc-950
            px-6
            py-16
            lg:px-8
            lg:py-20
        "
    >

        <div class="mx-auto max-w-7xl">

            <div
                class="
                    grid
                    gap-y-10
                    border-y
                    border-zinc-800
                    py-10
                    sm:grid-cols-2
                    lg:grid-cols-4
                "
            >


                <!-- Tarif -->
                <div class="sm:px-6 lg:border-r lg:border-zinc-800">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-zinc-500
                        "
                    >
                        Tarif
                    </p>

                    <p
                        class="
                            mt-3
                            text-3xl
                            font-black
                            text-white
                        "
                    >
                        5 € / séance
                    </p>

                </div>


                <!-- Paiement -->
                <div class="sm:px-6 lg:border-r lg:border-zinc-800">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-zinc-500
                        "
                    >
                        Paiement
                    </p>

                    <p
                        class="
                            mt-3
                            text-3xl
                            font-black
                            text-white
                        "
                    >
                        En espèces
                    </p>

                </div>


                <!-- Validité -->
                <div class="sm:px-6 lg:border-r lg:border-zinc-800">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-zinc-500
                        "
                    >
                        Validité
                    </p>

                    <p
                        class="
                            mt-3
                            text-3xl
                            font-black
                            text-white
                        "
                    >
                        1 an
                    </p>

                </div>


                <!-- Engagement -->
                <div class="sm:px-6">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-zinc-500
                        "
                    >
                        Engagement
                    </p>

                    <p
                        class="
                            mt-3
                            text-3xl
                            font-black
                            text-white
                        "
                    >
                        Aucun
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         FONCTIONNEMENT
         ========================================================= -->
    <section
        class="
            bg-black
            px-6
            py-20
            lg:px-8
            lg:py-28
        "
    >

        <div class="mx-auto max-w-7xl">


            <!-- Titre -->
            <div class="max-w-4xl">

                <p
                    class="
                        text-sm
                        font-black
                        uppercase
                        tracking-[0.3em]
                        text-red-500
                    "
                >
                    Comment ça fonctionne ?
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
                    Deux façons de participer
                </h2>

            </div>


            <!-- =================================================
                 OPTION 1
                 ================================================= -->
            <div
                class="
                    mt-16
                    grid
                    border-t
                    border-zinc-800
                    py-12
                    lg:grid-cols-[0.4fr_1.6fr]
                    lg:gap-20
                    lg:py-16
                "
            >

                <div>

                    <p
                        class="
                            text-5xl
                            font-black
                            text-red-600
                        "
                    >
                        01
                    </p>

                </div>


                <div class="mt-6 lg:mt-0">

                    <h3
                        class="
                            text-3xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        Régler uniquement la séance du jour
                    </h3>


                    <p
                        class="
                            mt-5
                            max-w-3xl
                            text-lg
                            leading-8
                            text-zinc-400
                        "
                    >
                        Vous pouvez simplement régler les 5 € correspondant
                        à votre séance.
                    </p>


                    <p
                        class="
                            mt-4
                            max-w-3xl
                            leading-8
                            text-zinc-500
                        "
                    >
                        Si vous remettez un billet de 10 € pour une seule séance,
                        5 € sont encaissés et 5 € vous sont rendus.
                    </p>

                </div>

            </div>


            <!-- =================================================
                 OPTION 2
                 ================================================= -->
            <div
                class="
                    grid
                    border-y
                    border-zinc-800
                    py-12
                    lg:grid-cols-[0.4fr_1.6fr]
                    lg:gap-20
                    lg:py-16
                "
            >

                <div>

                    <p
                        class="
                            text-5xl
                            font-black
                            text-red-600
                        "
                    >
                        02
                    </p>

                </div>


                <div class="mt-6 lg:mt-0">

                    <h3
                        class="
                            text-3xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        Créditer plusieurs séances à l'avance
                    </h3>


                    <p
                        class="
                            mt-5
                            max-w-3xl
                            text-lg
                            leading-8
                            text-zinc-400
                        "
                    >
                        Vous pouvez également verser plusieurs séances
                        à l'avance selon vos besoins.
                    </p>


                    <div
                        class="
                            mt-8
                            flex
                            flex-wrap
                            gap-x-10
                            gap-y-5
                        "
                    >

                        <p class="font-bold text-zinc-300">
                            10 € <span class="text-red-500">→</span> 2 séances
                        </p>

                        <p class="font-bold text-zinc-300">
                            20 € <span class="text-red-500">→</span> 4 séances
                        </p>

                        <p class="font-bold text-zinc-300">
                            30 € <span class="text-red-500">→</span> 6 séances
                        </p>

                        <p class="font-bold text-zinc-300">
                            50 € <span class="text-red-500">→</span> 10 séances
                        </p>

                    </div>


                    <p
                        class="
                            mt-8
                            max-w-3xl
                            font-semibold
                            leading-8
                            text-white
                        "
                    >
                        Les séances non utilisées restent disponibles pendant
                        <span class="text-red-500">1 an.</span>
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         EXEMPLE CONCRET
         ========================================================= -->
    <section
        class="
            border-b
            border-zinc-900
            bg-zinc-950
            px-6
            py-20
            lg:px-8
            lg:py-24
        "
    >

        <div
            class="
                mx-auto
                grid
                max-w-7xl
                gap-12
                lg:grid-cols-[0.6fr_1.4fr]
                lg:items-center
                lg:gap-24
            "
        >


            <!-- Titre -->
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
                    Exemple
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
                    Vous créditez 20 €
                </h2>

            </div>


            <!-- Explication -->
            <div>

                <div class="border-l-4 border-red-600 pl-8">

                    <p
                        class="
                            text-2xl
                            font-black
                            text-white
                        "
                    >
                        20 € = 4 séances
                    </p>


                    <p
                        class="
                            mt-5
                            text-lg
                            leading-8
                            text-zinc-400
                        "
                    >
                        Après avoir participé à 2 séances,
                        il vous reste 2 séances disponibles.
                    </p>


                    <p
                        class="
                            mt-4
                            leading-8
                            text-zinc-500
                        "
                    >
                        Vous pourrez les utiliser lors de vos prochaines
                        participations, dans la limite de la période
                        de validité prévue.
                    </p>

                </div>

            </div>

        </div>

    </section>


@endsection