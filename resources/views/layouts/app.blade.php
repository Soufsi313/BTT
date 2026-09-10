<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('meta_description', 'Brussels Top Team - Sports de combat, fitness et futsal à Bruxelles.')">

    <title>@yield('title', 'Brussels Top Team')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-950 text-white antialiased">

    @include('partials.header')

    <main>
        @yield('content')
    </main>

</body>
</html>