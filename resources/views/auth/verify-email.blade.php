{{-- 
|--------------------------------------------------------------------------
| PAGE DE VÉRIFICATION DE L'ADRESSE EMAIL
|--------------------------------------------------------------------------
|
| Cette page est affichée lorsqu'un utilisateur est connecté mais que
| son adresse email n'a pas encore été vérifiée.
|
| Elle permet :
|
| - d'informer l'utilisateur qu'un email de vérification lui a été envoyé ;
| - d'afficher l'adresse email concernée ;
| - de demander l'envoi d'un nouveau lien de vérification ;
| - de se déconnecter si nécessaire.
|
--}}

<!DOCTYPE html>

<html lang="fr">

<head>

    {{-- ============================================================
         MÉTADONNÉES
         ============================================================ --}}

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Vérification de votre email - BTT</title>


    {{-- ============================================================
         ASSETS VITE
         ============================================================ --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-zinc-950 text-white">


    {{-- ============================================================
         CONTENEUR PRINCIPAL
         ============================================================ --}}

    <main
        class="
            flex
            min-h-screen
            items-center
            justify-center
            px-4
            py-12
            sm:px-6
            lg:px-8
        "
    >

        <div class="w-full max-w-lg">


            {{-- ====================================================
                 CARTE DE VÉRIFICATION
                 ==================================================== --}}

            <section
                class="
                    overflow-hidden
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    shadow-2xl
                "
            >


                {{-- =================================================
                     BANDEAU ROUGE BTT
                     ================================================= --}}

                <div class="h-2 bg-red-600"></div>


                <div class="p-6 sm:p-8">


                    {{-- =============================================
                         TITRE
                         ============================================= --}}

                    <div class="text-center">

                        <p
                            class="
                                mb-3
                                text-sm
                                font-bold
                                uppercase
                                tracking-[0.25em]
                                text-red-500
                            "
                        >
                            Brussels Top Team
                        </p>


                        <h1
                            class="
                                text-2xl
                                font-black
                                uppercase
                                tracking-wide
                                text-white
                                sm:text-3xl
                            "
                        >
                            Vérifiez votre email
                        </h1>

                    </div>


                    {{-- =============================================
                         ICÔNE
                         ============================================= --}}

                    <div class="my-8 flex justify-center">

                        <div
                            class="
                                flex
                                h-20
                                w-20
                                items-center
                                justify-center
                                rounded-full
                                border
                                border-red-600/40
                                bg-red-600/10
                            "
                        >

                            <svg
                                class="h-10 w-10 text-red-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.69 5.793a1.875 1.875 0 0 1-2.12 0L2.25 6.75"
                                />
                            </svg>

                        </div>

                    </div>


                    {{-- =============================================
                         MESSAGE PRINCIPAL
                         ============================================= --}}

                    <div
                        class="
                            space-y-4
                            text-center
                            text-sm
                            leading-6
                            text-zinc-300
                            sm:text-base
                        "
                    >

                        <p>
                            Votre compte BTT a bien été créé.
                        </p>

                        <p>
                            Pour finaliser votre inscription et accéder
                            aux fonctionnalités réservées aux adhérents,
                            veuillez confirmer votre adresse email.
                        </p>


                        {{-- =========================================
                             ADRESSE EMAIL DU MEMBRE
                             ========================================= --}}

                        @auth

                            <div
                                class="
                                    mx-auto
                                    mt-5
                                    rounded-xl
                                    border
                                    border-zinc-700
                                    bg-zinc-950
                                    px-4
                                    py-3
                                "
                            >

                                <p class="text-xs uppercase tracking-wide text-zinc-500">
                                    Email à vérifier
                                </p>

                                <p
                                    class="
                                        mt-1
                                        break-all
                                        font-semibold
                                        text-white
                                    "
                                >
                                    {{ auth()->user()->email }}
                                </p>

                            </div>

                        @endauth


                        <p class="pt-2 text-zinc-400">
                            Consultez votre boîte de réception puis cliquez
                            sur le lien contenu dans l'email que nous vous
                            avons envoyé.
                        </p>

                    </div>


                    {{-- =============================================
                         CONFIRMATION DU RENVOI DE L'EMAIL
                         =============================================
                         Laravel placera le statut "verification-link-sent"
                         dans la session après un renvoi réussi.
                         ============================================= --}}

                    @if (session('status') === 'verification-link-sent')

                        <div
                            class="
                                mt-6
                                rounded-xl
                                border
                                border-green-800
                                bg-green-950/40
                                px-4
                                py-3
                                text-sm
                                text-green-300
                            "
                        >
                            Un nouveau lien de vérification vient de vous
                            être envoyé.
                        </div>

                    @endif


                    {{-- =============================================
                         ACTIONS
                         ============================================= --}}

                    <div class="mt-8 space-y-3">


                        {{-- =========================================
                             RENVOYER LE LIEN DE VÉRIFICATION
                             =========================================
                             Cette route sera créée à l'étape suivante.
                             ========================================= --}}

                        <form
                            method="POST"
                            action="{{ route('verification.send') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="
                                    inline-flex
                                    w-full
                                    items-center
                                    justify-center
                                    rounded-xl
                                    bg-red-600
                                    px-5
                                    py-3
                                    text-sm
                                    font-bold
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
                                Renvoyer l'email de vérification
                            </button>

                        </form>


                        {{-- =========================================
                             DÉCONNEXION
                             ========================================= --}}

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="
                                    inline-flex
                                    w-full
                                    items-center
                                    justify-center
                                    rounded-xl
                                    border
                                    border-zinc-700
                                    bg-zinc-800
                                    px-5
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-zinc-200
                                    transition
                                    hover:border-zinc-600
                                    hover:bg-zinc-700
                                    hover:text-white
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-zinc-600
                                "
                            >
                                Se déconnecter
                            </button>

                        </form>

                    </div>


                    {{-- =============================================
                         INFORMATION COMPLÉMENTAIRE
                         ============================================= --}}

                    <div
                        class="
                            mt-7
                            border-t
                            border-zinc-800
                            pt-6
                            text-center
                        "
                    >

                        <p class="text-xs leading-5 text-zinc-500">
                            Si vous ne trouvez pas l'email, pensez également
                            à vérifier votre dossier de courriers indésirables.
                        </p>

                    </div>

                </div>

            </section>


            {{-- ====================================================
                 RETOUR AU SITE PUBLIC
                 ==================================================== --}}

            <div class="mt-6 text-center">

                <a
                    href="{{ route('home') }}"
                    class="
                        text-sm
                        font-medium
                        text-zinc-400
                        transition
                        hover:text-red-500
                    "
                >
                    ← Retour au site BTT
                </a>

            </div>

        </div>

    </main>

</body>

</html>