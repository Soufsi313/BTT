@extends('layouts.app')


@section('title', 'Supprimer mon compte - Brussels Top Team')


@section(
    'meta_description',
    'Désactiver votre compte adhérent Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         SUPPRESSION DU COMPTE
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
                    Zone sensible
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
                    Supprimer mon compte
                </h1>


                <p class="mt-5 max-w-2xl leading-7 text-zinc-400">
                    Cette action désactivera immédiatement votre compte
                    Brussels Top Team et vous déconnectera du site.
                </p>

            </div>


            <!-- =================================================
                 AVERTISSEMENT
                 ================================================= -->
            <div
                class="
                    mt-10
                    rounded-2xl
                    border
                    border-red-600/40
                    bg-red-600/10
                    p-6
                    sm:p-8
                "
            >

                <h2 class="text-xl font-black uppercase text-red-500">
                    Attention
                </h2>


                <div class="mt-5 space-y-3 text-sm leading-6 text-zinc-300">

                    <p>
                        Après confirmation, vous serez immédiatement
                        déconnecté et votre compte ne pourra plus être utilisé
                        pour vous connecter.
                    </p>

                    <p>
                        Si vous souhaitez ensuite récupérer votre compte,
                        vous devrez contacter l'administration de Brussels
                        Top Team via la page Contact.
                    </p>

                    <p>
                        Cette étape désactive le compte dans notre système.
                        La gestion définitive des données personnelles sera
                        traitée séparément selon les obligations légales
                        applicables.
                    </p>

                </div>

            </div>


            <!-- =================================================
                 FORMULAIRE DE CONFIRMATION
                 ================================================= -->
            <div
                class="
                    mt-8
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                    sm:p-8
                "
            >

                <form
                    action="{{ route('member.delete-account.destroy') }}"
                    method="POST"
                    class="space-y-7"
                >

                    @csrf
                    @method('DELETE')


                    <!-- =========================================
                         MOT DE PASSE ACTUEL
                         ========================================= -->
                    <div>

                        <label
                            for="current_password"
                            class="mb-2 block text-sm font-bold text-white"
                        >
                            Confirmez votre mot de passe actuel
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
                         VALIDATION FINALE
                         ========================================= -->
                    <div
                        class="
                            flex
                            flex-col
                            gap-4
                            border-t
                            border-zinc-800
                            pt-7
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <a
                            href="{{ route('member.profile') }}"
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
                                hover:border-zinc-500
                            "
                        >
                            Annuler
                        </a>


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
                            Supprimer mon compte
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection