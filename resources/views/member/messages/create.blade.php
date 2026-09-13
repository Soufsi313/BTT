@extends('layouts.app')


@section('title', 'Contacter l’administration - Brussels Top Team')


@section(
    'meta_description',
    'Envoyez un nouveau message à l’administration Brussels Top Team depuis votre espace adhérent.'
)


@section('content')

    <!-- =========================================================
         NOUVELLE CONVERSATION ADHÉRENT
         =========================================================
         Cette page permet à un adhérent connecté de démarrer
         directement une nouvelle conversation avec l'administration.

         Le nom et l'adresse email ne sont pas demandés :
         ils proviennent directement du compte connecté.
         ========================================================= -->
    <section
        class="
            min-h-[70vh]
            bg-zinc-950
            px-6
            py-16
            lg:px-8
            lg:py-20
        "
    >

        <div class="mx-auto max-w-4xl">


            <!-- =================================================
                 EN-TÊTE
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-6
                    border-b
                    border-zinc-800
                    pb-10
                    lg:flex-row
                    lg:items-end
                    lg:justify-between
                "
            >

                <div>

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.35em]
                            text-red-500
                        "
                    >
                        Messagerie
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
                        Contacter l'administration
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
                        Démarrez une nouvelle conversation privée avec
                        l'administration Brussels Top Team.
                    </p>

                </div>


                <!-- =============================================
                     RETOUR À LA MESSAGERIE
                     ============================================= -->
                <div>

                    <a
                        href="{{ route('member.messages.index') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            border
                            border-zinc-700
                            px-5
                            py-3
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-300
                            transition
                            hover:border-red-600
                            hover:text-red-500
                        "
                    >
                        ← Mes messages
                    </a>

                </div>

            </div>


            <!-- =================================================
                 ERREURS DE VALIDATION
                 ================================================= -->
            @if ($errors->any())

                <div
                    class="
                        mt-8
                        border-l-4
                        border-red-600
                        bg-red-600/10
                        px-6
                        py-5
                    "
                >

                    <p
                        class="
                            text-sm
                            font-black
                            uppercase
                            text-red-400
                        "
                    >
                        Vérifiez les informations saisies
                    </p>


                    <ul
                        class="
                            mt-3
                            space-y-2
                            text-sm
                            text-red-300
                        "
                    >

                        @foreach ($errors->all() as $error)

                            <li>
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- =================================================
                 IDENTITÉ DE L'ADHÉRENT
                 =================================================
                 Ces informations ne sont pas modifiables ici.

                 Elles proviennent du compte utilisateur connecté.
                 ================================================= -->
            <div
                class="
                    mt-10
                    grid
                    gap-px
                    overflow-hidden
                    rounded-lg
                    border
                    border-zinc-800
                    bg-zinc-800
                    sm:grid-cols-2
                "
            >

                <!-- =============================================
                     IDENTITÉ
                     ============================================= -->
                <div class="bg-zinc-900 p-6">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        Expéditeur
                    </p>


                    <p
                        class="
                            mt-2
                            font-black
                            text-white
                        "
                    >
                        {{ auth()->user()->prenom }}
                        {{ auth()->user()->nom }}
                    </p>

                </div>


                <!-- =============================================
                     EMAIL
                     ============================================= -->
                <div class="bg-zinc-900 p-6">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        Email
                    </p>


                    <p
                        class="
                            mt-2
                            break-all
                            font-black
                            text-white
                        "
                    >
                        {{ auth()->user()->email }}
                    </p>

                </div>

            </div>


            <!-- =================================================
                 FORMULAIRE
                 ================================================= -->
            <form
                action="{{ route('member.messages.store') }}"
                method="POST"
                class="
                    mt-10
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                    sm:p-8
                "
            >

                @csrf


                <!-- =============================================
                     SUJET
                     ============================================= -->
                <div>

                    <label
                        for="subject"
                        class="
                            block
                            text-sm
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                        "
                    >
                        Sujet de votre demande
                    </label>


                    <select
                        id="subject"
                        name="subject"
                        required
                        class="
                            mt-3
                            w-full
                            rounded-md
                            border
                            border-zinc-700
                            bg-zinc-950
                            px-4
                            py-3
                            text-sm
                            text-white
                            outline-none
                            transition
                            focus:border-red-600
                        "
                    >

                        <option value="">
                            Sélectionnez un sujet
                        </option>


                        <option
                            value="abonnement"
                            @selected(old('subject') === 'abonnement')
                        >
                            Abonnements / Affiliation
                        </option>


                        <option
                            value="entrainements"
                            @selected(old('subject') === 'entrainements')
                        >
                            Nos entraînements
                        </option>


                        <option
                            value="compte"
                            @selected(old('subject') === 'compte')
                        >
                            Inscription / Compte
                        </option>


                        <option
                            value="autre"
                            @selected(old('subject') === 'autre')
                        >
                            Autre demande
                        </option>

                    </select>


                    @error('subject')

                        <p
                            class="
                                mt-2
                                text-sm
                                font-bold
                                text-red-500
                            "
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- =============================================
                     MESSAGE
                     ============================================= -->
                <div class="mt-8">

                    <label
                        for="message"
                        class="
                            block
                            text-sm
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                        "
                    >
                        Votre message
                    </label>


                    <textarea
                        id="message"
                        name="message"
                        rows="9"
                        required
                        class="
                            mt-3
                            w-full
                            resize-y
                            rounded-md
                            border
                            border-zinc-700
                            bg-zinc-950
                            px-4
                            py-3
                            text-sm
                            leading-7
                            text-white
                            outline-none
                            transition
                            placeholder:text-zinc-600
                            focus:border-red-600
                        "
                        placeholder="Expliquez votre demande à l'administration..."
                    >{{ old('message') }}</textarea>


                    <div
                        class="
                            mt-2
                            flex
                            flex-col
                            gap-2
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <p class="text-xs text-zinc-600">
                            Minimum 10 caractères.
                        </p>


                        <p class="text-xs text-zinc-600">
                            Maximum 5000 caractères.
                        </p>

                    </div>


                    @error('message')

                        <p
                            class="
                                mt-2
                                text-sm
                                font-bold
                                text-red-500
                            "
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- =============================================
                     INFORMATION
                     ============================================= -->
                <div
                    class="
                        mt-8
                        border-l-4
                        border-red-600
                        bg-zinc-950
                        px-5
                        py-4
                    "
                >

                    <p
                        class="
                            text-sm
                            leading-6
                            text-zinc-400
                        "
                    >
                        Votre message sera envoyé directement à l'équipe
                        d'administration BTT. Vous pourrez suivre la conversation
                        et consulter les réponses depuis votre messagerie privée.
                    </p>

                </div>


                <!-- =============================================
                     ACTIONS
                     ============================================= -->
                <div
                    class="
                        mt-8
                        flex
                        flex-col-reverse
                        gap-3
                        sm:flex-row
                        sm:items-center
                        sm:justify-end
                    "
                >

                    <!-- ANNULER -->
                    <a
                        href="{{ route('member.messages.index') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            border
                            border-zinc-700
                            px-6
                            py-3
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-400
                            transition
                            hover:border-zinc-500
                            hover:text-white
                        "
                    >
                        Annuler
                    </a>


                    <!-- ENVOYER -->
                    <button
                        type="submit"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            bg-red-600
                            px-6
                            py-3
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                            transition
                            hover:bg-red-700
                        "
                    >
                        Envoyer ma demande
                    </button>

                </div>

            </form>

        </div>

    </section>

@endsection