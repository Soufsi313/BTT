<header class="relative z-50 border-b border-red-600 bg-black">

    <!-- =========================================================
         CONTENEUR PRINCIPAL DU HEADER
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

            <!-- Accueil -->
            <a
                href="{{ url('/') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Accueil
            </a>


            <!-- Disciplines -->
            <a
                href="{{ route('disciplines') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Disciplines
            </a>


            <!-- Coachs -->
            <a
                href="{{ route('coachs') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Coachs
            </a>


            <!-- Blog -->
            <a
                href="{{ route('blog') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Blog
            </a>


            <!-- Humanitaire -->
            <a
                href="{{ route('humanitaire') }}"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Humanitaire
            </a>


            <!-- Abonnements -->
            <a
                href="#"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Abonnements
            </a>


            <!-- Contact -->
            <a
                href="#"
                class="text-sm font-semibold uppercase transition hover:text-red-500"
            >
                Contact
            </a>

        </nav>


        <!-- =====================================================
             BOUTON INSCRIPTION DESKTOP
             ===================================================== -->
        <a
            href="#"
            class="
                hidden
                rounded-md
                bg-red-600
                px-5
                py-3
                text-sm
                font-bold
                uppercase
                transition
                hover:bg-red-700
                lg:inline-flex
            "
        >
            S'inscrire
        </a>


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
         NAVIGATION MOBILE
         ========================================================= -->
    <div
        id="mobile-menu"
        class="hidden border-t border-zinc-900 bg-black lg:hidden"
    >

        <nav
            class="mx-auto flex max-w-7xl flex-col px-6 py-6"
            aria-label="Navigation mobile"
        >

            <!-- Accueil -->
            <a
                href="{{ url('/') }}"
                class="
                    border-b border-zinc-900 py-4
                    text-sm font-semibold uppercase
                    transition hover:text-red-500
                "
            >
                Accueil
            </a>


            <!-- Disciplines -->
            <a
                href="{{ route('disciplines') }}"
                class="
                    border-b border-zinc-900 py-4
                    text-sm font-semibold uppercase
                    transition hover:text-red-500
                "
            >
                Disciplines
            </a>


            <!-- Coachs -->
            <a
                href="{{ route('coachs') }}"
                class="
                    border-b border-zinc-900 py-4
                    text-sm font-semibold uppercase
                    transition hover:text-red-500
                "
            >
                Coachs
            </a>


            <!-- Blog -->
            <a
                href="{{ route('blog') }}"
                class="
                    border-b border-zinc-900 py-4
                    text-sm font-semibold uppercase
                    transition hover:text-red-500
                "
            >
                Blog
            </a>


            <!-- Humanitaire -->
            <a
                href="{{ route('humanitaire') }}"
                class="
                    border-b border-zinc-900 py-4
                    text-sm font-semibold uppercase
                    transition hover:text-red-500
                "
            >
                Humanitaire
            </a>


            <!-- Abonnements -->
            <a
                href="#"
                class="
                    border-b border-zinc-900 py-4
                    text-sm font-semibold uppercase
                    transition hover:text-red-500
                "
            >
                Abonnements
            </a>


            <!-- Contact -->
            <a
                href="#"
                class="
                    py-4
                    text-sm font-semibold uppercase
                    transition hover:text-red-500
                "
            >
                Contact
            </a>


            <!-- Bouton inscription mobile -->
            <a
                href="#"
                class="
                    mt-5
                    flex
                    items-center
                    justify-center
                    rounded-md
                    bg-red-600
                    px-5
                    py-4
                    text-sm
                    font-bold
                    uppercase
                    transition
                    hover:bg-red-700
                "
            >
                S'inscrire
            </a>

        </nav>

    </div>

</header>