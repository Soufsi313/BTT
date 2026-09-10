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
         DESCRIPTION SEO
         Chaque page peut personnaliser cette description.
         ========================================================= -->
    <meta
        name="description"
        content="@yield(
            'meta_description',
            'Brussels Top Team - Sports de combat, fitness et futsal à Bruxelles.'
        )"
    >


    <!-- =========================================================
         TITRE DE LA PAGE
         ========================================================= -->
    <title>
        @yield('title', 'Brussels Top Team')
    </title>


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