@extends('layouts.app')


@section('title', 'Contact - Brussels Top Team')


@section(
    'meta_description',
    'Contactez Brussels Top Team pour toute question concernant les entraînements, les affiliations, les inscriptions ou toute autre demande.'
)


@section('content')


    <!-- =========================================================
         HERO - CONTACT
         ========================================================= -->
    <section
        class="
            relative
            overflow-hidden
            border-b
            border-zinc-900
            bg-black
            px-6
            py-20
            lg:px-8
            lg:py-28
        "
    >

        <!-- =====================================================
             ÉLÉMENT GRAPHIQUE ROUGE
             ===================================================== -->
        <div
            class="
                pointer-events-none
                absolute
                -right-32
                top-0
                h-96
                w-96
                rounded-full
                bg-red-600/10
                blur-3xl
            "
        ></div>


        <div class="relative mx-auto max-w-7xl">

            <p
                class="
                    text-sm
                    font-black
                    uppercase
                    tracking-[0.3em]
                    text-red-500
                "
            >
                Brussels Top Team
            </p>


            <h1
                class="
                    mt-4
                    max-w-5xl
                    text-5xl
                    font-black
                    uppercase
                    leading-none
                    tracking-tight
                    text-white
                    sm:text-6xl
                    lg:text-7xl
                "
            >
                Une question ?

                <span class="text-red-600">
                    Contactez-nous.
                </span>
            </h1>


            <p
                class="
                    mt-8
                    max-w-3xl
                    text-lg
                    leading-8
                    text-zinc-400
                "
            >
                Une question concernant votre affiliation, nos entraînements
                ou le fonctionnement du club ? Envoyez-nous votre demande
                à l'aide du formulaire ci-dessous.
            </p>

        </div>

    </section>



    <!-- =========================================================
         FORMULAIRE DE CONTACT
         ========================================================= -->
    <section
        class="
            bg-zinc-950
            px-6
            py-20
            lg:px-8
            lg:py-28
        "
    >

        <div
            class="
                mx-auto
                grid
                max-w-7xl
                gap-16
                lg:grid-cols-[0.7fr_1.3fr]
                lg:gap-24
            "
        >


            <!-- =================================================
                 INFORMATIONS
                 ================================================= -->
            <div>

                <p
                    class="
                        text-sm
                        font-black
                        uppercase
                        tracking-[0.3em]
                        text-red-500
                    "
                >
                    Nous contacter
                </p>


                <h2
                    class="
                        mt-4
                        text-4xl
                        font-black
                        uppercase
                        tracking-tight
                        text-white
                    "
                >
                    Parlez-nous de votre demande
                </h2>


                <p
                    class="
                        mt-6
                        max-w-xl
                        leading-8
                        text-zinc-400
                    "
                >
                    Sélectionnez le sujet correspondant à votre demande
                    afin qu'elle puisse être prise en charge plus facilement
                    par l'administration de Brussels Top Team.
                </p>


                <!-- =============================================
                     LIGNE DÉCORATIVE
                     ============================================= -->
                <div class="my-10 h-px w-full bg-zinc-800">

                    <div class="h-px w-20 bg-red-600"></div>

                </div>


                <!-- =============================================
                     INFORMATION VISITEUR
                     ============================================= -->
                <div>

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-zinc-500
                        "
                    >
                        Vous êtes visiteur ?
                    </p>


                    <p
                        class="
                            mt-3
                            leading-7
                            text-zinc-300
                        "
                    >
                        Ce formulaire vous permet de contacter directement
                        l'administration du club sans avoir besoin de créer
                        un compte.
                    </p>

                </div>


                <!-- =============================================
                     INFORMATION ADHÉRENT
                     ============================================= -->
                <div class="mt-8">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.2em]
                            text-zinc-500
                        "
                    >
                        Vous êtes adhérent ?
                    </p>


                    <p
                        class="
                            mt-3
                            leading-7
                            text-zinc-300
                        "
                    >
                        Lorsque vous êtes connecté, votre demande est
                        automatiquement rattachée à votre compte BTT.
                        Votre identité et votre adresse email sont alors
                        récupérées depuis votre profil.
                    </p>

                </div>

            </div>



            <!-- =================================================
                 FORMULAIRE
                 ================================================= -->
            <div>


                <!-- =============================================
                     MESSAGE DE CONFIRMATION
                     ============================================= -->
                @if (session('success'))

                    <div
                        class="
                            mb-8
                            border
                            border-green-700/50
                            bg-green-950/40
                            px-6
                            py-5
                            text-green-300
                        "
                    >
                        <p class="font-bold">
                            {{ session('success') }}
                        </p>
                    </div>

                @endif


                <!-- =============================================
                     RÉSUMÉ DES ERREURS
                     ============================================= -->
                @if ($errors->any())

                    <div
                        class="
                            mb-8
                            border
                            border-red-700/50
                            bg-red-950/40
                            px-6
                            py-5
                        "
                    >

                        <p class="font-black uppercase text-red-400">
                            Votre demande n'a pas pu être envoyée.
                        </p>

                        <ul
                            class="
                                mt-3
                                list-disc
                                space-y-1
                                pl-5
                                text-sm
                                text-red-300
                            "
                        >

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <!-- =============================================
                     ENVOI VERS CONTACTCONTROLLER
                     ============================================= -->
                <form
                    action="{{ route('contact.store') }}"
                    method="POST"
                    class="space-y-8"
                >

                    @csrf


                    <!-- =================================================
                         NOM ET PRÉNOM
                         ================================================= -->
                    <div>

                        <label
                            for="name"
                            class="
                                block
                                text-sm
                                font-bold
                                uppercase
                                tracking-wider
                                text-white
                            "
                        >
                            Nom et prénom
                        </label>


                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old(
                                'name',
                                auth()->check()
                                    ? trim(auth()->user()->prenom . ' ' . auth()->user()->nom)
                                    : ''
                            ) }}"
                            placeholder="Votre nom et prénom"
                            autocomplete="name"
                            required
                            @auth
                                readonly
                            @endauth
                            class="
                                mt-3
                                w-full
                                border
                                @error('name')
                                    border-red-600
                                @else
                                    border-zinc-800
                                @enderror
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-red-600
                                read-only:cursor-not-allowed
                                read-only:bg-zinc-900
                                read-only:text-zinc-400
                            "
                        >


                        @error('name')

                            <p class="mt-2 text-sm font-bold text-red-500">
                                {{ $message }}
                            </p>

                        @enderror


                        @auth

                            <p class="mt-3 text-sm leading-6 text-zinc-500">
                                Cette identité provient de votre compte BTT.
                            </p>

                        @endauth

                    </div>



                    <!-- =================================================
                         EMAIL
                         ================================================= -->
                    <div>

                        <label
                            for="email"
                            class="
                                block
                                text-sm
                                font-bold
                                uppercase
                                tracking-wider
                                text-white
                            "
                        >
                            Adresse email
                        </label>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old(
                                'email',
                                auth()->check()
                                    ? auth()->user()->email
                                    : ''
                            ) }}"
                            placeholder="exemple@email.com"
                            autocomplete="email"
                            required
                            @auth
                                readonly
                            @endauth
                            class="
                                mt-3
                                w-full
                                border
                                @error('email')
                                    border-red-600
                                @else
                                    border-zinc-800
                                @enderror
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-red-600
                                read-only:cursor-not-allowed
                                read-only:bg-zinc-900
                                read-only:text-zinc-400
                            "
                        >


                        @error('email')

                            <p class="mt-2 text-sm font-bold text-red-500">
                                {{ $message }}
                            </p>

                        @enderror


                        <p
                            class="
                                mt-3
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Cette adresse permettra à l'administration
                            de vous identifier et, lorsque le système email
                            sera activé, de vous transmettre ses notifications.
                        </p>

                    </div>



                    <!-- =================================================
                         SUJET DE LA DEMANDE
                         ================================================= -->
                    <div>

                        <label
                            for="subject"
                            class="
                                block
                                text-sm
                                font-bold
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
                                border
                                @error('subject')
                                    border-red-600
                                @else
                                    border-zinc-800
                                @enderror
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                focus:border-red-600
                            "
                        >

                            <option
                                value=""
                                @selected(old('subject') === null || old('subject') === '')
                            >
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

                            <p class="mt-2 text-sm font-bold text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    <!-- =================================================
                         MESSAGE
                         ================================================= -->
                    <div>

                        <label
                            for="message"
                            class="
                                block
                                text-sm
                                font-bold
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
                            rows="8"
                            minlength="10"
                            maxlength="5000"
                            required
                            placeholder="Expliquez-nous votre demande..."
                            class="
                                mt-3
                                w-full
                                resize-y
                                border
                                @error('message')
                                    border-red-600
                                @else
                                    border-zinc-800
                                @enderror
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-red-600
                            "
                        >{{ old('message') }}</textarea>


                        @error('message')

                            <p class="mt-2 text-sm font-bold text-red-500">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-3 text-sm text-zinc-600">
                            10 caractères minimum — 5000 caractères maximum.
                        </p>

                    </div>



                    <!-- =================================================
                         INFORMATION SUR LE TRAITEMENT
                         ================================================= -->
                    <div
                        class="
                            border-l-4
                            border-red-600
                            bg-black
                            px-6
                            py-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                leading-6
                                text-zinc-400
                            "
                        >
                            Après l'envoi, votre demande sera enregistrée
                            dans la messagerie Brussels Top Team et pourra
                            être consultée par l'équipe d'administration.
                        </p>

                    </div>



                    <!-- =================================================
                         BOUTON D'ENVOI
                         ================================================= -->
                    <div>

                        <button
                            type="submit"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                bg-red-600
                                px-8
                                py-4
                                text-sm
                                font-black
                                uppercase
                                tracking-wider
                                text-white
                                transition
                                hover:bg-red-700
                                focus:outline-none
                                focus:ring-2
                                focus:ring-red-600
                                focus:ring-offset-2
                                focus:ring-offset-zinc-950
                            "
                        >
                            Envoyer ma demande
                        </button>


                        <p
                            class="
                                mt-4
                                text-sm
                                text-zinc-600
                            "
                        >
                            Votre message sera transmis à l'administration BTT.
                        </p>

                    </div>

                </form>

            </div>

        </div>

    </section>



    <!-- =========================================================
         SUIVI DES MESSAGES
         ========================================================= -->
    <section
        class="
            border-t
            border-zinc-900
            bg-black
            px-6
            py-20
            lg:px-8
            lg:py-24
        "
    >

        <div
            class="
                mx-auto
                grid
                max-w-7xl
                gap-12
                lg:grid-cols-[0.65fr_1.35fr]
                lg:items-center
                lg:gap-24
            "
        >


            <!-- =============================================
                 TITRE
                 ============================================= -->
            <div>

                <p
                    class="
                        text-sm
                        font-black
                        uppercase
                        tracking-[0.3em]
                        text-red-500
                    "
                >
                    Adhérents BTT
                </p>


                <h2
                    class="
                        mt-4
                        text-4xl
                        font-black
                        uppercase
                        tracking-tight
                        text-white
                    "
                >
                    Suivez vos échanges
                </h2>

            </div>


            <!-- =============================================
                 EXPLICATION
                 ============================================= -->
            <div>

                <p
                    class="
                        max-w-3xl
                        text-lg
                        leading-8
                        text-zinc-400
                    "
                >
                    Les adhérents disposant d'un compte BTT pourront
                    retrouver leurs échanges avec l'administration
                    directement dans leur espace personnel.
                </p>


                <p
                    class="
                        mt-5
                        max-w-3xl
                        leading-8
                        text-zinc-500
                    "
                >
                    Nous développerons ensuite la boîte de réception privée
                    permettant de consulter l'historique des conversations
                    et les réponses de l'administration.
                </p>

            </div>

        </div>

    </section>


@endsection