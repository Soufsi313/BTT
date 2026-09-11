@extends('layouts.app')


@section('title', 'Administration - Brussels Top Team')


@section(
    'meta_description',
    'Espace d’administration Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         ESPACE ADMINISTRATION
         ========================================================= -->
    <section class="min-h-screen bg-white text-zinc-900">

        <div class="flex min-h-screen">


            <!-- =================================================
                 BARRE LATÉRALE
                 ================================================= -->
            <aside
                class="
                    hidden
                    w-64
                    shrink-0
                    border-r
                    border-zinc-200
                    bg-zinc-50
                    lg:flex
                    lg:flex-col
                "
            >

                <!-- =============================================
                     IDENTITÉ ADMIN
                     ============================================= -->
                <div class="border-b border-zinc-200 px-6 py-6">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.3em]
                            text-red-600
                        "
                    >
                        BTT Admin
                    </p>

                    <p class="mt-2 text-sm font-bold text-zinc-900">
                        {{ auth()->user()->pseudo }}
                    </p>

                    <p
                        class="
                            mt-1
                            text-xs
                            font-bold
                            uppercase
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        @if (auth()->user()->isSuperAdmin())
                            Super Admin
                        @else
                            Admin
                        @endif
                    </p>

                </div>


                <!-- =============================================
                     NAVIGATION ADMIN
                     ============================================= -->
                <nav class="flex-1 px-4 py-6">

                    <div class="space-y-1">


                        <!-- =========================================
                             TABLEAU DE BORD
                             ========================================= -->
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="
                                flex
                                items-center
                                rounded-md
                                bg-red-600
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-white
                            "
                        >
                            Tableau de bord
                        </a>


                        <!-- =========================================
                             GESTION DES ADHÉRENTS
                             ========================================= -->
                        <a
                            href="{{ route('admin.members.index') }}"
                            class="
                                flex
                                items-center
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-600
                                transition
                                hover:bg-zinc-200
                                hover:text-red-600
                            "
                        >
                            Adhérents
                        </a>


                        <!-- =========================================
                             CALENDRIER
                             ========================================= -->
                        <span
                            class="
                                block
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-500
                            "
                        >
                            Calendrier
                        </span>


                        <!-- =========================================
                             ARTICLES
                             ========================================= -->
                        <span
                            class="
                                block
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-500
                            "
                        >
                            Articles
                        </span>


                        <!-- =========================================
                             PRODUITS
                             ========================================= -->
                        <span
                            class="
                                block
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-500
                            "
                        >
                            Produits
                        </span>


                        <!-- =========================================
                             MESSAGES
                             ========================================= -->
                        <span
                            class="
                                block
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-500
                            "
                        >
                            Messages
                        </span>


                        <!-- =========================================
                             ADMINISTRATEURS
                             SUPER ADMIN UNIQUEMENT
                             ========================================= -->
                        @if (auth()->user()->isSuperAdmin())

                            <a
                                href="{{ route('admin.administrators.index') }}"
                                class="
                                    flex
                                    items-center
                                    rounded-md
                                    px-4
                                    py-3
                                    text-sm
                                    font-bold
                                    text-zinc-600
                                    transition
                                    hover:bg-zinc-200
                                    hover:text-red-600
                                "
                            >
                                Administrateurs
                            </a>

                        @endif

                    </div>

                </nav>


                <!-- =============================================
                     RETOUR AU SITE
                     ============================================= -->
                <div class="border-t border-zinc-200 p-4">

                    <a
                        href="{{ route('member.dashboard') }}"
                        class="
                            block
                            rounded-md
                            px-4
                            py-3
                            text-sm
                            font-bold
                            text-zinc-600
                            transition
                            hover:bg-zinc-200
                            hover:text-zinc-900
                        "
                    >
                        ← Retour au site
                    </a>

                </div>

            </aside>


            <!-- =================================================
                 CONTENU PRINCIPAL
                 ================================================= -->
            <div class="flex-1">


                <!-- =============================================
                     BARRE SUPÉRIEURE
                     ============================================= -->
                <header
                    class="
                        flex
                        items-center
                        justify-between
                        border-b
                        border-zinc-200
                        px-6
                        py-5
                        lg:px-10
                    "
                >

                    <div>

                        <p
                            class="
                                text-xs
                                font-black
                                uppercase
                                tracking-[0.3em]
                                text-red-600
                            "
                        >
                            Administration
                        </p>

                        <h1
                            class="
                                mt-1
                                text-2xl
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Tableau de bord
                        </h1>

                    </div>


                    <div class="text-right">

                        <p class="text-sm font-bold text-zinc-900">
                            {{ auth()->user()->prenom }}
                            {{ auth()->user()->nom }}
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-500
                            "
                        >
                            @if (auth()->user()->isSuperAdmin())
                                Super Admin
                            @else
                                Admin
                            @endif
                        </p>

                    </div>

                </header>


                <!-- =============================================
                     CONTENU DU DASHBOARD
                     ============================================= -->
                <main class="px-6 py-8 lg:px-10 lg:py-10">


                    <!-- =========================================
                         BIENVENUE
                         ========================================= -->
                    <section>

                        <h2
                            class="
                                text-3xl
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Bonjour {{ auth()->user()->prenom }}
                        </h2>


                        <p
                            class="
                                mt-3
                                max-w-2xl
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Gérez rapidement les principales sections du site
                            Brussels Top Team depuis cet espace.
                        </p>

                    </section>


                    <!-- =========================================
                         STATISTIQUES
                         ========================================= -->
                    <section class="mt-10">

                        <div
                            class="
                                grid
                                gap-4
                                sm:grid-cols-2
                                xl:grid-cols-4
                            "
                        >

                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Adhérents
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    -
                                </p>

                            </div>


                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Cours
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    -
                                </p>

                            </div>


                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Articles
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    -
                                </p>

                            </div>


                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Messages
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    -
                                </p>

                            </div>

                        </div>

                    </section>


                    <!-- =========================================
                         ACTIONS RAPIDES
                         ========================================= -->
                    <section class="mt-12">

                        <p
                            class="
                                text-xs
                                font-black
                                uppercase
                                tracking-[0.3em]
                                text-red-600
                            "
                        >
                            Actions rapides
                        </p>


                        <h2
                            class="
                                mt-2
                                text-2xl
                                font-black
                                uppercase
                                text-zinc-900
                            "
                        >
                            Gestion du site
                        </h2>


                        <div
                            class="
                                mt-6
                                grid
                                gap-4
                                md:grid-cols-2
                                xl:grid-cols-3
                            "
                        >

                            <button
                                type="button"
                                disabled
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
                                    text-left
                                    opacity-60
                                "
                            >

                                <p
                                    class="
                                        text-sm
                                        font-black
                                        uppercase
                                        text-zinc-900
                                    "
                                >
                                    Ajouter un cours
                                </p>

                                <p class="mt-2 text-sm text-zinc-500">
                                    Gestion du calendrier prochainement.
                                </p>

                            </button>


                            <button
                                type="button"
                                disabled
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
                                    text-left
                                    opacity-60
                                "
                            >

                                <p
                                    class="
                                        text-sm
                                        font-black
                                        uppercase
                                        text-zinc-900
                                    "
                                >
                                    Publier un article
                                </p>

                                <p class="mt-2 text-sm text-zinc-500">
                                    Gestion du blog prochainement.
                                </p>

                            </button>


                            <button
                                type="button"
                                disabled
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
                                    text-left
                                    opacity-60
                                "
                            >

                                <p
                                    class="
                                        text-sm
                                        font-black
                                        uppercase
                                        text-zinc-900
                                    "
                                >
                                    Ajouter un produit
                                </p>

                                <p class="mt-2 text-sm text-zinc-500">
                                    Gestion de la boutique prochainement.
                                </p>

                            </button>

                        </div>

                    </section>

                </main>

            </div>

        </div>

    </section>

@endsection