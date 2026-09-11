@extends('layouts.app')


@section('title', 'Inscription - Brussels Top Team')


@section(
    'meta_description',
    'Créez votre compte adhérent Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         PAGE D'INSCRIPTION
         ========================================================= -->
    <section class="relative overflow-hidden bg-zinc-950 px-6 py-16 lg:px-8 lg:py-24">


        <!-- =====================================================
             DÉCORATION DE FOND
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
                    Rejoindre Brussels Top Team
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
                    Créer mon compte
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
                    Créez votre espace adhérent afin d'accéder progressivement
                    aux services réservés aux membres Brussels Top Team.
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
                        Votre espace adhérent
                    </p>


                    <h2 class="mt-4 text-2xl font-black uppercase text-white">
                        Plus qu'un simple compte
                    </h2>


                    <p class="mt-5 leading-7 text-zinc-400">
                        Votre compte personnel vous permettra d'accéder
                        progressivement aux fonctionnalités réservées
                        aux adhérents Brussels Top Team.
                    </p>


                    <!-- =============================================
                         AVANTAGES DU COMPTE
                         ============================================= -->
                    <div class="mt-8 space-y-5">

                        <div class="flex gap-4">

                            <div
                                class="
                                    flex h-10 w-10 shrink-0
                                    items-center justify-center
                                    rounded-full bg-red-600/10
                                    text-red-500
                                "
                            >
                                ✓
                            </div>

                            <div>

                                <p class="font-bold text-white">
                                    Calendrier des entraînements
                                </p>

                                <p class="mt-1 text-sm leading-6 text-zinc-500">
                                    Consultez les séances correspondant
                                    à votre catégorie.
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-4">

                            <div
                                class="
                                    flex h-10 w-10 shrink-0
                                    items-center justify-center
                                    rounded-full bg-red-600/10
                                    text-red-500
                                "
                            >
                                ✓
                            </div>

                            <div>

                                <p class="font-bold text-white">
                                    Profil personnel
                                </p>

                                <p class="mt-1 text-sm leading-6 text-zinc-500">
                                    Gérez vos informations depuis votre
                                    espace adhérent.
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-4">

                            <div
                                class="
                                    flex h-10 w-10 shrink-0
                                    items-center justify-center
                                    rounded-full bg-red-600/10
                                    text-red-500
                                "
                            >
                                ✓
                            </div>

                            <div>

                                <p class="font-bold text-white">
                                    Identité publique
                                </p>

                                <p class="mt-1 text-sm leading-6 text-zinc-500">
                                    Votre pseudo représentera votre compte
                                    sur les espaces publics du site.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     FORMULAIRE
                     ================================================= -->
                <div class="p-8 lg:p-10">

                    <form
                        action="{{ route('register.store') }}"
                        method="POST"
                        class="space-y-6"
                    >

                        @csrf


                        <!-- =========================================
                             NOM + PRÉNOM
                             ========================================= -->
                        <div class="grid gap-6 sm:grid-cols-2">


                            <!-- NOM -->
                            <div>

                                <label
                                    for="nom"
                                    class="mb-2 block text-sm font-bold text-white"
                                >
                                    Nom
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="nom"
                                    name="nom"
                                    type="text"
                                    value="{{ old('nom') }}"
                                    autocomplete="family-name"
                                    required
                                    placeholder="Votre nom"
                                    class="
                                        w-full rounded-lg border bg-black
                                        px-4 py-3.5 text-white outline-none
                                        transition placeholder:text-zinc-600
                                        focus:ring-2 focus:ring-red-600/20

                                        @error('nom')
                                            border-red-600
                                        @else
                                            border-zinc-700
                                        @enderror

                                        focus:border-red-600
                                    "
                                >

                                @error('nom')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <!-- PRÉNOM -->
                            <div>

                                <label
                                    for="prenom"
                                    class="mb-2 block text-sm font-bold text-white"
                                >
                                    Prénom
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="prenom"
                                    name="prenom"
                                    type="text"
                                    value="{{ old('prenom') }}"
                                    autocomplete="given-name"
                                    required
                                    placeholder="Votre prénom"
                                    class="
                                        w-full rounded-lg border bg-black
                                        px-4 py-3.5 text-white outline-none
                                        transition placeholder:text-zinc-600
                                        focus:ring-2 focus:ring-red-600/20

                                        @error('prenom')
                                            border-red-600
                                        @else
                                            border-zinc-700
                                        @enderror

                                        focus:border-red-600
                                    "
                                >

                                @error('prenom')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        <!-- =========================================
                             PSEUDO
                             ========================================= -->
                        <div>

                            <label
                                for="pseudo"
                                class="mb-2 block text-sm font-bold text-white"
                            >
                                Pseudo
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="pseudo"
                                name="pseudo"
                                type="text"
                                value="{{ old('pseudo') }}"
                                autocomplete="username"
                                required
                                maxlength="50"
                                placeholder="Votre pseudo"
                                class="
                                    w-full rounded-lg border bg-black
                                    px-4 py-3.5 text-white outline-none
                                    transition placeholder:text-zinc-600
                                    focus:ring-2 focus:ring-red-600/20

                                    @error('pseudo')
                                        border-red-600
                                    @else
                                        border-zinc-700
                                    @enderror

                                    focus:border-red-600
                                "
                            >

                            @error('pseudo')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="mt-2 text-xs leading-5 text-zinc-500">
                                Votre pseudo est votre nom public sur Brussels Top Team.
                                Il doit être unique.
                            </p>

                        </div>


                        <!-- =========================================
                             GENRE
                             ========================================= -->
                        <div>

                            <label
                                for="genre"
                                class="mb-2 block text-sm font-bold text-white"
                            >
                                Genre
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="genre"
                                name="genre"
                                required
                                class="
                                    w-full rounded-lg border bg-black
                                    px-4 py-3.5 text-white outline-none
                                    transition focus:ring-2 focus:ring-red-600/20

                                    @error('genre')
                                        border-red-600
                                    @else
                                        border-zinc-700
                                    @enderror

                                    focus:border-red-600
                                "
                            >

                                <option value="">
                                    Sélectionnez votre genre
                                </option>

                                <option
                                    value="homme"
                                    @selected(old('genre') === 'homme')
                                >
                                    Homme
                                </option>

                                <option
                                    value="femme"
                                    @selected(old('genre') === 'femme')
                                >
                                    Femme
                                </option>

                            </select>

                            @error('genre')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


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
                                    w-full rounded-lg border bg-black
                                    px-4 py-3.5 text-white outline-none
                                    transition placeholder:text-zinc-600
                                    focus:ring-2 focus:ring-red-600/20

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
                                autocomplete="new-password"
                                required
                                placeholder="Votre mot de passe"
                                class="
                                    w-full rounded-lg border bg-black
                                    px-4 py-3.5 text-white outline-none
                                    transition placeholder:text-zinc-600
                                    focus:ring-2 focus:ring-red-600/20

                                    @error('password')
                                        border-red-600
                                    @else
                                        border-zinc-700
                                    @enderror

                                    focus:border-red-600
                                "
                            >

                            @error('password')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="mt-2 text-xs leading-5 text-zinc-500">
                                Minimum 8 caractères.
                            </p>

                        </div>


                        <!-- =========================================
                             CONFIRMATION DU MOT DE PASSE
                             ========================================= -->
                        <div>

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-bold text-white"
                            >
                                Confirmer le mot de passe
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                                placeholder="Répétez votre mot de passe"
                                class="
                                    w-full rounded-lg border bg-black
                                    px-4 py-3.5 text-white outline-none
                                    transition placeholder:text-zinc-600
                                    focus:border-red-600
                                    focus:ring-2 focus:ring-red-600/20

                                    @error('password')
                                        border-red-600
                                    @else
                                        border-zinc-700
                                    @enderror
                                "
                            >

                        </div>


                        <!-- =========================================
                             IDENTITÉ RÉELLE
                             ========================================= -->
                        <div
                            class="
                                rounded-xl
                                border
                                border-zinc-800
                                bg-black/60
                                p-4
                            "
                        >

                            <p class="text-sm leading-6 text-zinc-400">
                                Votre nom et votre prénom correspondent
                                à votre identité réelle et permettent à
                                Brussels Top Team d'identifier votre dossier.
                                Votre pseudo correspond à votre identité
                                publique sur la plateforme.
                            </p>

                        </div>


                        <!-- =========================================
                             CRÉATION DU COMPTE
                             ========================================= -->
                        <button
                            type="submit"
                            class="
                                flex w-full items-center justify-center
                                rounded-lg bg-red-600 px-6 py-4
                                text-sm font-black uppercase tracking-wide
                                text-white transition
                                hover:bg-red-700
                                focus:outline-none
                                focus:ring-2
                                focus:ring-red-500
                                focus:ring-offset-2
                                focus:ring-offset-zinc-900
                            "
                        >
                            Créer mon compte
                        </button>


                        <!-- =========================================
                             CONNEXION
                             ========================================= -->
                        <p class="text-center text-sm text-zinc-500">

                            Vous avez déjà un compte ?

                            <a
                                href="{{ route('login') }}"
                                class="
                                    font-bold
                                    text-red-500
                                    transition
                                    hover:text-red-400
                                "
                            >
                                Se connecter
                            </a>

                        </p>

                    </form>

                </div>

            </div>

        </div>

    </section>

@endsection