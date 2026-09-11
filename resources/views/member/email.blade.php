@extends('layouts.app')


@section('title', 'Modifier mon email - Brussels Top Team')


@section(
    'meta_description',
    'Modifier l’adresse email de votre compte Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         MODIFICATION DE L'ADRESSE EMAIL
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
                    Modifier mon email
                </h1>


                <p class="mt-5 max-w-2xl leading-7 text-zinc-400">
                    Pour des raisons de sécurité, votre mot de passe actuel
                    est nécessaire pour modifier votre adresse email.
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
                    action="{{ route('member.email.update') }}"
                    method="POST"
                    class="space-y-7"
                >

                    @csrf
                    @method('PUT')


                    <!-- =========================================
                         EMAIL ACTUEL
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
                            Adresse email actuelle
                        </p>

                        <p class="mt-2 break-all font-bold text-white">
                            {{ auth()->user()->email }}
                        </p>

                    </div>


                    <!-- =========================================
                         NOUVEL EMAIL
                         ========================================= -->
                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-bold text-white"
                        >
                            Nouvelle adresse email
                            <span class="text-red-500">*</span>
                        </label>


                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                            maxlength="255"
                            autocomplete="email"
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

                                @error('email')
                                    border-red-600
                                @else
                                    border-zinc-700
                                @enderror
                            "
                        >


                        @error('email')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


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


                        <p class="mt-2 text-sm leading-6 text-zinc-500">
                            Cette vérification permet d'empêcher une personne
                            utilisant une session ouverte de modifier votre
                            adresse email sans connaître votre mot de passe.
                        </p>


                        @error('current_password')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

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
                            Modifier mon email
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection