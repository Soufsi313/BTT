@extends('layouts.app')


@section('title', 'Mon espace - Brussels Top Team')


@section(
    'meta_description',
    'Espace personnel adhérent Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         ESPACE ADHÉRENT
         ========================================================= -->
    <section class="min-h-[70vh] bg-zinc-950 px-6 py-16 lg:px-8 lg:py-20">

        <div class="mx-auto max-w-7xl">


            <!-- =================================================
                 EN-TÊTE DE L'ESPACE ADHÉRENT
                 ================================================= -->
            <div class="border-b border-zinc-800 pb-10">

                <p
                    class="
                        text-xs
                        font-black
                        uppercase
                        tracking-[0.35em]
                        text-red-500
                    "
                >
                    Espace adhérent
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
                    Bonjour {{ auth()->user()->pseudo }}
                </h1>


                <p
                    class="
                        mt-5
                        max-w-2xl
                        text-base
                        leading-7
                        text-zinc-400
                    "
                >
                    Bienvenue dans votre espace personnel Brussels Top Team.
                    Vous retrouverez ici les services réservés aux adhérents.
                </p>

            </div>


            <!-- =================================================
                 INFORMATIONS DU COMPTE
                 ================================================= -->
            <div class="mt-12">

                <p
                    class="
                        text-xs
                        font-black
                        uppercase
                        tracking-[0.3em]
                        text-red-500
                    "
                >
                    Mon compte
                </p>


                <h2
                    class="
                        mt-3
                        text-2xl
                        font-black
                        uppercase
                        text-white
                    "
                >
                    Mes informations
                </h2>


                <div
                    class="
                        mt-6
                        grid
                        gap-px
                        overflow-hidden
                        rounded-xl
                        border
                        border-zinc-800
                        bg-zinc-800
                        sm:grid-cols-2
                        lg:grid-cols-4
                    "
                >

                    <div class="bg-zinc-900 p-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-500
                            "
                        >
                            Pseudo
                        </p>

                        <p class="mt-2 font-bold text-white">
                            {{ auth()->user()->pseudo }}
                        </p>

                    </div>


                    <div class="bg-zinc-900 p-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-500
                            "
                        >
                            Identité
                        </p>

                        <p class="mt-2 font-bold text-white">
                            {{ auth()->user()->prenom }}
                            {{ auth()->user()->nom }}
                        </p>

                    </div>


                    <div class="bg-zinc-900 p-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-500
                            "
                        >
                            Email
                        </p>

                        <p class="mt-2 break-all font-bold text-white">
                            {{ auth()->user()->email }}
                        </p>

                    </div>


                    <div class="bg-zinc-900 p-6">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-500
                            "
                        >
                            Catégorie
                        </p>

                        <p class="mt-2 font-bold text-white">

                            @if (auth()->user()->genre === 'homme')
                                Homme
                            @else
                                Femme
                            @endif

                        </p>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 SERVICES ADHÉRENTS
                 ================================================= -->
            <div class="mt-16">

                <p
                    class="
                        text-xs
                        font-black
                        uppercase
                        tracking-[0.3em]
                        text-red-500
                    "
                >
                    Services
                </p>


                <h2
                    class="
                        mt-3
                        text-2xl
                        font-black
                        uppercase
                        text-white
                    "
                >
                    Mon espace BTT
                </h2>


                <div class="mt-8 divide-y divide-zinc-800 border-y border-zinc-800">


                    <!-- =========================================
                         CALENDRIER
                         ========================================= -->
                    <div
                        class="
                            flex
                            flex-col
                            gap-4
                            py-7
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <div>

                            <h3 class="text-lg font-black uppercase text-white">
                                Calendrier des entraînements
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-zinc-500">
                                Consultez prochainement les entraînements
                                correspondant à votre catégorie.
                            </p>

                        </div>


                        <span
                            class="
                                shrink-0
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Prochainement
                        </span>

                    </div>


                    <!-- =========================================
                         PROFIL
                         ========================================= -->
                    <div
                        class="
                            flex
                            flex-col
                            gap-4
                            py-7
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <div>

                            <h3 class="text-lg font-black uppercase text-white">
                                Mon profil
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-zinc-500">
                                Modifiez votre nom, votre prénom,
                                votre pseudo et votre catégorie.
                            </p>

                        </div>


                        <a
                            href="{{ route('member.profile') }}"
                            class="
                                inline-flex
                                shrink-0
                                items-center
                                justify-center
                                rounded-md
                                border
                                border-red-600/50
                                px-5
                                py-3
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-red-500
                                transition
                                hover:bg-red-600
                                hover:text-white
                            "
                        >
                            Modifier mon profil
                        </a>

                    </div>


                    <!-- =========================================
                         MESSAGERIE
                         ========================================= -->
                    <div
                        class="
                            flex
                            flex-col
                            gap-4
                            py-7
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <div>

                            <h3 class="text-lg font-black uppercase text-white">
                                Contacter l'administration
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-zinc-500">
                                Une messagerie directe avec l'administration
                                BTT sera disponible depuis votre espace.
                            </p>

                        </div>


                        <span
                            class="
                                shrink-0
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Prochainement
                        </span>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 DÉCONNEXION
                 ================================================= -->
            <div class="mt-14 flex justify-end">

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="
                            rounded-md
                            border
                            border-red-600/50
                            px-5
                            py-3
                            text-sm
                            font-black
                            uppercase
                            text-red-500
                            transition
                            hover:bg-red-600
                            hover:text-white
                        "
                    >
                        Déconnexion
                    </button>

                </form>

            </div>

        </div>

    </section>

@endsection