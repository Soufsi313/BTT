@extends('layouts.app')


@section('title', 'Mon profil - Brussels Top Team')


@section(
    'meta_description',
    'Modifier les informations de votre profil Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         PAGE PROFIL ADHÉRENT
         ========================================================= -->
    <section class="min-h-[70vh] bg-zinc-950 px-6 py-16 lg:px-8 lg:py-20">

        <div class="mx-auto max-w-4xl">


            <!-- =================================================
                 RETOUR À L'ESPACE ADHÉRENT
                 ================================================= -->
            <a
                href="{{ route('member.dashboard') }}"
                class="
                    inline-flex
                    items-center
                    gap-2
                    text-sm
                    font-bold
                    text-zinc-400
                    transition
                    hover:text-red-500
                "
            >
                ← Retour à mon espace
            </a>


            <!-- =================================================
                 EN-TÊTE
                 ================================================= -->
            <div class="mt-8">

                <p
                    class="
                        text-xs
                        font-black
                        uppercase
                        tracking-[0.35em]
                        text-red-500
                    "
                >
                    Mon compte
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
                    Mon profil
                </h1>


                <p class="mt-5 max-w-2xl leading-7 text-zinc-400">
                    Modifiez vos informations personnelles et votre identité
                    publique sur Brussels Top Team.
                </p>

            </div>


            <!-- =================================================
                 MESSAGE DE SUCCÈS
                 ================================================= -->
            @if (session('success'))

                <div
                    class="
                        mt-10
                        rounded-xl
                        border
                        border-green-600/40
                        bg-green-600/10
                        px-5
                        py-4
                        text-sm
                        font-bold
                        text-green-400
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            <!-- =================================================
                 FORMULAIRE
                 ================================================= -->
            <div
                class="
                    mt-10
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                    sm:p-8
                "
            >

                <form
                    action="{{ route('member.profile.update') }}"
                    method="POST"
                    class="space-y-7"
                >

                    @csrf
                    @method('PUT')


                    <!-- =========================================
                         NOM
                         ========================================= -->
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
                            value="{{ old('nom', auth()->user()->nom) }}"
                            required
                            maxlength="100"
                            autocomplete="family-name"
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
                                focus:border-red-600
                                focus:ring-2
                                focus:ring-red-600/20

                                @error('nom')
                                    border-red-600
                                @else
                                    border-zinc-700
                                @enderror
                            "
                        >


                        @error('nom')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- =========================================
                         PRÉNOM
                         ========================================= -->
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
                            value="{{ old('prenom', auth()->user()->prenom) }}"
                            required
                            maxlength="100"
                            autocomplete="given-name"
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
                                focus:border-red-600
                                focus:ring-2
                                focus:ring-red-600/20

                                @error('prenom')
                                    border-red-600
                                @else
                                    border-zinc-700
                                @enderror
                            "
                        >


                        @error('prenom')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

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
                            value="{{ old('pseudo', auth()->user()->pseudo) }}"
                            required
                            maxlength="50"
                            autocomplete="username"
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
                                focus:border-red-600
                                focus:ring-2
                                focus:ring-red-600/20

                                @error('pseudo')
                                    border-red-600
                                @else
                                    border-zinc-700
                                @enderror
                            "
                        >


                        <p class="mt-2 text-sm leading-6 text-zinc-500">
                            Votre pseudo est votre identité publique sur
                            Brussels Top Team.
                        </p>


                        @error('pseudo')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- =========================================
                         GENRE / CATÉGORIE
                         ========================================= -->
                    <div>

                        <label
                            for="genre"
                            class="mb-2 block text-sm font-bold text-white"
                        >
                            Catégorie
                            <span class="text-red-500">*</span>
                        </label>


                        <select
                            id="genre"
                            name="genre"
                            required
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
                                focus:border-red-600
                                focus:ring-2
                                focus:ring-red-600/20

                                @error('genre')
                                    border-red-600
                                @else
                                    border-zinc-700
                                @enderror
                            "
                        >

                            <option
                                value="homme"
                                @selected(
                                    old(
                                        'genre',
                                        auth()->user()->genre
                                    ) === 'homme'
                                )
                            >
                                Homme
                            </option>

                            <option
                                value="femme"
                                @selected(
                                    old(
                                        'genre',
                                        auth()->user()->genre
                                    ) === 'femme'
                                )
                            >
                                Femme
                            </option>

                        </select>


                        <p class="mt-2 text-sm leading-6 text-zinc-500">
                            Cette catégorie servira notamment à afficher
                            les entraînements correspondant à votre profil.
                        </p>


                        @error('genre')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- =========================================
                         EMAIL
                         ========================================= -->
                    <div
                        class="
                            rounded-xl
                            border
                            border-zinc-800
                            bg-black/40
                            px-5
                            py-4
                        "
                    >

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-500
                            "
                        >
                            Adresse email
                        </p>


                        <p class="mt-2 font-bold text-white">
                            {{ auth()->user()->email }}
                        </p>


                        <p class="mt-2 text-sm leading-6 text-zinc-500">
                            La modification de l'adresse email sera gérée
                            séparément pour des raisons de sécurité.
                        </p>

                    </div>


                    <!-- =========================================
                         BOUTON
                         ========================================= -->
                    <div class="flex justify-end border-t border-zinc-800 pt-7">

                        <button
                            type="submit"
                            class="
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
                            Enregistrer les modifications
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection