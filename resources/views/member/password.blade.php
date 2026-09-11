@extends('layouts.app')


@section('title', 'Modifier mon mot de passe - Brussels Top Team')


@section(
    'meta_description',
    'Modifier le mot de passe de votre compte Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         MODIFICATION DU MOT DE PASSE
         ========================================================= -->
    <section class="min-h-[70vh] bg-zinc-950 px-6 py-16 lg:px-8 lg:py-20">

        <div class="mx-auto max-w-3xl">


            <!-- =================================================
                 RETOUR AU PROFIL
                 ================================================= -->
            <a
                href="{{ route('member.profile') }}"
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
                ← Retour à mon profil
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
                    Sécurité du compte
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
                    Modifier mon mot de passe
                </h1>


                <p class="mt-5 max-w-2xl leading-7 text-zinc-400">
                    Pour protéger votre compte, confirmez votre mot de passe
                    actuel avant d'en choisir un nouveau.
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
                    action="{{ route('member.password.update') }}"
                    method="POST"
                    class="space-y-7"
                >

                    @csrf
                    @method('PUT')


                    <!-- =========================================
                         MOT DE PASSE ACTUEL
                         ========================================= -->
                    <div>

                        <label
                            for="current_password"
                            class="mb-2 block text-sm font-bold text-white"
                        >
                            Mot de passe actuel
                            <span class="text-red-500">*</span>
                        </label>


                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            required
                            autocomplete="current-password"
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

                                @error('current_password')
                                    border-red-600
                                @else
                                    border-zinc-700
                                @enderror
                            "
                        >


                        @error('current_password')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- =========================================
                         NOUVEAU MOT DE PASSE
                         ========================================= -->
                    <div>

                        <label
                            for="password"
                            class="mb-2 block text-sm font-bold text-white"
                        >
                            Nouveau mot de passe
                            <span class="text-red-500">*</span>
                        </label>


                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
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

                                @error('password')
                                    border-red-600
                                @else
                                    border-zinc-700
                                @enderror
                            "
                        >


                        <p class="mt-2 text-sm leading-6 text-zinc-500">
                            Le nouveau mot de passe doit contenir au minimum
                            8 caractères et être différent de votre mot de
                            passe actuel.
                        </p>


                        @error('password')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- =========================================
                         CONFIRMATION DU NOUVEAU MOT DE PASSE
                         ========================================= -->
                    <div>

                        <label
                            for="password_confirmation"
                            class="mb-2 block text-sm font-bold text-white"
                        >
                            Confirmer le nouveau mot de passe
                            <span class="text-red-500">*</span>
                        </label>


                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
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
                                focus:border-red-600
                                focus:ring-2
                                focus:ring-red-600/20
                            "
                        >

                    </div>


                    <!-- =========================================
                         INFORMATION DE SÉCURITÉ
                         ========================================= -->
                    <div
                        class="
                            rounded-xl
                            border
                            border-zinc-800
                            bg-black/40
                            p-5
                        "
                    >

                        <p class="text-sm leading-6 text-zinc-400">
                            Votre mot de passe n'est jamais enregistré en clair.
                            Il est automatiquement protégé avant son
                            enregistrement dans la base de données.
                        </p>

                    </div>


                    <!-- =========================================
                         VALIDATION
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
                            Modifier mon mot de passe
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection