<!DOCTYPE html>
<html lang="fr">

<head>

    <!-- =========================================================
         CONFIGURATION GÉNÉRALE
         ========================================================= -->
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <!-- =========================================================
         TOKEN CSRF LARAVEL
         =========================================================
         Ce token permet à notre JavaScript d'envoyer des requêtes
         POST sécurisées à Laravel.

         Il est notamment utilisé par Quill pour envoyer les images
         insérées directement dans le contenu des articles.
         ========================================================= -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    <!-- =========================================================
         CONFIGURATION SEO GLOBALE
         =========================================================
         Le layout centralise ici les informations SEO communes.

         Chaque page publique pourra ensuite personnaliser :

         - son titre ;
         - sa description ;
         - son image de partage ;
         - ses directives robots si nécessaire.

         Les espaces privés et les pages purement fonctionnelles
         sont automatiquement placés en noindex / nofollow.
         ========================================================= -->
    @php

        /*
        |--------------------------------------------------------------------------
        | TITRE SEO
        |--------------------------------------------------------------------------
        */

        $seoTitle = trim(
            $__env->yieldContent(
                'title',
                'Brussels Top Team'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | DESCRIPTION SEO
        |--------------------------------------------------------------------------
        */

        $seoDescription = trim(
            $__env->yieldContent(
                'meta_description',
                'Brussels Top Team - Sports de combat, fitness et futsal à Bruxelles.'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | URL CANONIQUE
        |--------------------------------------------------------------------------
        |
        | Par défaut, l'URL canonique correspond à l'URL actuelle.
        |
        | Une page particulière pourra la remplacer plus tard grâce
        | à une section "canonical" si cela devient nécessaire.
        |
        */

        $canonicalUrl = trim(
            $__env->yieldContent(
                'canonical',
                url()->current()
            )
        );


        /*
        |--------------------------------------------------------------------------
        | IMAGE DE PARTAGE PAR DÉFAUT
        |--------------------------------------------------------------------------
        |
        | Cette image sera utilisée par Open Graph et les cartes sociales.
        |
        | Une page ou un article pourra fournir sa propre image plus tard.
        |
        */

        $seoImage = trim(
            $__env->yieldContent(
                'meta_image',
                asset('images/BTTbanniere.png')
            )
        );


        /*
        |--------------------------------------------------------------------------
        | TYPE OPEN GRAPH
        |--------------------------------------------------------------------------
        |
        | Les pages classiques utilisent "website".
        |
        | Une page particulière, comme un article du blog, peut remplacer
        | cette valeur grâce à la section Blade "og_type".
        |
        */

        $seoOgType = trim(
            $__env->yieldContent(
                'og_type',
                'website'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | PAGES À NE PAS INDEXER
        |--------------------------------------------------------------------------
        |
        | Google et les autres moteurs n'ont pas besoin d'indexer :
        |
        | - l'administration ;
        | - l'espace membre ;
        | - la connexion ;
        | - l'inscription ;
        | - les pages de vérification d'email ;
        | - les pages techniques liées au compte.
        |
        | Les véritables pages publiques du site restent indexables.
        |
        */

        $shouldNoIndex =
            request()->is('admin') ||
            request()->is('admin/*') ||
            request()->is('membre') ||
            request()->is('membre/*') ||
            request()->is('connexion') ||
            request()->is('inscription') ||
            request()->is('inscription-reussie') ||
            request()->is('email/verification') ||
            request()->is('email/verification/*') ||
            request()->is('compte-supprime');


        /*
        |--------------------------------------------------------------------------
        | DIRECTIVE ROBOTS
        |--------------------------------------------------------------------------
        */

        $robotsContent = $shouldNoIndex
            ? 'noindex, nofollow'
            : 'index, follow';

    @endphp


    <!-- =========================================================
         TITRE DE LA PAGE
         ========================================================= -->
    <title>{{ $seoTitle }}</title>


    <!-- =========================================================
         DESCRIPTION SEO
         ========================================================= -->
    <meta
        name="description"
        content="{{ $seoDescription }}"
    >


    <!-- =========================================================
         DIRECTIVES POUR LES MOTEURS DE RECHERCHE
         ========================================================= -->
    <meta
        name="robots"
        content="{{ $robotsContent }}"
    >


    <!-- =========================================================
         URL CANONIQUE
         =========================================================
         L'URL canonique indique aux moteurs de recherche quelle URL
         représente la version principale de la page.
         ========================================================= -->
    <link
        rel="canonical"
        href="{{ $canonicalUrl }}"
    >


    <!-- =========================================================
         OPEN GRAPH
         =========================================================
         Ces balises améliorent la présentation du site lorsqu'une
         page est partagée sur des plateformes compatibles.
         ========================================================= -->
    <meta
        property="og:locale"
        content="fr_BE"
    >

    <meta
        property="og:type"
        content="{{ $seoOgType }}"
    >

    <meta
        property="og:site_name"
        content="Brussels Top Team"
    >

    <meta
        property="og:title"
        content="{{ $seoTitle }}"
    >

    <meta
        property="og:description"
        content="{{ $seoDescription }}"
    >

    <meta
        property="og:url"
        content="{{ $canonicalUrl }}"
    >

    <meta
        property="og:image"
        content="{{ $seoImage }}"
    >


    <!-- =========================================================
         TWITTER / X CARD
         =========================================================
         Ces informations permettent également aux plateformes qui
         comprennent les Twitter Cards d'afficher un aperçu enrichi.
         ========================================================= -->
    <meta
        name="twitter:card"
        content="summary_large_image"
    >

    <meta
        name="twitter:title"
        content="{{ $seoTitle }}"
    >

    <meta
        name="twitter:description"
        content="{{ $seoDescription }}"
    >

    <meta
        name="twitter:image"
        content="{{ $seoImage }}"
    >


    <!-- =========================================================
         CSS ET JAVASCRIPT
         Chargés avec Vite.
         ========================================================= -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="bg-zinc-950 text-white antialiased">


    <!-- =========================================================
         HEADER GLOBAL
         Visible sur toutes les pages.
         ========================================================= -->
    @include('partials.header')


    <!-- =========================================================
         CONTENU PRINCIPAL
         Chaque vue Blade injecte son contenu ici.
         ========================================================= -->
    <main>
        @yield('content')
    </main>


    <!-- =========================================================
         FOOTER GLOBAL
         Visible sur toutes les pages.
         ========================================================= -->
    @include('partials.footer')


</body>

</html>