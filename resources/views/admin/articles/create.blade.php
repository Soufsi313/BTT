@extends('layouts.app')


@section('title', 'Nouvel article - Administration BTT')


@section(
    'meta_description',
    'Création d’un nouvel article du blog Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         ESPACE ADMINISTRATION - CRÉATION D'UN ARTICLE
         ========================================================= -->

    <section class="min-h-screen bg-white text-zinc-900">

        <!-- =====================================================
             STYLES SPÉCIFIQUES À L'ÉDITEUR QUILL
             =====================================================
             Quill possède son propre CSS principal.

             Ces règles complètent simplement son apparence afin
             de mieux l'intégrer à l'administration BTT.
             ===================================================== -->
        <style>
            /* -----------------------------------------------------
               ZONE PRINCIPALE DE L'ÉDITEUR
               ----------------------------------------------------- */
            #article-editor {
                min-height: 420px;
                font-size: 16px;
                line-height: 1.75;
                background: #ffffff;
                color: #18181b;
            }

            #article-editor .ql-editor {
                min-height: 420px;
                padding: 24px;
            }

            /*
             * La barre d'outils peut passer sur plusieurs lignes
             * si l'écran n'est pas suffisamment large.
             */
            .ql-toolbar.ql-snow {
                display: flex;
                flex-wrap: wrap;
                gap: 4px;
                border-color: #d4d4d8;
                background: #fafafa;
            }

            .ql-container.ql-snow {
                border-color: #d4d4d8;
            }

            /*
             * Couleur rouge BTT lorsque la souris passe
             * sur certains boutons de Quill.
             */
            .ql-snow .ql-toolbar button:hover,
            .ql-snow.ql-toolbar button:hover,
            .ql-snow .ql-toolbar button.ql-active,
            .ql-snow.ql-toolbar button.ql-active {
                color: #dc2626;
            }

            .ql-snow .ql-toolbar button:hover .ql-stroke,
            .ql-snow.ql-toolbar button:hover .ql-stroke,
            .ql-snow .ql-toolbar button.ql-active .ql-stroke,
            .ql-snow.ql-toolbar button.ql-active .ql-stroke {
                stroke: #dc2626;
            }

            .ql-snow .ql-toolbar button:hover .ql-fill,
            .ql-snow.ql-toolbar button:hover .ql-fill,
            .ql-snow .ql-toolbar button.ql-active .ql-fill,
            .ql-snow.ql-toolbar button.ql-active .ql-fill {
                fill: #dc2626;
            }

            /* -----------------------------------------------------
               POLICES DISPONIBLES DANS L'ÉDITEUR
               ----------------------------------------------------- */

            .ql-font-arial {
                font-family: Arial, sans-serif;
            }

            .ql-font-georgia {
                font-family: Georgia, serif;
            }

            .ql-font-times-new-roman {
                font-family: "Times New Roman", Times, serif;
            }

            .ql-font-verdana {
                font-family: Verdana, sans-serif;
            }

            .ql-font-courier-new {
                font-family: "Courier New", Courier, monospace;
            }

            /* -----------------------------------------------------
               NOMS AFFICHÉS DANS LE MENU DES POLICES
               ----------------------------------------------------- */

            .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="arial"]::before,
            .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="arial"]::before {
                content: "Arial";
                font-family: Arial, sans-serif;
            }

            .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="georgia"]::before,
            .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="georgia"]::before {
                content: "Georgia";
                font-family: Georgia, serif;
            }

            .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="times-new-roman"]::before,
            .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="times-new-roman"]::before {
                content: "Times New Roman";
                font-family: "Times New Roman", Times, serif;
            }

            .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="verdana"]::before,
            .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="verdana"]::before {
                content: "Verdana";
                font-family: Verdana, sans-serif;
            }

            .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="courier-new"]::before,
            .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="courier-new"]::before {
                content: "Courier New";
                font-family: "Courier New", Courier, monospace;
            }

            /*
             * Largeur du menu des polices afin que
             * "Times New Roman" ne soit pas coupé.
             */
            .ql-snow .ql-picker.ql-font {
                width: 150px;
            }

            /*
             * Le menu déroulant passe au-dessus des autres
             * éléments de l'administration.
             */
            .ql-snow .ql-picker-options {
                z-index: 50;
            }
        </style>


        <div class="flex min-h-screen">

            <!-- =================================================
                 BARRE LATÉRALE ADMIN
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

                        <!-- =====================================
                             TABLEAU DE BORD
                             ===================================== -->
                        <a
                            href="{{ route('admin.dashboard') }}"
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
                            Tableau de bord
                        </a>


                        <!-- =====================================
                             ADHÉRENTS
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
                             CALENDRIER
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
                             PAGE ACTIVE
                             ===================================== -->
                        <a
                            href="{{ route('admin.articles.index') }}"
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
                            Articles
                        </a>


                        <!-- =====================================
                             PRODUITS
                             PAS ENCORE DÉVELOPPÉ
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
                             ===================================== -->
                        <a
                            href="{{ route('admin.messages.index') }}"
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
                            Messages
                        </a>


                        <!-- =====================================
                             ADMINISTRATEURS
                             SUPER ADMIN UNIQUEMENT
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
            <div class="min-w-0 flex-1">

                <!-- =============================================
                     EN-TÊTE
                     ============================================= -->
                <header
                    class="
                        border-b
                        border-zinc-200
                        bg-white
                        px-6
                        py-6
                        lg:px-10
                    "
                >

                    <div
                        class="
                            flex
                            flex-col
                            gap-5
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
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
                                Blog BTT
                            </p>

                            <h1
                                class="
                                    mt-2
                                    text-3xl
                                    font-black
                                    uppercase
                                    tracking-tight
                                    text-zinc-900
                                    sm:text-4xl
                                "
                            >
                                Nouvel article
                            </h1>

                            <p
                                class="
                                    mt-3
                                    max-w-2xl
                                    text-sm
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                Créez une nouvelle actualité pour le blog
                                Brussels Top Team.
                            </p>

                        </div>


                        <!-- =====================================
                             RETOUR À LA LISTE
                             ===================================== -->
                        <a
                            href="{{ route('admin.articles.index') }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-md
                                border
                                border-zinc-300
                                bg-white
                                px-5
                                py-3
                                text-sm
                                font-black
                                text-zinc-700
                                transition
                                hover:border-zinc-400
                                hover:bg-zinc-50
                            "
                        >
                            ← Retour aux articles
                        </a>

                    </div>

                </header>


                <!-- =============================================
                     CONTENU
                     ============================================= -->
                <main class="bg-white px-6 py-8 lg:px-10 lg:py-10">

                    <div class="mx-auto max-w-5xl">


                        <!-- =====================================
                             ERREURS DE VALIDATION
                             ===================================== -->
                        @if ($errors->any())

                            <div
                                class="
                                    mb-8
                                    rounded-md
                                    border
                                    border-red-200
                                    bg-red-50
                                    px-5
                                    py-4
                                "
                            >

                                <p class="font-black text-red-700">
                                    Le formulaire contient une ou plusieurs erreurs.
                                </p>

                                <ul
                                    class="
                                        mt-3
                                        list-disc
                                        space-y-1
                                        pl-5
                                        text-sm
                                        text-red-700
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


                        <!-- =====================================
                             FORMULAIRE
                             =====================================
                             L'identifiant article-form est utilisé
                             par resources/js/app.js afin de
                             synchroniser Quill avant l'envoi.

                             multipart/form-data reste indispensable
                             pour l'envoi de la bannière.
                             ===================================== -->
                        <form
                            id="article-form"
                            action="{{ route('admin.articles.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="space-y-8"
                        >

                            @csrf


                            <!-- =================================
                                 INFORMATIONS PRINCIPALES
                                 ================================= -->
                            <section
                                class="
                                    rounded-lg
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                    sm:p-8
                                "
                            >

                                <div class="border-b border-zinc-200 pb-5">

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-[0.25em]
                                            text-red-600
                                        "
                                    >
                                        Informations
                                    </p>

                                    <h2
                                        class="
                                            mt-2
                                            text-xl
                                            font-black
                                            text-zinc-900
                                        "
                                    >
                                        Informations principales
                                    </h2>

                                    <p class="mt-2 text-sm text-zinc-500">
                                        Définissez le titre, la catégorie et
                                        le résumé de l'article.
                                    </p>

                                </div>


                                <div class="mt-6 space-y-6">

                                    <!-- =========================
                                         TITRE
                                         ========================= -->
                                    <div>

                                        <label
                                            for="title"
                                            class="
                                                block
                                                text-sm
                                                font-black
                                                text-zinc-800
                                            "
                                        >
                                            Titre de l'article
                                            <span class="text-red-600">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="title"
                                            name="title"
                                            value="{{ old('title') }}"
                                            maxlength="255"
                                            required
                                            class="
                                                mt-2
                                                w-full
                                                rounded-md
                                                border
                                                border-zinc-300
                                                bg-white
                                                px-4
                                                py-3
                                                text-zinc-900
                                                outline-none
                                                transition
                                                placeholder:text-zinc-400
                                                focus:border-red-600
                                                focus:ring-2
                                                focus:ring-red-600/20
                                            "
                                            placeholder="Ex. Brussels Top Team au tournoi de Bruxelles"
                                        >

                                    </div>


                                    <!-- =========================
                                         CATÉGORIE
                                         ========================= -->
                                    <div>

                                        <label
                                            for="category"
                                            class="
                                                block
                                                text-sm
                                                font-black
                                                text-zinc-800
                                            "
                                        >
                                            Catégorie
                                            <span class="text-red-600">*</span>
                                        </label>

                                        <select
                                            id="category"
                                            name="category"
                                            required
                                            class="
                                                mt-2
                                                w-full
                                                rounded-md
                                                border
                                                border-zinc-300
                                                bg-white
                                                px-4
                                                py-3
                                                text-zinc-900
                                                outline-none
                                                transition
                                                focus:border-red-600
                                                focus:ring-2
                                                focus:ring-red-600/20
                                            "
                                        >

                                            <option value="">
                                                Sélectionner une catégorie
                                            </option>

                                            <option
                                                value="Actualité"
                                                @selected(old('category') === 'Actualité')
                                            >
                                                Actualité
                                            </option>

                                            <option
                                                value="Futsal"
                                                @selected(old('category') === 'Futsal')
                                            >
                                                Futsal
                                            </option>

                                            <option
                                                value="Boxe"
                                                @selected(old('category') === 'Boxe')
                                            >
                                                Boxe
                                            </option>

                                            <option
                                                value="HYROX"
                                                @selected(old('category') === 'HYROX')
                                            >
                                                HYROX
                                            </option>

                                            <option
                                                value="Association"
                                                @selected(old('category') === 'Association')
                                            >
                                                Association
                                            </option>

                                            <option
                                                value="Événement"
                                                @selected(old('category') === 'Événement')
                                            >
                                                Événement
                                            </option>

                                        </select>

                                    </div>


                                    <!-- =========================
                                         RÉSUMÉ
                                         ========================= -->
                                    <div>

                                        <label
                                            for="excerpt"
                                            class="
                                                block
                                                text-sm
                                                font-black
                                                text-zinc-800
                                            "
                                        >
                                            Résumé
                                        </label>

                                        <textarea
                                            id="excerpt"
                                            name="excerpt"
                                            rows="4"
                                            maxlength="1000"
                                            class="
                                                mt-2
                                                w-full
                                                resize-y
                                                rounded-md
                                                border
                                                border-zinc-300
                                                bg-white
                                                px-4
                                                py-3
                                                text-zinc-900
                                                outline-none
                                                transition
                                                placeholder:text-zinc-400
                                                focus:border-red-600
                                                focus:ring-2
                                                focus:ring-red-600/20
                                            "
                                            placeholder="Présentez brièvement l'article..."
                                        >{{ old('excerpt') }}</textarea>

                                        <p class="mt-2 text-xs text-zinc-500">
                                            Ce texte servira notamment à présenter
                                            rapidement l'article dans le Blog.
                                        </p>

                                    </div>

                                </div>

                            </section>


                            <!-- =================================
                                 BANNIÈRE DE L'ARTICLE
                                 ================================= -->
                            <section
                                class="
                                    rounded-lg
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                    sm:p-8
                                "
                            >

                                <div class="border-b border-zinc-200 pb-5">

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-[0.25em]
                                            text-red-600
                                        "
                                    >
                                        Visuel
                                    </p>

                                    <h2
                                        class="
                                            mt-2
                                            text-xl
                                            font-black
                                            text-zinc-900
                                        "
                                    >
                                        Bannière de l'article
                                    </h2>

                                    <p class="mt-2 text-sm text-zinc-500">
                                        Cette image servira de couverture à
                                        l'article dans la bibliothèque du Blog.
                                    </p>

                                </div>


                                <div class="mt-6">

                                    <label
                                        for="banner_image"
                                        class="
                                            block
                                            text-sm
                                            font-black
                                            text-zinc-800
                                        "
                                    >
                                        Image de couverture
                                        <span class="text-red-600">*</span>
                                    </label>


                                    <!-- =========================
                                         CHAMP D'ENVOI D'IMAGE
                                         ========================= -->
                                    <div
                                        class="
                                            mt-2
                                            rounded-lg
                                            border
                                            border-dashed
                                            border-zinc-300
                                            bg-zinc-50
                                            p-6
                                        "
                                    >

                                        <input
                                            type="file"
                                            id="banner_image"
                                            name="banner_image"
                                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                            required
                                            class="
                                                block
                                                w-full
                                                text-sm
                                                text-zinc-600
                                                file:mr-4
                                                file:rounded-md
                                                file:border-0
                                                file:bg-zinc-900
                                                file:px-4
                                                file:py-2.5
                                                file:text-sm
                                                file:font-black
                                                file:text-white
                                                file:transition
                                                hover:file:bg-red-600
                                            "
                                        >

                                        <div
                                            class="
                                                mt-4
                                                space-y-1
                                                text-xs
                                                text-zinc-500
                                            "
                                        >

                                            <p>
                                                Formats acceptés :
                                                JPG, JPEG, PNG et WEBP.
                                            </p>

                                            <p>
                                                Taille maximale :
                                                5 Mo.
                                            </p>

                                            <p>
                                                Pour un meilleur rendu dans le Blog,
                                                privilégiez une image horizontale
                                                de bonne qualité.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </section>


                            <!-- =================================
                                 CONTENU DE L'ARTICLE
                                 ================================= -->
                            <section
                                class="
                                    rounded-lg
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                    sm:p-8
                                "
                            >

                                <div class="border-b border-zinc-200 pb-5">

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-[0.25em]
                                            text-red-600
                                        "
                                    >
                                        Rédaction
                                    </p>

                                    <h2
                                        class="
                                            mt-2
                                            text-xl
                                            font-black
                                            text-zinc-900
                                        "
                                    >
                                        Contenu de l'article
                                    </h2>

                                    <p class="mt-2 text-sm leading-6 text-zinc-500">
                                        Rédigez et mettez en forme votre article
                                        comme dans un véritable traitement de texte.
                                    </p>

                                </div>


                                <div class="mt-6">

                                    <label
                                        for="article-editor"
                                        class="
                                            block
                                            text-sm
                                            font-black
                                            text-zinc-800
                                        "
                                    >
                                        Texte de l'article
                                        <span class="text-red-600">*</span>
                                    </label>


                                    <!-- =========================
                                         CHAMP ENVOYÉ À LARAVEL
                                         =========================
                                         Quill n'est pas directement un
                                         champ de formulaire HTML.

                                         Ce textarea caché contient donc
                                         le HTML généré par l'éditeur.

                                         resources/js/app.js le met à jour
                                         automatiquement.
                                         ========================= -->
                                    <textarea
                                        id="article-content"
                                        name="content"
                                        class="hidden"
                                    >{{ old('content') }}</textarea>


                                    <!-- =========================
                                         ÉDITEUR QUILL
                                         =========================
                                         La barre d'outils est générée
                                         automatiquement par app.js.

                                         Elle permet notamment :
                                         - titres ;
                                         - polices ;
                                         - tailles ;
                                         - gras ;
                                         - italique ;
                                         - souligné ;
                                         - barré ;
                                         - couleurs ;
                                         - surlignage ;
                                         - alignements ;
                                         - listes ;
                                         - indentation ;
                                         - citation ;
                                         - liens.
                                         ========================= -->
                                    <div
                                        class="
                                            mt-2
                                            overflow-visible
                                            rounded-md
                                        "
                                    >

                                        <div id="article-editor"></div>

                                    </div>


                                    <!-- =========================
                                         AIDE À LA RÉDACTION
                                         ========================= -->
                                    <div
                                        class="
                                            mt-4
                                            rounded-md
                                            border
                                            border-zinc-200
                                            bg-zinc-50
                                            px-4
                                            py-4
                                        "
                                    >

                                        <p
                                            class="
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-700
                                            "
                                        >
                                            Mise en forme disponible
                                        </p>

                                        <p
                                            class="
                                                mt-2
                                                text-xs
                                                leading-5
                                                text-zinc-500
                                            "
                                        >
                                            Vous pouvez modifier la police,
                                            la taille, les titres, le gras,
                                            l'italique, le soulignement,
                                            les couleurs, les listes et
                                            l'alignement gauche, centré,
                                            droite ou justifié.
                                        </p>

                                        <p
                                            class="
                                                mt-2
                                                text-xs
                                                leading-5
                                                text-zinc-500
                                            "
                                        >
                                            L'insertion de photos directement
                                            entre les paragraphes sera ajoutée
                                            à l'étape suivante avec un véritable
                                            système d'envoi d'images Laravel.
                                        </p>

                                    </div>

                                </div>

                            </section>


                            <!-- =================================
                                 PUBLICATION
                                 ================================= -->
                            <section
                                class="
                                    rounded-lg
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-6
                                    sm:p-8
                                "
                            >

                                <div class="border-b border-zinc-200 pb-5">

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-[0.25em]
                                            text-red-600
                                        "
                                    >
                                        Publication
                                    </p>

                                    <h2
                                        class="
                                            mt-2
                                            text-xl
                                            font-black
                                            text-zinc-900
                                        "
                                    >
                                        Visibilité de l'article
                                    </h2>

                                </div>


                                <div
                                    class="
                                        mt-6
                                        grid
                                        gap-6
                                        lg:grid-cols-2
                                    "
                                >

                                    <!-- =========================
                                         STATUT
                                         ========================= -->
                                    <div>

                                        <label
                                            for="status"
                                            class="
                                                block
                                                text-sm
                                                font-black
                                                text-zinc-800
                                            "
                                        >
                                            Statut
                                            <span class="text-red-600">*</span>
                                        </label>

                                        <select
                                            id="status"
                                            name="status"
                                            required
                                            class="
                                                mt-2
                                                w-full
                                                rounded-md
                                                border
                                                border-zinc-300
                                                bg-white
                                                px-4
                                                py-3
                                                text-zinc-900
                                                outline-none
                                                transition
                                                focus:border-red-600
                                                focus:ring-2
                                                focus:ring-red-600/20
                                            "
                                        >

                                            <option
                                                value="draft"
                                                @selected(old('status', 'draft') === 'draft')
                                            >
                                                Brouillon
                                            </option>

                                            <option
                                                value="published"
                                                @selected(old('status') === 'published')
                                            >
                                                Publié
                                            </option>

                                        </select>

                                        <p class="mt-2 text-xs text-zinc-500">
                                            Un brouillon n'apparaîtra pas dans
                                            le Blog public.
                                        </p>

                                    </div>


                                    <!-- =========================
                                         MISE EN AVANT
                                         ========================= -->
                                    <div>

                                        <p
                                            class="
                                                block
                                                text-sm
                                                font-black
                                                text-zinc-800
                                            "
                                        >
                                            Mise en avant
                                        </p>

                                        <label
                                            class="
                                                mt-2
                                                flex
                                                cursor-pointer
                                                items-start
                                                gap-3
                                                rounded-md
                                                border
                                                border-zinc-300
                                                bg-zinc-50
                                                px-4
                                                py-4
                                            "
                                        >

                                            <input
                                                type="checkbox"
                                                name="is_featured"
                                                value="1"
                                                @checked(old('is_featured'))
                                                class="
                                                    mt-1
                                                    h-4
                                                    w-4
                                                    rounded
                                                    border-zinc-300
                                                    text-red-600
                                                    focus:ring-red-600
                                                "
                                            >

                                            <span>

                                                <span
                                                    class="
                                                        block
                                                        text-sm
                                                        font-bold
                                                        text-zinc-800
                                                    "
                                                >
                                                    Mettre cet article en avant
                                                </span>

                                                <span
                                                    class="
                                                        mt-1
                                                        block
                                                        text-xs
                                                        leading-5
                                                        text-zinc-500
                                                    "
                                                >
                                                    Cette option permet d'accorder
                                                    une place plus importante à
                                                    l'article dans le Blog.
                                                </span>

                                            </span>

                                        </label>

                                    </div>

                                </div>

                            </section>


                            <!-- =================================
                                 ACTIONS
                                 ================================= -->
                            <div
                                class="
                                    flex
                                    flex-col-reverse
                                    gap-3
                                    border-t
                                    border-zinc-200
                                    pt-6
                                    sm:flex-row
                                    sm:justify-end
                                "
                            >

                                <!-- ANNULER -->
                                <a
                                    href="{{ route('admin.articles.index') }}"
                                    class="
                                        inline-flex
                                        items-center
                                        justify-center
                                        rounded-md
                                        border
                                        border-zinc-300
                                        bg-white
                                        px-6
                                        py-3
                                        text-sm
                                        font-black
                                        text-zinc-700
                                        transition
                                        hover:bg-zinc-50
                                    "
                                >
                                    Annuler
                                </a>


                                <!-- ENREGISTRER -->
                                <button
                                    type="submit"
                                    class="
                                        inline-flex
                                        items-center
                                        justify-center
                                        rounded-md
                                        bg-red-600
                                        px-6
                                        py-3
                                        text-sm
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-white
                                        transition
                                        hover:bg-red-700
                                    "
                                >
                                    Enregistrer l'article
                                </button>

                            </div>

                        </form>

                    </div>

                </main>

            </div>

        </div>

    </section>

@endsection