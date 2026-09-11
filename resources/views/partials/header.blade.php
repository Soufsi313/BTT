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
                gap-3
                lg:flex
            "
        >


            @guest

                <!-- =================================================
                     UTILISATEUR NON CONNECTÉ
                     ================================================= -->

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

            @else

                <!-- =================================================
                     UTILISATEUR CONNECTÉ
                     ================================================= -->


                <!-- =============================================
                     ACCÈS ADMINISTRATION
                     Visible uniquement pour Admin / Super Admin
                     ============================================= -->
                @if (auth()->user()->canAccessAdmin())

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="
                            rounded-md
                            bg-white
                            px-4
                            py-2.5
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


                <!-- =============================================
                     ESPACE ADHÉRENT
                     ============================================= -->
                <a
                    href="{{ route('member.dashboard') }}"
                    class="
                        text-sm
                        font-black
                        text-white
                        transition
                        hover:text-red-500
                    "
                >
                    {{ auth()->user()->pseudo }}
                </a>


                <!-- =============================================
                     DÉCONNEXION
                     ============================================= -->
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="
                            rounded-md
                            border
                            border-red-600/50
                            px-4
                            py-2.5
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
                                 ESPACE PERSONNEL
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
                                    text-sm
                                    font-black
                                    text-white
                                    transition
                                    hover:border-red-600
                                    hover:text-red-500
                                "
                            >
                                {{ auth()->user()->pseudo }}
                            </a>


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