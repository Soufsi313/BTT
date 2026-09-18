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


            {{--
            |--------------------------------------------------------------------------
            | BARRE LATÉRALE ADMINISTRATION
            |--------------------------------------------------------------------------
            |
            | La barre latérale n'est désormais plus dupliquée dans
            | cette page.
            |
            | Elle est centralisée dans :
            |
            | resources/views/admin/partials/sidebar.blade.php
            |
            | Toutes les pages de l'administration pourront donc utiliser
            | exactement le même menu.
            |
            | Le lien actif est automatiquement déterminé dans le partial
            | grâce à la route actuellement visitée.
            |
            |--------------------------------------------------------------------------
            --}}

            @include('admin.partials.sidebar')


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


                    <!-- =========================================
                         ADMINISTRATEUR CONNECTÉ
                         ========================================= -->
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
                         STATISTIQUES PRINCIPALES
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


                            <!-- =====================================
                                 STATISTIQUE ADHÉRENTS
                                 ===================================== -->
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
                                    {{ number_format(
                                        $totalMembersCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p
                                    class="
                                        mt-2
                                        text-xs
                                        font-bold
                                        text-zinc-500
                                    "
                                >
                                    {{ number_format(
                                        $newMembersThisMonthCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                    nouveau(x) ce mois-ci
                                </p>

                            </div>


                            <!-- =====================================
                                 STATISTIQUE COURS
                                 ===================================== -->
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
                                    {{ number_format(
                                        $totalCoursesCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p
                                    class="
                                        mt-2
                                        text-xs
                                        font-bold
                                        text-zinc-500
                                    "
                                >
                                    {{ number_format(
                                        $activeCoursesCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                    actif(s)
                                </p>

                            </div>


                            <!-- =====================================
                                 STATISTIQUE ARTICLES
                                 ===================================== -->
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
                                    {{ number_format(
                                        $totalArticlesCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p
                                    class="
                                        mt-2
                                        text-xs
                                        font-bold
                                        text-zinc-500
                                    "
                                >
                                    {{ number_format(
                                        $publishedArticlesCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                    publié(s)
                                </p>

                            </div>


                            <!-- =====================================
                                 STATISTIQUE MESSAGES
                                 ===================================== -->
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
                                    {{ number_format(
                                        $totalConversationsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p
                                    class="
                                        mt-2
                                        text-xs
                                        font-bold
                                        {{ $unreadConversationsCount > 0
                                            ? 'text-red-600'
                                            : 'text-zinc-500' }}
                                    "
                                >
                                    {{ number_format(
                                        $unreadConversationsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                    avec nouveau(x) message(s)
                                </p>

                            </div>

                        </div>

                    </section>


                    <!-- =========================================
                         GRAPHIQUES DYNAMIQUES
                         =========================================
                         Les quatre graphiques ci-dessous utilisent
                         exclusivement les données calculées par Laravel.

                         Chart.js récupère ces valeurs depuis les attributs
                         data-* présents directement sur les canvas.
                         ========================================= -->
                    <section class="mt-10">

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
                                Statistiques
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
                                Vue d'ensemble
                            </h2>


                            <p
                                class="
                                    mt-3
                                    max-w-3xl
                                    text-sm
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                Les graphiques sont automatiquement mis à jour
                                à partir des données enregistrées dans BTT.
                            </p>

                        </div>


                        <div
                            class="
                                mt-6
                                grid
                                gap-6
                                xl:grid-cols-2
                            "
                        >


                            <!-- =====================================
                                 GRAPHIQUE :
                                 ÉVOLUTION DES INSCRIPTIONS
                                 ===================================== -->
                            <article
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-red-600
                                        "
                                    >
                                        Adhérents
                                    </p>

                                    <h3
                                        class="
                                            mt-2
                                            text-lg
                                            font-black
                                            uppercase
                                            text-zinc-900
                                        "
                                    >
                                        Nouvelles inscriptions
                                    </h3>

                                    <p
                                        class="
                                            mt-2
                                            text-sm
                                            text-zinc-500
                                        "
                                    >
                                        Évolution sur les six derniers mois.
                                    </p>

                                </div>


                                <div class="mt-6 h-72">

                                    <canvas
                                        id="members-evolution-chart"
                                        data-labels='@json(
                                            $membersMonthlyEvolution
                                                ->pluck("label")
                                                ->values()
                                        )'
                                        data-values='@json(
                                            $membersMonthlyEvolution
                                                ->pluck("count")
                                                ->values()
                                        )'
                                    ></canvas>

                                </div>

                            </article>


                            <!-- =====================================
                                 GRAPHIQUE :
                                 ACTIFS / ARCHIVÉS
                                 ===================================== -->
                            <article
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-red-600
                                        "
                                    >
                                        Adhérents
                                    </p>

                                    <h3
                                        class="
                                            mt-2
                                            text-lg
                                            font-black
                                            uppercase
                                            text-zinc-900
                                        "
                                    >
                                        État des comptes
                                    </h3>

                                    <p
                                        class="
                                            mt-2
                                            text-sm
                                            text-zinc-500
                                        "
                                    >
                                        Répartition entre les comptes actifs
                                        et les comptes archivés.
                                    </p>

                                </div>


                                <div class="mt-6 h-72">

                                    <canvas
                                        id="members-status-chart"
                                        data-active="{{ $activeMembersCount }}"
                                        data-archived="{{ $archivedMembersCount }}"
                                    ></canvas>

                                </div>

                            </article>


                            <!-- =====================================
                                 GRAPHIQUE :
                                 ÉTAT DES COURS
                                 ===================================== -->
                            <article
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-red-600
                                        "
                                    >
                                        Calendrier
                                    </p>

                                    <h3
                                        class="
                                            mt-2
                                            text-lg
                                            font-black
                                            uppercase
                                            text-zinc-900
                                        "
                                    >
                                        État des cours
                                    </h3>

                                    <p
                                        class="
                                            mt-2
                                            text-sm
                                            text-zinc-500
                                        "
                                    >
                                        Cours actifs, inactifs, terminés
                                        et supprimés.
                                    </p>

                                </div>


                                <div class="mt-6 h-72">

                                    <canvas
                                        id="courses-status-chart"
                                        data-active="{{ $activeCoursesCount }}"
                                        data-inactive="{{ $inactiveCoursesCount }}"
                                        data-completed="{{ $completedCoursesCount }}"
                                        data-deleted="{{ $deletedCoursesCount }}"
                                    ></canvas>

                                </div>

                            </article>


                            <!-- =====================================
                                 GRAPHIQUE :
                                 ACTIVITÉ DU SITE
                                 ===================================== -->
                            <article
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                "
                            >

                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-red-600
                                        "
                                    >
                                        Activité
                                    </p>

                                    <h3
                                        class="
                                            mt-2
                                            text-lg
                                            font-black
                                            uppercase
                                            text-zinc-900
                                        "
                                    >
                                        Activité du site
                                    </h3>

                                    <p
                                        class="
                                            mt-2
                                            text-sm
                                            text-zinc-500
                                        "
                                    >
                                        Contenu, modération et messagerie.
                                    </p>

                                </div>


                                <div class="mt-6 h-72">

                                    <canvas
                                        id="website-activity-chart"
                                        data-published-articles="{{ $publishedArticlesCount }}"
                                        data-draft-articles="{{ $draftArticlesCount }}"
                                        data-comments="{{ $totalCommentsCount }}"
                                        data-pending-reports="{{ $pendingReportsCount }}"
                                        data-conversations="{{ $totalConversationsCount }}"
                                        data-unread-conversations="{{ $unreadConversationsCount }}"
                                    ></canvas>

                                </div>

                            </article>

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


                            <!-- =====================================
                                 AJOUTER UN COURS
                                 =====================================
                                 Cette zone reste inchangée pour l'instant.
                                 Le calendrier dispose déjà de sa propre
                                 section dans la navigation admin.
                                 ===================================== -->
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


                            <!-- =====================================
                                 CONSULTER LES MESSAGES
                                 =====================================
                                 La messagerie étant maintenant fonctionnelle,
                                 cette action devient directement accessible
                                 depuis le dashboard.
                                 ===================================== -->
                            <a
                                href="{{ route('admin.messages.index') }}"
                                class="
                                    group
                                    border
                                    border-zinc-200
                                    bg-white
                                    px-5
                                    py-5
                                    text-left
                                    transition
                                    hover:border-red-600
                                    hover:bg-red-50
                                "
                            >

                                <div
                                    class="
                                        flex
                                        items-start
                                        justify-between
                                        gap-4
                                    "
                                >

                                    <div>

                                        <p
                                            class="
                                                text-sm
                                                font-black
                                                uppercase
                                                text-zinc-900
                                                transition
                                                group-hover:text-red-600
                                            "
                                        >
                                            Consulter les messages
                                        </p>

                                        <p
                                            class="
                                                mt-2
                                                text-sm
                                                leading-6
                                                text-zinc-500
                                            "
                                        >
                                            Consultez les demandes reçues et
                                            répondez aux visiteurs et adhérents.
                                        </p>

                                    </div>


                                    <span
                                        class="
                                            text-lg
                                            font-black
                                            text-red-600
                                            transition-transform
                                            group-hover:translate-x-1
                                        "
                                    >
                                        →
                                    </span>

                                </div>

                            </a>


                            <!-- =====================================
                                 PUBLIER UN ARTICLE
                                 Fonctionnalité prochainement.
                                 ===================================== -->
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


                            <!-- =====================================
                                 AJOUTER UN PRODUIT
                                 Fonctionnalité prochainement.
                                 ===================================== -->
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


    {{--
    |--------------------------------------------------------------------------
    | JAVASCRIPT DU DASHBOARD
    |--------------------------------------------------------------------------
    |
    | Ce bundle Vite est chargé uniquement sur cette page.
    |
    | Il importe Chart.js et initialise les quatre graphiques présents
    | ci-dessus.
    |
    | Le fichier resources/js/app.js reste totalement inchangé.
    |
    --}}

    @vite('resources/js/admin-dashboard.js')

@endsection