<!-- =========================================================
     CALCUL DES NOTIFICATIONS DE MESSAGERIE
     =========================================================
     Lorsqu'un utilisateur est connecté, nous recherchons
     les réponses de l'administration qui n'ont pas encore
     été lues par cet utilisateur.

     La pastille verte sera affichée uniquement lorsque
     ce nombre est supérieur à zéro.
     ========================================================= -->
@php

    $unreadMemberMessagesCount = 0;

    if (auth()->check()) {

        $unreadMemberMessagesCount = \App\Models\Message::query()

            /*
            |--------------------------------------------------------------------------
            | UNIQUEMENT LES MESSAGES ENVOYÉS PAR L'ADMINISTRATION
            |--------------------------------------------------------------------------
            */
            ->where(
                'sender_type',
                'admin'
            )

            /*
            |--------------------------------------------------------------------------
            | UNIQUEMENT LES MESSAGES NON LUS
            |--------------------------------------------------------------------------
            */
            ->where(
                'is_read',
                false
            )

            /*
            |--------------------------------------------------------------------------
            | UNIQUEMENT LES CONVERSATIONS DE L'UTILISATEUR CONNECTÉ
            |--------------------------------------------------------------------------
            */
            ->whereHas(
                'conversation',
                function ($query) {

                    $query->where(
                        'user_id',
                        auth()->id()
                    );

                }
            )

            /*
            |--------------------------------------------------------------------------
            | NOMBRE TOTAL DE RÉPONSES NON LUES
            |--------------------------------------------------------------------------
            */
            ->count();

    }

@endphp


<!-- =========================================================
     HEADER GLOBAL
     ========================================================= -->
<header
    class="
        border-b-2
        border-red-600
        bg-black
        text-white
    "
>

    <div
        class="
            mx-auto
            flex
            min-h-[90px]
            max-w-7xl
            items-center
            justify-between
            gap-6
            px-4
            sm:px-6
            lg:px-8
        "
    >


        <!-- =====================================================
             LOGO
             ===================================================== -->
        <a
            href="{{ url('/') }}"
            class="shrink-0"
            aria-label="Accueil Brussels Top Team"
        >

            <img
                src="{{ asset('images/BTTboxe.png') }}"
                alt="Logo Brussels Top Team"
                class="
                    h-16
                    w-16
                    object-contain
                    sm:h-20
                    sm:w-20
                "
            >

        </a>


        <!-- =====================================================
             NAVIGATION DESKTOP
             ===================================================== -->
        <nav
            class="
                hidden
                items-center
                gap-7
                lg:flex
            "
        >

            <!-- ACCUEIL -->
            <a
                href="{{ url('/') }}"
                class="
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Accueil
            </a>


            <!-- DISCIPLINES -->
            <a
                href="{{ route('disciplines') }}"
                class="
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Disciplines
            </a>


            <!-- COACHS -->
            <a
                href="{{ route('coachs') }}"
                class="
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Coachs
            </a>


            <!-- BLOG -->
            <a
                href="{{ route('blog') }}"
                class="
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Blog
            </a>


            <!-- HUMANITAIRE -->
            <a
                href="{{ route('humanitaire') }}"
                class="
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Humanitaire
            </a>


            <!-- ABONNEMENTS -->
            <a
                href="{{ route('abonnements') }}"
                class="
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Abonnements
            </a>


            <!-- CONTACT -->
            <a
                href="{{ route('contact') }}"
                class="
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Contact
            </a>

        </nav>


        <!-- =====================================================
             ACTIONS DESKTOP
             ===================================================== -->
        <div
            class="
                hidden
                items-center
                lg:flex
            "
        >

            @guest

                <!-- =================================================
                     UTILISATEUR NON CONNECTÉ
                     ================================================= -->
                <div class="flex items-center gap-3">

                    <!-- CONNEXION -->
                    <a
                        href="{{ route('login') }}"
                        class="
                            rounded-md
                            border
                            border-zinc-700
                            px-4
                            py-2.5
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                            transition
                            hover:border-red-600
                            hover:text-red-500
                        "
                    >
                        Connexion
                    </a>


                    <!-- INSCRIPTION -->
                    <a
                        href="{{ route('register') }}"
                        class="
                            rounded-md
                            bg-red-600
                            px-4
                            py-2.5
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                            transition
                            hover:bg-red-700
                        "
                    >
                        Inscription
                    </a>

                </div>

            @else

                <!-- =================================================
                     UTILISATEUR CONNECTÉ
                     MENU DÉROULANT DU COMPTE
                     ================================================= -->
                <div class="group relative">


                    <!-- =============================================
                         PSEUDO
                         =============================================
                         La pastille verte apparaît à côté du pseudo
                         lorsqu'une réponse admin n'a pas encore été lue.
                         ============================================= -->
                    <a
                        href="{{ route('member.dashboard') }}"
                        class="
                            flex
                            items-center
                            gap-2
                            py-4
                            text-sm
                            font-black
                            text-white
                            transition
                            hover:text-red-500
                            group-hover:text-red-500
                        "
                    >

                        <span>
                            {{ auth()->user()->pseudo }}
                        </span>


                        <!-- =========================================
                             NOTIFICATION GLOBALE
                             ========================================= -->
                        @if ($unreadMemberMessagesCount > 0)

                            <span
                                class="
                                    relative
                                    flex
                                    h-3
                                    w-3
                                "
                                title="{{ $unreadMemberMessagesCount }} message(s) non lu(s)"
                            >

                                <!-- Cercle animé -->
                                <span
                                    class="
                                        absolute
                                        inline-flex
                                        h-full
                                        w-full
                                        animate-ping
                                        rounded-full
                                        bg-green-400
                                        opacity-75
                                    "
                                ></span>

                                <!-- Cercle fixe -->
                                <span
                                    class="
                                        relative
                                        inline-flex
                                        h-3
                                        w-3
                                        rounded-full
                                        bg-green-500
                                    "
                                ></span>

                            </span>

                        @endif


                        <!-- PETITE FLÈCHE -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="
                                h-4
                                w-4
                                transition
                                duration-200
                                group-hover:rotate-180
                            "
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m6 9 6 6 6-6"
                            />
                        </svg>

                    </a>


                    <!-- =============================================
                         MENU DÉROULANT
                         ============================================= -->
                    <div
                        class="
                            invisible
                            absolute
                            right-0
                            top-full
                            z-50
                            w-64
                            translate-y-1
                            border
                            border-zinc-800
                            border-t-red-600
                            bg-zinc-950
                            opacity-0
                            shadow-2xl
                            transition
                            duration-150
                            group-hover:visible
                            group-hover:translate-y-0
                            group-hover:opacity-100
                        "
                    >


                        <!-- =========================================
                             IDENTITÉ DU COMPTE
                             ========================================= -->
                        <div
                            class="
                                border-b
                                border-zinc-800
                                px-5
                                py-4
                            "
                        >

                            <p
                                class="
                                    text-[10px]
                                    font-black
                                    uppercase
                                    tracking-[0.2em]
                                    text-zinc-500
                                "
                            >
                                Mon compte
                            </p>


                            <div
                                class="
                                    mt-1
                                    flex
                                    items-center
                                    gap-2
                                "
                            >

                                <p
                                    class="
                                        truncate
                                        text-sm
                                        font-black
                                        text-white
                                    "
                                >
                                    {{ auth()->user()->pseudo }}
                                </p>


                                @if ($unreadMemberMessagesCount > 0)

                                    <span
                                        class="
                                            inline-flex
                                            h-2.5
                                            w-2.5
                                            shrink-0
                                            rounded-full
                                            bg-green-500
                                        "
                                    ></span>

                                @endif

                            </div>

                        </div>


                        <!-- =========================================
                             MON PROFIL
                             ========================================= -->
                        <a
                            href="{{ route('member.dashboard') }}"
                            class="
                                flex
                                items-center
                                gap-3
                                px-5
                                py-3.5
                                text-sm
                                font-bold
                                text-zinc-300
                                transition
                                hover:bg-zinc-900
                                hover:text-red-500
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M20 21a8 8 0 0 0-16 0"
                                />

                                <circle
                                    cx="12"
                                    cy="7"
                                    r="4"
                                />
                            </svg>

                            Mon profil

                        </a>


                        <!-- =========================================
                             MON CALENDRIER
                             ========================================= -->
                        <a
                            href="{{ route('member.courses') }}"
                            class="
                                flex
                                items-center
                                gap-3
                                px-5
                                py-3.5
                                text-sm
                                font-bold
                                text-zinc-300
                                transition
                                hover:bg-zinc-900
                                hover:text-red-500
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-4 w-4"
                            >
                                <rect
                                    width="18"
                                    height="18"
                                    x="3"
                                    y="4"
                                    rx="2"
                                />

                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>

                            Mon calendrier

                        </a>


                        <!-- =========================================
                             MES MESSAGES
                             =========================================
                             La pastille verte est affichée ici lorsque
                             l'administration a répondu à l'adhérent.
                             ========================================= -->
                        <a
                            href="{{ route('member.messages.index') }}"
                            class="
                                flex
                                items-center
                                justify-between
                                gap-3
                                px-5
                                py-3.5
                                text-sm
                                font-bold
                                text-zinc-300
                                transition
                                hover:bg-zinc-900
                                hover:text-red-500
                            "
                        >

                            <span
                                class="
                                    flex
                                    items-center
                                    gap-3
                                "
                            >

                                <!-- ICÔNE MESSAGERIE -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="h-4 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"
                                    />
                                </svg>

                                Mes messages

                            </span>


                            @if ($unreadMemberMessagesCount > 0)

                                <span
                                    class="
                                        flex
                                        items-center
                                        gap-2
                                    "
                                >

                                    <!-- NOMBRE DE MESSAGES -->
                                    <span
                                        class="
                                            text-xs
                                            font-black
                                            text-green-500
                                        "
                                    >
                                        {{ $unreadMemberMessagesCount }}
                                    </span>


                                    <!-- PASTILLE VERTE -->
                                    <span
                                        class="
                                            relative
                                            flex
                                            h-2.5
                                            w-2.5
                                        "
                                    >

                                        <span
                                            class="
                                                absolute
                                                inline-flex
                                                h-full
                                                w-full
                                                animate-ping
                                                rounded-full
                                                bg-green-400
                                                opacity-75
                                            "
                                        ></span>

                                        <span
                                            class="
                                                relative
                                                inline-flex
                                                h-2.5
                                                w-2.5
                                                rounded-full
                                                bg-green-500
                                            "
                                        ></span>

                                    </span>

                                </span>

                            @endif

                        </a>


                        <!-- =========================================
                             ADMINISTRATION
                             Visible uniquement pour les comptes
                             autorisés à accéder à l'administration.
                             ========================================= -->
                        @if (auth()->user()->canAccessAdmin())

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="
                                    flex
                                    items-center
                                    gap-3
                                    border-t
                                    border-zinc-800
                                    px-5
                                    py-3.5
                                    text-sm
                                    font-bold
                                    text-zinc-300
                                    transition
                                    hover:bg-zinc-900
                                    hover:text-red-500
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="h-4 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 15.5A3.5 3.5 0 1 0 12 8a3.5 3.5 0 0 0 0 7.5Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 .6 1.7 1.7 0 0 0-.4 1.1V21a2 2 0 1 1-4 0v-.09A1.7 1.7 0 0 0 8.6 19.4a1.7 1.7 0 0 0-1.88.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-.6-1 1.7 1.7 0 0 0-1.1-.4H3a2 2 0 1 1 0-4h.09A1.7 1.7 0 0 0 4.6 8.6a1.7 1.7 0 0 0-.34-1.88l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-.6 1.7 1.7 0 0 0 .4-1.1V3a2 2 0 1 1 4 0v.09A1.7 1.7 0 0 0 15.4 4.6a1.7 1.7 0 0 0 1.88-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9c.16.37.37.7.6 1 .3.3.7.4 1.1.4H21a2 2 0 1 1 0 4h-.09a1.7 1.7 0 0 0-1.51.6Z"
                                    />
                                </svg>

                                Administration

                            </a>

                        @endif


                        <!-- =========================================
                             DÉCONNEXION
                             ========================================= -->
                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                            class="
                                border-t
                                border-zinc-800
                            "
                        >

                            @csrf

                            <button
                                type="submit"
                                class="
                                    flex
                                    w-full
                                    items-center
                                    gap-3
                                    px-5
                                    py-3.5
                                    text-left
                                    text-sm
                                    font-bold
                                    text-red-500
                                    transition
                                    hover:bg-red-600
                                    hover:text-white
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="h-4 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m16 17 5-5-5-5M21 12H9"
                                    />
                                </svg>

                                Déconnexion

                            </button>

                        </form>

                    </div>

                </div>

            @endguest

        </div>


        <!-- =====================================================
             BOUTON MENU MOBILE
             ===================================================== -->
        <button
            id="mobile-menu-button"
            type="button"
            aria-label="Ouvrir le menu"
            aria-expanded="false"
            class="
                relative
                flex
                h-11
                w-11
                items-center
                justify-center
                rounded-md
                border
                border-zinc-800
                text-white
                transition
                hover:border-red-600
                lg:hidden
            "
        >

            <!-- =================================================
                 ICÔNE MENU
                 ================================================= -->
            <svg
                id="menu-icon-open"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>


            <!-- =================================================
                 ICÔNE FERMETURE
                 ================================================= -->
            <svg
                id="menu-icon-close"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                class="hidden h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12"
                />
            </svg>


            <!-- =================================================
                 NOTIFICATION MOBILE
                 =================================================
                 Sur petit écran le pseudo n'est pas visible dans
                 le header. La pastille est donc également placée
                 directement sur le bouton du menu.
                 ================================================= -->
            @auth

                @if ($unreadMemberMessagesCount > 0)

                    <span
                        class="
                            absolute
                            -right-1
                            -top-1
                            flex
                            h-3
                            w-3
                        "
                    >

                        <span
                            class="
                                absolute
                                inline-flex
                                h-full
                                w-full
                                animate-ping
                                rounded-full
                                bg-green-400
                                opacity-75
                            "
                        ></span>

                        <span
                            class="
                                relative
                                inline-flex
                                h-3
                                w-3
                                rounded-full
                                bg-green-500
                            "
                        ></span>

                    </span>

                @endif

            @endauth

        </button>

    </div>


    <!-- =========================================================
         MENU MOBILE
         ========================================================= -->
    <div
        id="mobile-menu"
        class="
            hidden
            border-t
            border-zinc-800
            bg-black
            lg:hidden
        "
    >

        <nav
            class="
                mx-auto
                max-w-7xl
                px-4
                py-5
                sm:px-6
            "
        >

            <div class="flex flex-col">


                <!-- =================================================
                     NAVIGATION PRINCIPALE
                     ================================================= -->

                <!-- ACCUEIL -->
                <a
                    href="{{ url('/') }}"
                    class="
                        border-b
                        border-zinc-900
                        py-4
                        text-sm
                        font-bold
                        uppercase
                        transition
                        hover:text-red-500
                    "
                >
                    Accueil
                </a>


                <!-- DISCIPLINES -->
                <a
                    href="{{ route('disciplines') }}"
                    class="
                        border-b
                        border-zinc-900
                        py-4
                        text-sm
                        font-bold
                        uppercase
                        transition
                        hover:text-red-500
                    "
                >
                    Disciplines
                </a>


                <!-- COACHS -->
                <a
                    href="{{ route('coachs') }}"
                    class="
                        border-b
                        border-zinc-900
                        py-4
                        text-sm
                        font-bold
                        uppercase
                        transition
                        hover:text-red-500
                    "
                >
                    Coachs
                </a>


                <!-- BLOG -->
                <a
                    href="{{ route('blog') }}"
                    class="
                        border-b
                        border-zinc-900
                        py-4
                        text-sm
                        font-bold
                        uppercase
                        transition
                        hover:text-red-500
                    "
                >
                    Blog
                </a>


                <!-- HUMANITAIRE -->
                <a
                    href="{{ route('humanitaire') }}"
                    class="
                        border-b
                        border-zinc-900
                        py-4
                        text-sm
                        font-bold
                        uppercase
                        transition
                        hover:text-red-500
                    "
                >
                    Humanitaire
                </a>


                <!-- ABONNEMENTS -->
                <a
                    href="{{ route('abonnements') }}"
                    class="
                        border-b
                        border-zinc-900
                        py-4
                        text-sm
                        font-bold
                        uppercase
                        transition
                        hover:text-red-500
                    "
                >
                    Abonnements
                </a>


                <!-- CONTACT -->
                <a
                    href="{{ route('contact') }}"
                    class="
                        border-b
                        border-zinc-900
                        py-4
                        text-sm
                        font-bold
                        uppercase
                        transition
                        hover:text-red-500
                    "
                >
                    Contact
                </a>


                <!-- =================================================
                     COMPTE UTILISATEUR
                     ================================================= -->
                <div class="mt-5">

                    @guest

                        <!-- =========================================
                             VISITEUR
                             ========================================= -->
                        <div class="flex flex-col gap-3">

                            <!-- CONNEXION -->
                            <a
                                href="{{ route('login') }}"
                                class="
                                    flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    border
                                    border-zinc-700
                                    px-4
                                    py-3
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-white
                                    transition
                                    hover:border-red-600
                                    hover:text-red-500
                                "
                            >
                                Connexion
                            </a>


                            <!-- INSCRIPTION -->
                            <a
                                href="{{ route('register') }}"
                                class="
                                    flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    bg-red-600
                                    px-4
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
                                Inscription
                            </a>

                        </div>

                    @else

                        <!-- =========================================
                             UTILISATEUR CONNECTÉ
                             ========================================= -->
                        <div class="flex flex-col gap-3">


                            <!-- =====================================
                                 IDENTITÉ DU COMPTE
                                 ===================================== -->
                            <div
                                class="
                                    border-l-2
                                    border-red-600
                                    bg-zinc-950
                                    px-4
                                    py-3
                                "
                            >

                                <p
                                    class="
                                        text-[10px]
                                        font-black
                                        uppercase
                                        tracking-[0.2em]
                                        text-zinc-500
                                    "
                                >
                                    Mon compte
                                </p>


                                <div
                                    class="
                                        mt-1
                                        flex
                                        items-center
                                        gap-2
                                    "
                                >

                                    <p
                                        class="
                                            text-sm
                                            font-black
                                            text-white
                                        "
                                    >
                                        {{ auth()->user()->pseudo }}
                                    </p>


                                    @if ($unreadMemberMessagesCount > 0)

                                        <span
                                            class="
                                                relative
                                                flex
                                                h-2.5
                                                w-2.5
                                            "
                                        >

                                            <span
                                                class="
                                                    absolute
                                                    inline-flex
                                                    h-full
                                                    w-full
                                                    animate-ping
                                                    rounded-full
                                                    bg-green-400
                                                    opacity-75
                                                "
                                            ></span>

                                            <span
                                                class="
                                                    relative
                                                    inline-flex
                                                    h-2.5
                                                    w-2.5
                                                    rounded-full
                                                    bg-green-500
                                                "
                                            ></span>

                                        </span>

                                    @endif

                                </div>

                            </div>


                            <!-- =====================================
                                 MON PROFIL
                                 ===================================== -->
                            <a
                                href="{{ route('member.dashboard') }}"
                                class="
                                    flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    border
                                    border-zinc-700
                                    px-4
                                    py-3
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-white
                                    transition
                                    hover:border-red-600
                                    hover:text-red-500
                                "
                            >
                                Mon profil
                            </a>


                            <!-- =====================================
                                 MON CALENDRIER
                                 ===================================== -->
                            <a
                                href="{{ route('member.courses') }}"
                                class="
                                    flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    border
                                    border-zinc-700
                                    px-4
                                    py-3
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-white
                                    transition
                                    hover:border-red-600
                                    hover:text-red-500
                                "
                            >
                                Mon calendrier
                            </a>


                            <!-- =====================================
                                 MES MESSAGES
                                 ===================================== -->
                            <a
                                href="{{ route('member.messages.index') }}"
                                class="
                                    flex
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-md
                                    border
                                    border-zinc-700
                                    px-4
                                    py-3
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-white
                                    transition
                                    hover:border-red-600
                                    hover:text-red-500
                                "
                            >

                                <span>
                                    Mes messages
                                </span>


                                @if ($unreadMemberMessagesCount > 0)

                                    <span
                                        class="
                                            flex
                                            items-center
                                            gap-1.5
                                        "
                                    >

                                        <span class="text-green-500">
                                            {{ $unreadMemberMessagesCount }}
                                        </span>


                                        <span
                                            class="
                                                relative
                                                flex
                                                h-2.5
                                                w-2.5
                                            "
                                        >

                                            <span
                                                class="
                                                    absolute
                                                    inline-flex
                                                    h-full
                                                    w-full
                                                    animate-ping
                                                    rounded-full
                                                    bg-green-400
                                                    opacity-75
                                                "
                                            ></span>

                                            <span
                                                class="
                                                    relative
                                                    inline-flex
                                                    h-2.5
                                                    w-2.5
                                                    rounded-full
                                                    bg-green-500
                                                "
                                            ></span>

                                        </span>

                                    </span>

                                @endif

                            </a>


                            <!-- =====================================
                                 ADMINISTRATION
                                 ===================================== -->
                            @if (auth()->user()->canAccessAdmin())

                                <a
                                    href="{{ route('admin.dashboard') }}"
                                    class="
                                        flex
                                        items-center
                                        justify-center
                                        rounded-md
                                        bg-white
                                        px-4
                                        py-3
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-black
                                        transition
                                        hover:bg-red-600
                                        hover:text-white
                                    "
                                >
                                    Administration
                                </a>

                            @endif


                            <!-- =====================================
                                 DÉCONNEXION
                                 ===================================== -->
                            <form
                                action="{{ route('logout') }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="
                                        flex
                                        w-full
                                        items-center
                                        justify-center
                                        rounded-md
                                        border
                                        border-red-600/50
                                        px-4
                                        py-3
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-red-500
                                        transition
                                        hover:bg-red-600
                                        hover:text-white
                                    "
                                >
                                    Déconnexion
                                </button>

                            </form>

                        </div>

                    @endguest

                </div>

            </div>

        </nav>

    </div>

</header>