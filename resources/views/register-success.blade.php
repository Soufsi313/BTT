@extends('layouts.app')


@section('title', 'Inscription réussie - Brussels Top Team')


@section(
    'meta_description',
    'Votre compte Brussels Top Team a été créé avec succès.'
)


@section('content')

    <!-- =========================================================
         CONFIRMATION D'INSCRIPTION
         ========================================================= -->
    <section
        class="
            flex
            min-h-[70vh]
            items-center
            bg-zinc-950
            px-6
            py-20
            lg:px-8
        "
    >

        <div class="mx-auto w-full max-w-3xl text-center">


            <!-- =================================================
                 ICÔNE DE CONFIRMATION
                 ================================================= -->
            <div
                class="
                    mx-auto
                    flex
                    h-20
                    w-20
                    items-center
                    justify-center
                    rounded-full
                    border
                    border-red-600/30
                    bg-red-600/10
                    text-3xl
                    font-black
                    text-red-500
                "
            >
                ✓
            </div>


            <!-- =================================================
                 MESSAGE
                 ================================================= -->
            <p
                class="
                    mt-8
                    text-xs
                    font-black
                    uppercase
                    tracking-[0.35em]
                    text-red-500
                "
            >
                Bienvenue chez BTT
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
                "
            >
                Compte créé avec succès
            </h1>


            <p
                class="
                    mx-auto
                    mt-6
                    max-w-2xl
                    text-lg
                    leading-8
                    text-zinc-400
                "
            >
                Bienvenue
                <span class="font-bold text-white">
                    {{ auth()->user()->prenom }}
                    {{ auth()->user()->nom }}
                </span>.
                Votre compte adhérent Brussels Top Team est maintenant créé.
            </p>


            <p
                class="
                    mx-auto
                    mt-4
                    max-w-2xl
                    leading-7
                    text-zinc-500
                "
            >
                Votre espace personnel sera progressivement enrichi
                avec le calendrier des entraînements, votre profil
                et les services réservés aux adhérents.
            </p>


            <!-- =================================================
                 RETOUR À L'ACCUEIL
                 ================================================= -->
            <div class="mt-10">

                <a
                    href="{{ url('/') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-lg
                        bg-red-600
                        px-7
                        py-4
                        text-sm
                        font-black
                        uppercase
                        tracking-wide
                        text-white
                        transition
                        hover:bg-red-700
                    "
                >
                    Retour à l'accueil
                </a>

            </div>

        </div>

    </section>

@endsection