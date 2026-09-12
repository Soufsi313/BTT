@extends('layouts.app')


@section('title', 'Administration - Brussels Top Team')


@section(
    'meta_description',
    'Espace d’administration Brussels Top Team.'
)


@section('content')


    <!-- =========================================================
         ESPACE ADMINISTRATION
         =========================================================
         Cette page constitue le tableau de bord principal
         de l'administration Brussels Top Team.

         L'espace administration utilise volontairement une
         identité visuelle différente du site public :

         - fond blanc
         - navigation claire
         - accents rouges
         - accès rapide aux principales fonctionnalités
         ========================================================= -->
    <section class="min-h-screen bg-white text-zinc-900">

        <div class="flex min-h-screen">


            <!-- =================================================
                 BARRE LATÉRALE ADMINISTRATION
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
                     IDENTITÉ DE L'ADMINISTRATEUR
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
                     NAVIGATION ADMINISTRATION
                     ============================================= -->
                <nav class="flex-1 px-4 py-6">

                    <div class="space-y-1">


                        <!-- =====================================
                             TABLEAU DE BORD
                             ===================================== -->
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



                        <!-- =====================================
                             GESTION DES ADHÉRENTS
                             ===================================== -->
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



                        <!-- =====================================
                             GESTION DU CALENDRIER
                             ===================================== -->
                        <a
                            href="{{ route('admin.courses.index') }}"
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
                            Calendrier
                        </a>



                        <!-- =====================================
                             ARTICLES
                             =====================================
                             Cette fonctionnalité sera développée
                             lorsque nous créerons le système Blog.
                             ===================================== -->
                        <span
                            class="
                                block
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-400
                            "
                        >
                            Articles
                        </span>



                        <!-- =====================================
                             PRODUITS
                             =====================================
                             La boutique sera développée plus tard.
                             ===================================== -->
                        <span
                            class="
                                block
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-400
                            "
                        >
                            Produits
                        </span>



                        <!-- =====================================
                             MESSAGES
                             =====================================
                             La structure de la messagerie existe
                             maintenant dans la base de données.

                             La boîte de réception administrateur
                             sera notre prochaine étape.
                             ===================================== -->
                        <span
                            class="
                                block
                                rounded-md
                                px-4
                                py-3
                                text-sm
                                font-bold
                                text-zinc-400
                            "
                        >
                            Messages
                        </span>



                        <!-- =====================================
                             GESTION DES ADMINISTRATEURS
                             =====================================
                             Cette section est volontairement
                             réservée au Super Admin.
                             ===================================== -->
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
                     RETOUR À L'ESPACE MEMBRE
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
            <div class="min-w-0 flex-1">


                <!-- =============================================
                     BARRE SUPÉRIEURE
                     ============================================= -->
                <header
                    class="
                        flex
                        flex-col
                        gap-4
                        border-b
                        border-zinc-200
                        px-6
                        py-5
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                        lg:px-10
                    "
                >


                    <!-- =========================================
                         TITRE DE LA PAGE
                         ========================================= -->
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
                         UTILISATEUR CONNECTÉ
                         ========================================= -->
                    <div class="sm:text-right">

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
                     CONTENU DU TABLEAU DE BORD
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
                            Gérez rapidement les principales sections
                            du site Brussels Top Team depuis votre espace
                            d'administration.
                        </p>

                    </section>



                    <!-- =========================================
                         ACCÈS RAPIDES MOBILE
                         =========================================
                         La sidebar étant masquée sur petit écran,
                         nous conservons ici les accès essentiels.
                         ========================================= -->
                    <section class="mt-8 lg:hidden">

                        <div class="flex flex-wrap gap-3">

                            <a
                                href="{{ route('admin.members.index') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    border
                                    border-zinc-300
                                    px-4
                                    py-2.5
                                    text-sm
                                    font-bold
                                    text-zinc-700
                                    transition
                                    hover:border-red-600
                                    hover:text-red-600
                                "
                            >
                                Adhérents
                            </a>


                            <a
                                href="{{ route('admin.courses.index') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    border
                                    border-zinc-300
                                    px-4
                                    py-2.5
                                    text-sm
                                    font-bold
                                    text-zinc-700
                                    transition
                                    hover:border-red-600
                                    hover:text-red-600
                                "
                            >
                                Calendrier
                            </a>


                            @if (auth()->user()->isSuperAdmin())

                                <a
                                    href="{{ route('admin.administrators.index') }}"
                                    class="
                                        inline-flex
                                        items-center
                                        justify-center
                                        rounded-md
                                        border
                                        border-zinc-300
                                        px-4
                                        py-2.5
                                        text-sm
                                        font-bold
                                        text-zinc-700
                                        transition
                                        hover:border-red-600
                                        hover:text-red-600
                                    "
                                >
                                    Administrateurs
                                </a>

                            @endif


                            <a
                                href="{{ route('member.dashboard') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-md
                                    border
                                    border-zinc-300
                                    px-4
                                    py-2.5
                                    text-sm
                                    font-bold
                                    text-zinc-700
                                    transition
                                    hover:border-red-600
                                    hover:text-red-600
                                "
                            >
                                Retour au site
                            </a>

                        </div>

                    </section>



                    <!-- =========================================
                         STATISTIQUES
                         =========================================
                         Les compteurs dynamiques seront ajoutés
                         progressivement lorsque le dashboard sera
                         relié à ses données.
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
                                    -
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
                                    -
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
                                    -
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


                            <!-- =====================================
                                 AJOUTER UN COURS
                                 =====================================
                                 Le calendrier étant désormais
                                 fonctionnel, ce bouton est actif.
                                 ===================================== -->
                            <a
                                href="{{ route('admin.courses.create') }}"
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
                                    text-left
                                    transition
                                    hover:border-red-600
                                    hover:bg-white
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


                                <p class="mt-2 text-sm leading-6 text-zinc-500">
                                    Ajoutez rapidement un nouvel entraînement
                                    au calendrier Brussels Top Team.
                                </p>

                            </a>



                            <!-- =====================================
                                 GÉRER LES ADHÉRENTS
                                 ===================================== -->
                            <a
                                href="{{ route('admin.members.index') }}"
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
                                    text-left
                                    transition
                                    hover:border-red-600
                                    hover:bg-white
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
                                    Gérer les adhérents
                                </p>


                                <p class="mt-2 text-sm leading-6 text-zinc-500">
                                    Consultez et gérez les comptes adhérents
                                    accessibles à votre niveau d'administration.
                                </p>

                            </a>



                            <!-- =====================================
                                 MESSAGERIE
                                 =====================================
                                 La réception des messages sera
                                 activée lors de notre prochaine étape.
                                 ===================================== -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
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
                                    Consulter les messages
                                </p>


                                <p class="mt-2 text-sm leading-6 text-zinc-500">
                                    La boîte de réception de l'administration
                                    sera disponible prochainement.
                                </p>

                            </div>



                            <!-- =====================================
                                 PUBLIER UN ARTICLE
                                 ===================================== -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
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


                                <p class="mt-2 text-sm leading-6 text-zinc-500">
                                    La gestion du blog sera développée
                                    dans une prochaine étape.
                                </p>

                            </div>



                            <!-- =====================================
                                 AJOUTER UN PRODUIT
                                 ===================================== -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-5
                                    py-5
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


                                <p class="mt-2 text-sm leading-6 text-zinc-500">
                                    La gestion de la boutique sera développée
                                    ultérieurement.
                                </p>

                            </div>



                            <!-- =====================================
                                 GÉRER LES ADMINISTRATEURS
                                 =====================================
                                 Uniquement visible pour le Super Admin.
                                 ===================================== -->
                            @if (auth()->user()->isSuperAdmin())

                                <a
                                    href="{{ route('admin.administrators.index') }}"
                                    class="
                                        border
                                        border-zinc-200
                                        bg-zinc-50
                                        px-5
                                        py-5
                                        text-left
                                        transition
                                        hover:border-red-600
                                        hover:bg-white
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
                                        Gérer les administrateurs
                                    </p>


                                    <p class="mt-2 text-sm leading-6 text-zinc-500">
                                        Gérez les comptes disposant des droits
                                        d'administration Brussels Top Team.
                                    </p>

                                </a>

                            @endif

                        </div>

                    </section>

                </main>

            </div>

        </div>

    </section>


@endsection