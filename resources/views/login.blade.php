@extends('layouts.app')


@section('title', 'Connexion - Brussels Top Team')


@section(
    'meta_description',
    'Connectez-vous à votre espace adhérent Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         PAGE DE CONNEXION
         ========================================================= -->
    <section class="relative overflow-hidden bg-zinc-950 px-6 py-16 lg:px-8 lg:py-24">


        <!-- =====================================================
             ÉLÉMENTS DÉCORATIFS
             ===================================================== -->
        <div
            class="
                pointer-events-none
                absolute
                -left-40
                top-20
                h-96
                w-96
                rounded-full
                bg-red-600/10
                blur-3xl
            "
        ></div>

        <div
            class="
                pointer-events-none
                absolute
                -right-40
                bottom-20
                h-96
                w-96
                rounded-full
                bg-red-600/10
                blur-3xl
            "
        ></div>


        <!-- =====================================================
             CONTENEUR PRINCIPAL
             ===================================================== -->
        <div class="relative mx-auto max-w-6xl">


            <!-- =================================================
                 EN-TÊTE
                 ================================================= -->
            <div class="mx-auto max-w-3xl text-center">

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
                        mt-5
                        text-4xl
                        font-black
                        uppercase
                        tracking-tight
                        text-white
                        sm:text-5xl
                        lg:text-6xl
                    "
                >
                    Connexion
                </h1>


                <p
                    class="
                        mx-auto
                        mt-6
                        max-w-2xl
                        text-base
                        leading-7
                        text-zinc-400
                        sm:text-lg
                    "
                >
                    Connectez-vous à votre compte Brussels Top Team.
                </p>

            </div>


            <!-- =================================================
                 ZONE PRINCIPALE
                 ================================================= -->
            <div
                class="
                    mx-auto
                    mt-14
                    grid
                    max-w-5xl
                    overflow-hidden
                    rounded-3xl
                    border
                    border-zinc-800
                    bg-zinc-900/70
                    shadow-2xl
                    shadow-black/30
                    lg:grid-cols-[0.75fr_1.25fr]
                "
            >


                <!-- =================================================
                     COLONNE INFORMATIVE
                     ================================================= -->
                <div
                    class="
                        border-b
                        border-zinc-800
                        bg-black
                        p-8
                        lg:border-b-0
                        lg:border-r
                        lg:p-10
                    "
                >

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.3em]
                            text-red-500
                        "
                    >
                        Brussels Top Team
                    </p>


                    <h2
                        class="
                            mt-4
                            text-2xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        Retrouvez votre espace
                    </h2>


                    <p class="mt-5 leading-7 text-zinc-400">
                        Accédez à votre profil et, progressivement,
                        aux services réservés aux adhérents BTT.
                    </p>


                    <div class="mt-8 space-y-5">

                        <div class="flex gap-4">

                            <div
                                class="
                                    flex
                                    h-10
                                    w-10
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-red-600/10
                                    text-red-500
                                "
                            >
                                ✓
                            </div>

                            <div>

                                <p class="font-bold text-white">
                                    Votre profil
                                </p>

                                <p class="mt-1 text-sm leading-6 text-zinc-500">
                                    Retrouvez vos informations personnelles.
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-4">

                            <div
                                class="
                                    flex
                                    h-10
                                    w-10
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-red-600/10
                                    text-red-500
                                "
                            >
                                ✓
                            </div>

                            <div>

                                <p class="font-bold text-white">
                                    Calendrier adhérent
                                </p>

                                <p class="mt-1 text-sm leading-6 text-zinc-500">
                                    Les entraînements seront accessibles
                                    depuis votre espace.
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-4">

                            <div
                                class="
                                    flex
                                    h-10
                                    w-10
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-red-600/10
                                    text-red-500
                                "
                            >
                                ✓
                            </div>

                            <div>

                                <p class="font-bold text-white">
                                    Messagerie BTT
                                </p>

                                <p class="mt-1 text-sm leading-6 text-zinc-500">
                                    Vous pourrez prochainement contacter
                                    l'administration depuis votre compte.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     FORMULAIRE DE CONNEXION
                     ================================================= -->
                <div class="p-8 lg:p-10">


                    <!-- =============================================
                         MESSAGE D'ERREUR GLOBAL
                         ============================================= -->
                    @if ($errors->any())

                        <div
                            class="
                                mb-6
                                rounded-xl
                                border
                                border-red-600/50
                                bg-red-600/10
                                p-4
                            "
                        >

                            <p class="font-bold text-red-500">
                                Connexion impossible
                            </p>

                            <p class="mt-1 text-sm leading-6 text-red-300">
                                {{ $errors->first() }}
                            </p>

                        </div>

                    @endif


                    <form
                        action="{{ route('login.store') }}"
                        method="POST"
                        class="space-y-6"
                    >

                        @csrf


                        <!-- =========================================
                             EMAIL
                             ========================================= -->
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-bold text-white"
                            >
                                Adresse email
                                <span class="text-red-500">*</span>
                            </label>


                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                placeholder="exemple@email.com"
                                class="
                                    w-full
                                    rounded-lg
                                    border
                                    bg-black
                                    px-4
                                    py-3.5
                                    text-white
                                    outline-none
                                    transition
                                    placeholder:text-zinc-600
                                    focus:ring-2
                                    focus:ring-red-600/20

                                    @error('email')
                                        border-red-600
                                    @else
                                        border-zinc-700
                                    @enderror

                                    focus:border-red-600
                                "
                            >


                            @error('email')

                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <!-- =========================================
                             MOT DE PASSE
                             ========================================= -->
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-bold text-white"
                            >
                                Mot de passe
                                <span class="text-red-500">*</span>
                            </label>


                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="Votre mot de passe"
                                class="
                                    w-full
                                    rounded-lg
                                    border
                                    border-zinc-700
                                    bg-black
                                    px-4
                                    py-3.5
                                    text-white
                                    outline-none
                                    transition
                                    placeholder:text-zinc-600
                                    focus:border-red-600
                                    focus:ring-2
                                    focus:ring-red-600/20
                                "
                            >

                        </div>


                        <!-- =========================================
                             SE SOUVENIR DE MOI
                             ========================================= -->
                        <div class="flex items-center justify-between gap-4">

                            <label class="flex items-center gap-3">

                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    @checked(old('remember'))
                                    class="
                                        h-4
                                        w-4
                                        rounded
                                        border-zinc-700
                                        bg-black
                                        text-red-600
                                        focus:ring-red-600
                                    "
                                >

                                <span class="text-sm text-zinc-400">
                                    Se souvenir de moi
                                </span>

                            </label>


                            <span class="text-xs text-zinc-600">
                                Mot de passe oublié : prochainement
                            </span>

                        </div>


                        <!-- =========================================
                             BOUTON CONNEXION
                             ========================================= -->
                        <button
                            type="submit"
                            class="
                                flex
                                w-full
                                items-center
                                justify-center
                                rounded-lg
                                bg-red-600
                                px-6
                                py-4
                                text-sm
                                font-black
                                uppercase
                                tracking-wide
                                text-white
                                transition
                                hover:bg-red-700
                                focus:outline-none
                                focus:ring-2
                                focus:ring-red-500
                                focus:ring-offset-2
                                focus:ring-offset-zinc-900
                            "
                        >
                            Se connecter
                        </button>


                        <!-- =========================================
                             INSCRIPTION
                             ========================================= -->
                        <p class="text-center text-sm text-zinc-500">

                            Vous n'avez pas encore de compte ?

                            <a
                                href="{{ route('register') }}"
                                class="
                                    font-bold
                                    text-red-500
                                    transition
                                    hover:text-red-400
                                "
                            >
                                Créer un compte
                            </a>

                        </p>

                    </form>

                </div>

            </div>

        </div>

    </section>

@endsection