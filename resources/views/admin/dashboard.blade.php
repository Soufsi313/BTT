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


                <!-- =================================================
                     MENU RAPIDE DU PROFIL
                     =================================================
                     Ce menu utilise les balises HTML details/summary.
                     Aucun JavaScript supplémentaire n'est nécessaire.
                     ================================================= -->
                <details class="group relative mt-5 inline-block">

                    <!-- =============================================
                         BOUTON D'OUVERTURE DU MENU
                         ============================================= -->
                    <summary
                        class="
                            flex
                            cursor-pointer
                            list-none
                            items-center
                            gap-3
                            rounded-md
                            border
                            border-zinc-700
                            bg-zinc-900
                            px-5
                            py-3
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                            transition
                            hover:border-red-600
                            hover:text-red-500
                        "
                    >
                        <span>
                            Menu rapide
                        </span>

                        <span
                            class="
                                text-red-500
                                transition-transform
                                duration-200
                                group-open:rotate-180
                            "
                        >
                            ▼
                        </span>
                    </summary>


                    <!-- =============================================
                         CONTENU DU MENU
                         ============================================= -->
                    <div
                        class="
                            absolute
                            left-0
                            z-40
                            mt-2
                            w-72
                            overflow-hidden
                            rounded-lg
                            border
                            border-zinc-700
                            bg-zinc-900
                            shadow-2xl
                        "
                    >


                        <!-- =========================================
                             MON CALENDRIER
                             ========================================= -->
                        <a
                            href="{{ route('member.courses') }}"
                            class="
                                flex
                                items-center
                                justify-between
                                border-b
                                border-zinc-800
                                px-5
                                py-4
                                text-sm
                                font-bold
                                text-zinc-300
                                transition
                                hover:bg-zinc-800
                                hover:text-white
                            "
                        >
                            <span>
                                Mon calendrier
                            </span>

                            <span class="text-red-500">
                                →
                            </span>
                        </a>


                        <!-- =========================================
                             MODIFIER LE PROFIL
                             ========================================= -->
                        <a
                            href="{{ route('member.profile') }}"
                            class="
                                flex
                                items-center
                                justify-between
                                border-b
                                border-zinc-800
                                px-5
                                py-4
                                text-sm
                                font-bold
                                text-zinc-300
                                transition
                                hover:bg-zinc-800
                                hover:text-white
                            "
                        >
                            <span>
                                Modifier mon profil
                            </span>

                            <span class="text-red-500">
                                →
                            </span>
                        </a>


                        <!-- =========================================
                             MODIFIER L'EMAIL
                             ========================================= -->
                        <a
                            href="{{ route('member.email') }}"
                            class="
                                flex
                                items-center
                                justify-between
                                border-b
                                border-zinc-800
                                px-5
                                py-4
                                text-sm
                                font-bold
                                text-zinc-300
                                transition
                                hover:bg-zinc-800
                                hover:text-white
                            "
                        >
                            <span>
                                Modifier mon email
                            </span>

                            <span class="text-red-500">
                                →
                            </span>
                        </a>


                        <!-- =========================================
                             MODIFIER LE MOT DE PASSE
                             ========================================= -->
                        <a
                            href="{{ route('member.password') }}"
                            class="
                                flex
                                items-center
                                justify-between
                                border-b
                                border-zinc-800
                                px-5
                                py-4
                                text-sm
                                font-bold
                                text-zinc-300
                                transition
                                hover:bg-zinc-800
                                hover:text-white
                            "
                        >
                            <span>
                                Modifier mon mot de passe
                            </span>

                            <span class="text-red-500">
                                →
                            </span>
                        </a>


                        <!-- =========================================
                             ADMINISTRATION
                             Visible uniquement pour Admin
                             et Super Admin.
                             ========================================= -->
                        @if (auth()->user()->canAccessAdmin())

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="
                                    flex
                                    items-center
                                    justify-between
                                    border-b
                                    border-zinc-800
                                    px-5
                                    py-4
                                    text-sm
                                    font-black
                                    text-red-500
                                    transition
                                    hover:bg-red-600
                                    hover:text-white
                                "
                            >
                                <span>
                                    Administration
                                </span>

                                <span>
                                    →
                                </span>
                            </a>

                        @endif


                        <!-- =========================================
                             DÉCONNEXION
                             ========================================= -->
                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="
                                    flex
                                    w-full
                                    items-center
                                    justify-between
                                    px-5
                                    py-4
                                    text-left
                                    text-sm
                                    font-black
                                    text-red-500
                                    transition
                                    hover:bg-red-600
                                    hover:text-white
                                "
                            >
                                <span>
                                    Déconnexion
                                </span>

                                <span>
                                    →
                                </span>
                            </button>

                        </form>

                    </div>

                </details>


                <p
                    class="
                        mt-6
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

                    <!-- =========================================
                         PSEUDO
                         ========================================= -->
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


                    <!-- =========================================
                         IDENTITÉ
                         ========================================= -->
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


                    <!-- =========================================
                         EMAIL
                         ========================================= -->
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


                    <!-- =========================================
                         CATÉGORIE
                         ========================================= -->
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
                                Consultez les entraînements correspondant
                                à votre catégorie dans votre calendrier privé.
                            </p>

                        </div>


                        <a
                            href="{{ route('member.courses') }}"
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
                            Voir mon calendrier
                        </a>

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
                 INFORMATION
                 =================================================
                 La déconnexion se trouve désormais dans le menu
                 rapide situé sous le pseudo.
                 ================================================= -->
            <div
                class="
                    mt-14
                    border-t
                    border-zinc-800
                    pt-8
                    text-sm
                    text-zinc-600
                "
            >
                Utilisez le menu rapide en haut de votre espace pour accéder
                à votre calendrier, gérer votre compte ou vous déconnecter.
            </div>

        </div>

    </section>

@endsection