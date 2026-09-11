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

        <!-- Élément graphique rouge discret -->
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


                <!-- Ligne décorative -->
                <div class="my-10 h-px w-full bg-zinc-800">

                    <div class="h-px w-20 bg-red-600"></div>

                </div>


                <!-- Information visiteur -->
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
                        Ce formulaire sera votre moyen de contacter
                        directement l'administration du club.
                    </p>

                </div>


                <!-- Information adhérent -->
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
                        Une fois connecté à votre espace personnel,
                        vous disposerez également d'un accès direct
                        à la messagerie de l'administration.
                    </p>

                </div>

            </div>


            <!-- =================================================
                 FORMULAIRE
                 ================================================= -->
            <div>

                <!--
                    IMPORTANT :

                    Le formulaire est déjà préparé visuellement,
                    mais son traitement sera développé plus tard.

                    Lorsque la messagerie sera créée, ce formulaire
                    enregistrera les demandes dans la base de données
                    avant de les transmettre à l'espace administrateur.
                -->
                <form
                    action="#"
                    method="POST"
                    class="space-y-8"
                >

                    <!-- =================================================
                         NOM
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
                            placeholder="Votre nom et prénom"
                            autocomplete="name"
                            class="
                                mt-3
                                w-full
                                border
                                border-zinc-800
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-red-600
                            "
                        >

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
                            placeholder="exemple@email.com"
                            autocomplete="email"
                            class="
                                mt-3
                                w-full
                                border
                                border-zinc-800
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-red-600
                            "
                        >


                        <p
                            class="
                                mt-3
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Cette adresse sera utilisée pour vous confirmer
                            la réception de votre demande et vous transmettre
                            la réponse de l'administration.
                        </p>

                    </div>


                    <!-- =================================================
                         THÈME DE LA DEMANDE
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
                            class="
                                mt-3
                                w-full
                                border
                                border-zinc-800
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                focus:border-red-600
                            "
                        >

                            <option value="">
                                Sélectionnez un sujet
                            </option>

                            <option value="abonnement">
                                Abonnements / Affiliation
                            </option>

                            <option value="entrainements">
                                Nos entraînements
                            </option>

                            <option value="inscription">
                                Inscription / Compte
                            </option>

                            <option value="autre">
                                Autre demande
                            </option>

                        </select>

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
                            placeholder="Expliquez-nous votre demande..."
                            class="
                                mt-3
                                w-full
                                resize-y
                                border
                                border-zinc-800
                                bg-black
                                px-5
                                py-4
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-red-600
                            "
                        ></textarea>

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
                            Après l'envoi de votre demande, une confirmation
                            vous sera adressée par email. Votre message sera
                            ensuite accessible à l'équipe d'administration
                            de Brussels Top Team.
                        </p>

                    </div>


                    <!-- =================================================
                         BOUTON D'ENVOI
                         ================================================= -->
                    <div>

                        <!--
                            Le bouton reste désactivé pour le moment.

                            Il sera activé lorsque le système de messagerie,
                            la base de données et l'envoi des emails seront
                            développés.
                        -->
                        <button
                            type="button"
                            disabled
                            class="
                                inline-flex
                                cursor-not-allowed
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
                                opacity-50
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
                            L'envoi des messages sera activé prochainement.
                        </p>

                    </div>

                </form>

            </div>

        </div>

    </section>


    <!-- =========================================================
         FUTUR SUIVI DES MESSAGES
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


            <!-- Titre -->
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


            <!-- Explication -->
            <div>

                <p
                    class="
                        max-w-3xl
                        text-lg
                        leading-8
                        text-zinc-400
                    "
                >
                    Les adhérents disposant d'un compte BTT pourront retrouver
                    leurs échanges avec l'administration directement dans
                    leur espace personnel.
                </p>


                <p
                    class="
                        mt-5
                        max-w-3xl
                        leading-8
                        text-zinc-500
                    "
                >
                    Lorsqu'une réponse sera disponible, elle apparaîtra
                    dans leur boîte de réception BTT et une notification
                    leur sera également envoyée par email.
                </p>

            </div>

        </div>

    </section>


@endsection