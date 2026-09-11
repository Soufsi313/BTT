@extends('layouts.app')


@section('title', 'Compte désactivé - Brussels Top Team')


@section(
    'meta_description',
    'Votre compte Brussels Top Team a été désactivé.'
)


@section('content')

    <!-- =========================================================
         CONFIRMATION DE SUPPRESSION
         ========================================================= -->
    <section
        class="
            flex
            min-h-[70vh]
            items-center
            bg-zinc-950
            px-6
            py-16
            lg:px-8
        "
    >

        <div class="mx-auto w-full max-w-3xl text-center">


            <!-- =================================================
                 ICÔNE
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
                    border-red-600/40
                    bg-red-600/10
                "
            >

                <svg
                    class="h-9 w-9 text-red-500"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>

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
                Compte désactivé
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
                Votre compte a été supprimé
            </h1>


            <p
                class="
                    mx-auto
                    mt-6
                    max-w-2xl
                    leading-7
                    text-zinc-400
                "
            >
                Votre compte Brussels Top Team a été désactivé et votre
                session a été fermée.
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
                Si vous souhaitez demander une restauration de votre compte,
                contactez l'administration via notre formulaire de contact.
            </p>


            <!-- =================================================
                 ACTIONS
                 ================================================= -->
            <div
                class="
                    mt-10
                    flex
                    flex-col
                    justify-center
                    gap-4
                    sm:flex-row
                "
            >

                <a
                    href="{{ url('/') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-lg
                        bg-red-600
                        px-6
                        py-3.5
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


                <a
                    href="{{ route('contact') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-lg
                        border
                        border-zinc-700
                        px-6
                        py-3.5
                        text-sm
                        font-black
                        uppercase
                        tracking-wide
                        text-white
                        transition
                        hover:border-red-600
                        hover:text-red-500
                    "
                >
                    Contacter BTT
                </a>

            </div>

        </div>

    </section>

@endsection