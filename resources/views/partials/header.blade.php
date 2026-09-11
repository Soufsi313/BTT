<header class="relative z-50 border-b border-red-600 bg-black">

    <!-- =========================================================
         CONTENEUR PRINCIPAL
         ========================================================= -->
    <div class="mx-auto flex h-24 max-w-7xl items-center justify-between px-6 lg:px-8">


        <!-- =====================================================
             LOGO BTT
             ===================================================== -->
        <a
            href="{{ url('/') }}"
            class="flex shrink-0 items-center"
            aria-label="Brussels Top Team - Accueil"
        >
            <img
                src="{{ asset('images/BTTboxe.png') }}"
                alt="Brussels Top Team"
                class="h-16 w-auto object-contain"
            >
        </a>


        <!-- =====================================================
             NAVIGATION DESKTOP
             ===================================================== -->
        <nav
            class="hidden items-center gap-8 lg:flex"
            aria-label="Navigation principale"
        >

            <a
                href="{{ url('/') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Accueil
            </a>

            <a
                href="{{ route('disciplines') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Disciplines
            </a>

            <a
                href="{{ route('coachs') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Coachs
            </a>

            <a
                href="{{ route('blog') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Blog
            </a>

            <a
                href="{{ route('humanitaire') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Humanitaire
            </a>

            <a
                href="{{ route('abonnements') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Abonnements
            </a>

            <a
                href="{{ route('contact') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Contact
            </a>

        </nav>


        <!-- =====================================================
             ZONE COMPTE DESKTOP
             ===================================================== -->
        <div class="hidden shrink-0 items-center gap-3 lg:flex">


            <!-- =================================================
                 UTILISATEUR NON CONNECTÉ
                 ================================================= -->
            @guest

                <!-- Connexion -->
                <a
                    href="{{ route('login') }}"
                    class="
                        rounded-md
                        border
                        border-zinc-700
                        px-4
                        py-3
                        text-xs
                        font-bold
                        uppercase
                        text-white
                        transition
                        hover:border-red-600
                        hover:text-red-500
                    "
                >
                    Connexion
                </a>


                <!-- Inscription -->
                <a
                    href="{{ route('register') }}"
                    class="
                        rounded-md
                        bg-red-600
                        px-4
                        py-3
                        text-xs
                        font-bold
                        uppercase
                        text-white
                        transition
                        hover:bg-red-700
                    "
                >
                    Inscription
                </a>

            @endguest


            <!-- =================================================
                 UTILISATEUR CONNECTÉ
                 ================================================= -->
            @auth

                <!-- =============================================
                     PSEUDO DE L'UTILISATEUR
                     ============================================= -->
                <a
                    href="#"
                    class="
                        flex
                        items-center
                        gap-3
                        rounded-md
                        border
                        border-zinc-800
                        bg-zinc-900
                        px-4
                        py-3
                        transition
                        hover:border-red-600
                    "
                >

                    <!-- Icône utilisateur -->
                    <svg
                        class="h-5 w-5 text-red-500"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>


                    <!-- Pseudo public -->
                    <span class="text-sm font-bold text-white">
                        {{ auth()->user()->pseudo }}
                    </span>

                </a>


                <!-- =============================================
                     FORMULAIRE DE DÉCONNEXION
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
                            py-3
                            text-xs
                            font-bold
                            uppercase
                            text-red-500
                            transition
                            hover:bg-red-600
                            hover:text-white
                        "
                    >
                        Déconnexion
                    </button>

                </form>

            @endauth

        </div>


        <!-- =====================================================
             BOUTON MENU MOBILE
             ===================================================== -->
        <button
            id="mobile-menu-button"
            type="button"
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
                hover:text-red-500
                lg:hidden
            "
            aria-label="Ouvrir le menu"
            aria-expanded="false"
            aria-controls="mobile-menu"
        >

            <!-- Icône hamburger -->
            <svg
                id="menu-icon-open"
                class="h-6 w-6"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M4 6h16"></path>
                <path d="M4 12h16"></path>
                <path d="M4 18h16"></path>
            </svg>


            <!-- Icône fermeture -->
            <svg
                id="menu-icon-close"
                class="hidden h-6 w-6"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>

        </button>

    </div>


    <!-- =========================================================
         MENU MOBILE
         ========================================================= -->
    <div
        id="mobile-menu"
        class="hidden border-t border-zinc-900 bg-black lg:hidden"
    >

        <nav
            class="mx-auto flex max-w-7xl flex-col px-6 py-6"
            aria-label="Navigation mobile"
        >

            <a
                href="{{ url('/') }}"
                class="
                    border-b
                    border-zinc-900
                    py-4
                    text-sm
                    font-semibold
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
                    font-semibold
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
                    font-semibold
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
                    font-semibold
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
                    font-semibold
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
                    font-semibold
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
                    font-semibold
                    uppercase
                    transition
                    hover:text-red-500
                "
            >
                Contact
            </a>


            <!-- =================================================
                 UTILISATEUR NON CONNECTÉ
                 ================================================= -->
            @guest

                <div class="grid grid-cols-2 gap-3 pt-5">

                    <!-- Connexion -->
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
                            py-4
                            text-sm
                            font-bold
                            uppercase
                            transition
                            hover:border-red-600
                            hover:text-red-500
                        "
                    >
                        Connexion
                    </a>


                    <!-- Inscription -->
                    <a
                        href="{{ route('register') }}"
                        class="
                            flex
                            items-center
                            justify-center
                            rounded-md
                            bg-red-600
                            px-4
                            py-4
                            text-sm
                            font-bold
                            uppercase
                            transition
                            hover:bg-red-700
                        "
                    >
                        Inscription
                    </a>

                </div>

            @endguest


            <!-- =================================================
                 UTILISATEUR CONNECTÉ
                 ================================================= -->
            @auth

                <!-- Pseudo -->
                <a
                    href="#"
                    class="
                        mt-5
                        flex
                        items-center
                        gap-3
                        rounded-md
                        border
                        border-zinc-800
                        bg-zinc-900
                        px-4
                        py-4
                        transition
                        hover:border-red-600
                    "
                >

                    <svg
                        class="h-5 w-5 text-red-500"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>


                    <span class="text-sm font-bold text-white">
                        {{ auth()->user()->pseudo }}
                    </span>

                </a>


                <!-- Déconnexion -->
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="mt-3"
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
                            py-4
                            text-sm
                            font-bold
                            uppercase
                            text-red-500
                            transition
                            hover:bg-red-600
                            hover:text-white
                        "
                    >
                        Déconnexion
                    </button>

                </form>

            @endauth

        </nav>

    </div>

</header>