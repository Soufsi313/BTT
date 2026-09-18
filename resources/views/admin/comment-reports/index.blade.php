@extends('layouts.app')

@section('title', 'Signalements des commentaires - Administration BTT')

@section('content')

    {{--
    |--------------------------------------------------------------------------
    | PAGE ADMINISTRATION DES SIGNALEMENTS DE COMMENTAIRES
    |--------------------------------------------------------------------------
    |
    | Cette page permet aux administrateurs de consulter et de traiter
    | les signalements envoyés par les membres du site.
    |
    | Pour chaque signalement, l'administration peut :
    |
    | - consulter le membre ayant effectué le signalement ;
    | - consulter le commentaire concerné ;
    | - connaître l'auteur du commentaire ;
    | - connaître l'article concerné ;
    | - consulter le motif et les précisions du signalement ;
    | - marquer le signalement comme examiné ;
    | - rejeter le signalement ;
    | - masquer le commentaire et résoudre le signalement.
    |
    --}}

    <section class="min-h-screen bg-white text-zinc-900">

        <div class="flex min-h-screen">


            {{--
            |--------------------------------------------------------------------------
            | BARRE LATÉRALE ADMIN COMMUNE
            |--------------------------------------------------------------------------
            |
            | La navigation de l'administration est maintenant centralisée dans :
            |
            | resources/views/admin/partials/sidebar.blade.php
            |
            | Cela garantit que le menu reste exactement identique sur toutes
            | les pages de l'administration.
            |
            | Le partial détecte automatiquement la route active grâce à :
            |
            | request()->routeIs('admin.comment-reports.*')
            |
            | La rubrique "Signalements" reste donc affichée en rouge sur
            | toutes les pages liées à la modération des signalements.
            |
            |--------------------------------------------------------------------------
            --}}

            @include('admin.partials.sidebar')


            {{--
            |--------------------------------------------------------------------------
            | CONTENU PRINCIPAL
            |--------------------------------------------------------------------------
            --}}

            <div class="min-w-0 flex-1">

                <main
                    class="
                        mx-auto
                        w-full
                        max-w-[1600px]
                        px-4
                        py-8
                        sm:px-6
                        lg:px-8
                    "
                >

                    {{--
                    |--------------------------------------------------------------------------
                    | EN-TÊTE
                    |--------------------------------------------------------------------------
                    --}}

                    <div
                        class="
                            mb-8
                            flex
                            flex-col
                            gap-4
                            border-b
                            border-zinc-200
                            pb-6
                            sm:flex-row
                            sm:items-end
                            sm:justify-between
                        "
                    >

                        <div>

                            <p
                                class="
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-[0.25em]
                                    text-red-600
                                "
                            >
                                Modération
                            </p>

                            <h1
                                class="
                                    mt-2
                                    text-3xl
                                    font-black
                                    tracking-tight
                                    text-zinc-950
                                    sm:text-4xl
                                "
                            >
                                Signalements des commentaires
                            </h1>

                            <p
                                class="
                                    mt-3
                                    max-w-3xl
                                    text-sm
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                Consultez les commentaires signalés par les
                                membres et prenez les mesures de modération
                                nécessaires.
                            </p>

                        </div>


                        {{--
                        |--------------------------------------------------------------------------
                        | NOMBRE TOTAL DE SIGNALEMENTS
                        |--------------------------------------------------------------------------
                        --}}

                        <div
                            class="
                                rounded-lg
                                border
                                border-zinc-200
                                bg-zinc-50
                                px-5
                                py-3
                            "
                        >

                            <p
                                class="
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-zinc-500
                                "
                            >
                                Total
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-2xl
                                    font-black
                                    text-zinc-950
                                "
                            >
                                {{ number_format(
                                    $totalReportsCount,
                                    0,
                                    ',',
                                    ' '
                                ) }}
                            </p>

                        </div>

                    </div>


                    {{--
                    |--------------------------------------------------------------------------
                    | MESSAGE DE SUCCÈS
                    |--------------------------------------------------------------------------
                    --}}

                    @if (session('success'))

                        <div
                            class="
                                mb-6
                                rounded-lg
                                border
                                border-green-200
                                bg-green-50
                                px-5
                                py-4
                                text-sm
                                font-bold
                                text-green-800
                            "
                        >
                            {{ session('success') }}
                        </div>

                    @endif


                    {{--
                    |--------------------------------------------------------------------------
                    | MESSAGE D'ERREUR
                    |--------------------------------------------------------------------------
                    --}}

                    @if (session('error'))

                        <div
                            class="
                                mb-6
                                rounded-lg
                                border
                                border-red-200
                                bg-red-50
                                px-5
                                py-4
                                text-sm
                                font-bold
                                text-red-800
                            "
                        >
                            {{ session('error') }}
                        </div>

                    @endif


                    {{--
                    |--------------------------------------------------------------------------
                    | STATISTIQUES DES SIGNALEMENTS
                    |--------------------------------------------------------------------------
                    |
                    | Les statistiques sont calculées dans le contrôleur et sont
                    | indépendantes de la pagination du tableau.
                    |
                    | Elles permettent de suivre immédiatement :
                    |
                    | - tous les signalements ;
                    | - ceux qui attendent une première intervention ;
                    | - ceux qui ont été examinés ;
                    | - ceux qui ont été traités ;
                    | - ceux qui ont été rejetés.
                    |
                    |--------------------------------------------------------------------------
                    --}}

                    <section class="mb-8">

                        <div
                            class="
                                grid
                                gap-4
                                sm:grid-cols-2
                                xl:grid-cols-5
                            "
                        >


                            {{--
                            |--------------------------------------------------------------------------
                            | TOTAL
                            |--------------------------------------------------------------------------
                            --}}

                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Total des signalements
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
                                        $totalReportsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Tous statuts confondus.
                                </p>

                            </div>


                            {{--
                            |--------------------------------------------------------------------------
                            | EN ATTENTE
                            |--------------------------------------------------------------------------
                            --}}

                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    En attente
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-amber-600
                                    "
                                >
                                    {{ number_format(
                                        $pendingReportsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Signalements à examiner.
                                </p>

                            </div>


                            {{--
                            |--------------------------------------------------------------------------
                            | EXAMINÉS
                            |--------------------------------------------------------------------------
                            --}}

                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Examinés
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-blue-600
                                    "
                                >
                                    {{ number_format(
                                        $reviewedReportsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    En attente d'une décision.
                                </p>

                            </div>


                            {{--
                            |--------------------------------------------------------------------------
                            | TRAITÉS
                            |--------------------------------------------------------------------------
                            --}}

                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Traités
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-green-600
                                    "
                                >
                                    {{ number_format(
                                        $resolvedReportsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Modération effectuée.
                                </p>

                            </div>


                            {{--
                            |--------------------------------------------------------------------------
                            | REJETÉS
                            |--------------------------------------------------------------------------
                            --}}

                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Rejetés
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
                                        $rejectedReportsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Aucune modération nécessaire.
                                </p>

                            </div>

                        </div>

                    </section>


                    {{--
                    |--------------------------------------------------------------------------
                    | TABLEAU DES SIGNALEMENTS
                    |--------------------------------------------------------------------------
                    --}}

                    <div
                        class="
                            overflow-hidden
                            rounded-xl
                            border
                            border-zinc-200
                            bg-white
                        "
                    >

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-zinc-200">

                                {{--
                                |--------------------------------------------------------------------------
                                | EN-TÊTE DU TABLEAU
                                |--------------------------------------------------------------------------
                                --}}

                                <thead class="bg-zinc-50">

                                    <tr>

                                        <th
                                            class="
                                                px-5
                                                py-4
                                                text-left
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            ID
                                        </th>

                                        <th
                                            class="
                                                px-5
                                                py-4
                                                text-left
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            Signalé par
                                        </th>

                                        <th
                                            class="
                                                px-5
                                                py-4
                                                text-left
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            Commentaire
                                        </th>

                                        <th
                                            class="
                                                px-5
                                                py-4
                                                text-left
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            Motif
                                        </th>

                                        <th
                                            class="
                                                px-5
                                                py-4
                                                text-left
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            Statut
                                        </th>

                                        <th
                                            class="
                                                px-5
                                                py-4
                                                text-left
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            Date
                                        </th>

                                        <th
                                            class="
                                                px-5
                                                py-4
                                                text-right
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                {{--
                                |--------------------------------------------------------------------------
                                | CONTENU DU TABLEAU
                                |--------------------------------------------------------------------------
                                --}}

                                <tbody class="divide-y divide-zinc-100 bg-white">

                                    @forelse ($reports as $report)

                                        <tr
                                            class="
                                                align-top
                                                transition
                                                hover:bg-zinc-50
                                            "
                                        >

                                            {{--
                                            |--------------------------------------------------------------------------
                                            | IDENTIFIANT
                                            |--------------------------------------------------------------------------
                                            --}}

                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-5
                                                    py-5
                                                    text-sm
                                                    font-black
                                                    text-zinc-900
                                                "
                                            >
                                                #{{ $report->id }}
                                            </td>


                                            {{--
                                            |--------------------------------------------------------------------------
                                            | MEMBRE AYANT EFFECTUÉ LE SIGNALEMENT
                                            |--------------------------------------------------------------------------
                                            --}}

                                            <td class="px-5 py-5">

                                                @if ($report->user)

                                                    <p
                                                        class="
                                                            text-sm
                                                            font-black
                                                            text-zinc-900
                                                        "
                                                    >
                                                        {{ $report->user->prenom }}
                                                        {{ $report->user->nom }}
                                                    </p>

                                                    @if ($report->user->pseudo)

                                                        <p
                                                            class="
                                                                mt-1
                                                                text-xs
                                                                text-zinc-500
                                                            "
                                                        >
                                                            {{ '@' . $report->user->pseudo }}
                                                        </p>

                                                    @endif

                                                    <p
                                                        class="
                                                            mt-1
                                                            text-xs
                                                            text-zinc-500
                                                        "
                                                    >
                                                        {{ $report->user->email }}
                                                    </p>

                                                @else

                                                    <span
                                                        class="
                                                            text-sm
                                                            font-bold
                                                            text-zinc-400
                                                        "
                                                    >
                                                        Compte supprimé
                                                    </span>

                                                @endif

                                            </td>


                                            {{--
                                            |--------------------------------------------------------------------------
                                            | COMMENTAIRE SIGNALÉ
                                            |--------------------------------------------------------------------------
                                            --}}

                                            <td
                                                class="
                                                    min-w-[320px]
                                                    px-5
                                                    py-5
                                                "
                                            >

                                                @if ($report->comment)

                                                    {{--
                                                    |--------------------------------------------------------------------------
                                                    | AUTEUR DU COMMENTAIRE
                                                    |--------------------------------------------------------------------------
                                                    --}}

                                                    <div
                                                        class="
                                                            mb-3
                                                            flex
                                                            flex-wrap
                                                            items-center
                                                            gap-2
                                                        "
                                                    >

                                                        <span
                                                            class="
                                                                text-xs
                                                                font-bold
                                                                uppercase
                                                                tracking-wider
                                                                text-zinc-400
                                                            "
                                                        >
                                                            Auteur :
                                                        </span>

                                                        <span
                                                            class="
                                                                text-sm
                                                                font-black
                                                                text-zinc-800
                                                            "
                                                        >
                                                            @if ($report->comment->user)

                                                                {{ $report->comment->user->prenom }}
                                                                {{ $report->comment->user->nom }}

                                                            @else

                                                                Compte supprimé

                                                            @endif
                                                        </span>

                                                    </div>


                                                    {{--
                                                    |--------------------------------------------------------------------------
                                                    | TEXTE DU COMMENTAIRE
                                                    |--------------------------------------------------------------------------
                                                    --}}

                                                    <div
                                                        class="
                                                            rounded-lg
                                                            border
                                                            border-zinc-200
                                                            bg-zinc-50
                                                            p-4
                                                        "
                                                    >

                                                        <p
                                                            class="
                                                                whitespace-pre-line
                                                                text-sm
                                                                leading-6
                                                                text-zinc-700
                                                            "
                                                        >
                                                            {{ $report->comment->body }}
                                                        </p>

                                                    </div>


                                                    {{--
                                                    |--------------------------------------------------------------------------
                                                    | ÉTAT ACTUEL DU COMMENTAIRE
                                                    |--------------------------------------------------------------------------
                                                    --}}

                                                    <div
                                                        class="
                                                            mt-3
                                                            flex
                                                            flex-wrap
                                                            items-center
                                                            gap-2
                                                        "
                                                    >

                                                        <span
                                                            class="
                                                                text-xs
                                                                font-bold
                                                                text-zinc-500
                                                            "
                                                        >
                                                            État du commentaire :
                                                        </span>


                                                        @if ($report->comment->status === 'published')

                                                            <span
                                                                class="
                                                                    rounded-full
                                                                    bg-green-100
                                                                    px-2.5
                                                                    py-1
                                                                    text-xs
                                                                    font-black
                                                                    text-green-700
                                                                "
                                                            >
                                                                Publié
                                                            </span>

                                                        @elseif ($report->comment->status === 'hidden')

                                                            <span
                                                                class="
                                                                    rounded-full
                                                                    bg-red-100
                                                                    px-2.5
                                                                    py-1
                                                                    text-xs
                                                                    font-black
                                                                    text-red-700
                                                                "
                                                            >
                                                                Masqué
                                                            </span>

                                                        @else

                                                            <span
                                                                class="
                                                                    rounded-full
                                                                    bg-zinc-100
                                                                    px-2.5
                                                                    py-1
                                                                    text-xs
                                                                    font-black
                                                                    text-zinc-600
                                                                "
                                                            >
                                                                {{ ucfirst($report->comment->status) }}
                                                            </span>

                                                        @endif

                                                    </div>


                                                    {{--
                                                    |--------------------------------------------------------------------------
                                                    | ARTICLE CONCERNÉ
                                                    |--------------------------------------------------------------------------
                                                    --}}

                                                    @if ($report->comment->article)

                                                        <div class="mt-3">

                                                            <a
                                                                href="{{ route(
                                                                    'blog.show',
                                                                    $report->comment->article->slug
                                                                ) }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                class="
                                                                    text-xs
                                                                    font-black
                                                                    text-red-600
                                                                    underline
                                                                    decoration-red-200
                                                                    underline-offset-4
                                                                    transition
                                                                    hover:text-red-700
                                                                "
                                                            >
                                                                Voir l'article :
                                                                {{ $report->comment->article->title }}
                                                            </a>

                                                        </div>

                                                    @endif

                                                @else

                                                    <span
                                                        class="
                                                            text-sm
                                                            font-bold
                                                            text-red-600
                                                        "
                                                    >
                                                        Commentaire introuvable
                                                    </span>

                                                @endif

                                            </td>


                                            {{--
                                            |--------------------------------------------------------------------------
                                            | MOTIF DU SIGNALEMENT
                                            |--------------------------------------------------------------------------
                                            --}}

                                            <td
                                                class="
                                                    min-w-[220px]
                                                    px-5
                                                    py-5
                                                "
                                            >

                                                @php
                                                    $reasonLabels = [
                                                        'insultes' => 'Insultes',
                                                        'harcelement' => 'Harcèlement',
                                                        'spam' => 'Spam',
                                                        'contenu_inapproprie' => 'Contenu inapproprié',
                                                        'autre' => 'Autre',
                                                    ];
                                                @endphp

                                                <span
                                                    class="
                                                        inline-flex
                                                        rounded-full
                                                        bg-red-50
                                                        px-3
                                                        py-1
                                                        text-xs
                                                        font-black
                                                        text-red-700
                                                    "
                                                >
                                                    {{ $reasonLabels[$report->reason] ?? $report->reason }}
                                                </span>


                                                @if ($report->details)

                                                    <p
                                                        class="
                                                            mt-3
                                                            whitespace-pre-line
                                                            text-sm
                                                            leading-6
                                                            text-zinc-600
                                                        "
                                                    >
                                                        {{ $report->details }}
                                                    </p>

                                                @else

                                                    <p
                                                        class="
                                                            mt-3
                                                            text-xs
                                                            italic
                                                            text-zinc-400
                                                        "
                                                    >
                                                        Aucune précision
                                                    </p>

                                                @endif

                                            </td>


                                            {{--
                                            |--------------------------------------------------------------------------
                                            | STATUT DU SIGNALEMENT
                                            |--------------------------------------------------------------------------
                                            --}}

                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-5
                                                    py-5
                                                "
                                            >

                                                @if ($report->status === 'pending')

                                                    <span
                                                        class="
                                                            inline-flex
                                                            rounded-full
                                                            bg-amber-100
                                                            px-3
                                                            py-1
                                                            text-xs
                                                            font-black
                                                            text-amber-700
                                                        "
                                                    >
                                                        En attente
                                                    </span>

                                                @elseif ($report->status === 'reviewed')

                                                    <span
                                                        class="
                                                            inline-flex
                                                            rounded-full
                                                            bg-blue-100
                                                            px-3
                                                            py-1
                                                            text-xs
                                                            font-black
                                                            text-blue-700
                                                        "
                                                    >
                                                        Examiné
                                                    </span>

                                                @elseif ($report->status === 'resolved')

                                                    <span
                                                        class="
                                                            inline-flex
                                                            rounded-full
                                                            bg-green-100
                                                            px-3
                                                            py-1
                                                            text-xs
                                                            font-black
                                                            text-green-700
                                                        "
                                                    >
                                                        Traité
                                                    </span>

                                                @elseif ($report->status === 'rejected')

                                                    <span
                                                        class="
                                                            inline-flex
                                                            rounded-full
                                                            bg-zinc-200
                                                            px-3
                                                            py-1
                                                            text-xs
                                                            font-black
                                                            text-zinc-700
                                                        "
                                                    >
                                                        Rejeté
                                                    </span>

                                                @else

                                                    <span
                                                        class="
                                                            inline-flex
                                                            rounded-full
                                                            bg-zinc-100
                                                            px-3
                                                            py-1
                                                            text-xs
                                                            font-black
                                                            text-zinc-600
                                                        "
                                                    >
                                                        {{ ucfirst($report->status) }}
                                                    </span>

                                                @endif


                                                {{--
                                                |--------------------------------------------------------------------------
                                                | DATE DE TRAITEMENT
                                                |--------------------------------------------------------------------------
                                                --}}

                                                @if ($report->reviewed_at)

                                                    <p
                                                        class="
                                                            mt-2
                                                            text-xs
                                                            text-zinc-400
                                                        "
                                                    >
                                                        {{ $report->reviewed_at->format('d/m/Y H:i') }}
                                                    </p>

                                                @endif

                                            </td>


                                            {{--
                                            |--------------------------------------------------------------------------
                                            | DATE DU SIGNALEMENT
                                            |--------------------------------------------------------------------------
                                            --}}

                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-5
                                                    py-5
                                                    text-sm
                                                    text-zinc-600
                                                "
                                            >

                                                <p class="font-bold">
                                                    {{ $report->created_at->format('d/m/Y') }}
                                                </p>

                                                <p
                                                    class="
                                                        mt-1
                                                        text-xs
                                                        text-zinc-400
                                                    "
                                                >
                                                    {{ $report->created_at->format('H:i') }}
                                                </p>

                                            </td>


                                            {{--
                                            |--------------------------------------------------------------------------
                                            | ACTIONS DE MODÉRATION
                                            |--------------------------------------------------------------------------
                                            --}}

                                            <td
                                                class="
                                                    min-w-[220px]
                                                    px-5
                                                    py-5
                                                "
                                            >

                                                <div
                                                    class="
                                                        flex
                                                        flex-col
                                                        items-stretch
                                                        gap-2
                                                    "
                                                >

                                                    {{--
                                                    |--------------------------------------------------------------------------
                                                    | SIGNALEMENT EN ATTENTE
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | Les trois décisions sont encore possibles.
                                                    |
                                                    --}}

                                                    @if ($report->status === 'pending')


                                                        {{--
                                                        |--------------------------------------------------------------------------
                                                        | MARQUER COMME EXAMINÉ
                                                        |--------------------------------------------------------------------------
                                                        --}}

                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'admin.comment-reports.review',
                                                                $report
                                                            ) }}"
                                                        >
                                                            @csrf
                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="
                                                                    w-full
                                                                    rounded-lg
                                                                    border
                                                                    border-blue-200
                                                                    bg-blue-50
                                                                    px-3
                                                                    py-2.5
                                                                    text-xs
                                                                    font-black
                                                                    text-blue-700
                                                                    transition
                                                                    hover:border-blue-300
                                                                    hover:bg-blue-100
                                                                "
                                                            >
                                                                Examiner
                                                            </button>

                                                        </form>


                                                        {{--
                                                        |--------------------------------------------------------------------------
                                                        | REJETER
                                                        |--------------------------------------------------------------------------
                                                        --}}

                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'admin.comment-reports.reject',
                                                                $report
                                                            ) }}"
                                                            onsubmit="
                                                                return confirm(
                                                                    'Confirmer le rejet de ce signalement ?'
                                                                );
                                                            "
                                                        >
                                                            @csrf
                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="
                                                                    w-full
                                                                    rounded-lg
                                                                    border
                                                                    border-zinc-300
                                                                    bg-white
                                                                    px-3
                                                                    py-2.5
                                                                    text-xs
                                                                    font-black
                                                                    text-zinc-700
                                                                    transition
                                                                    hover:bg-zinc-100
                                                                "
                                                            >
                                                                Rejeter
                                                            </button>

                                                        </form>


                                                        {{--
                                                        |--------------------------------------------------------------------------
                                                        | MASQUER ET TRAITER
                                                        |--------------------------------------------------------------------------
                                                        --}}

                                                        @if ($report->comment)

                                                            <form
                                                                method="POST"
                                                                action="{{ route(
                                                                    'admin.comment-reports.resolve',
                                                                    $report
                                                                ) }}"
                                                                onsubmit="
                                                                    return confirm(
                                                                        'Confirmer la modération ? Le commentaire sera masqué du blog.'
                                                                    );
                                                                "
                                                            >
                                                                @csrf
                                                                @method('PATCH')

                                                                <button
                                                                    type="submit"
                                                                    class="
                                                                        w-full
                                                                        rounded-lg
                                                                        bg-red-600
                                                                        px-3
                                                                        py-2.5
                                                                        text-xs
                                                                        font-black
                                                                        text-white
                                                                        transition
                                                                        hover:bg-red-700
                                                                    "
                                                                >
                                                                    Masquer et traiter
                                                                </button>

                                                            </form>

                                                        @endif


                                                    {{--
                                                    |--------------------------------------------------------------------------
                                                    | SIGNALEMENT EXAMINÉ
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | Après examen, l'administrateur doit encore prendre
                                                    | une décision définitive : rejet ou résolution.
                                                    |
                                                    --}}

                                                    @elseif ($report->status === 'reviewed')


                                                        {{--
                                                        |--------------------------------------------------------------------------
                                                        | REJETER APRÈS EXAMEN
                                                        |--------------------------------------------------------------------------
                                                        --}}

                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'admin.comment-reports.reject',
                                                                $report
                                                            ) }}"
                                                            onsubmit="
                                                                return confirm(
                                                                    'Confirmer le rejet de ce signalement ?'
                                                                );
                                                            "
                                                        >
                                                            @csrf
                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="
                                                                    w-full
                                                                    rounded-lg
                                                                    border
                                                                    border-zinc-300
                                                                    bg-white
                                                                    px-3
                                                                    py-2.5
                                                                    text-xs
                                                                    font-black
                                                                    text-zinc-700
                                                                    transition
                                                                    hover:bg-zinc-100
                                                                "
                                                            >
                                                                Rejeter
                                                            </button>

                                                        </form>


                                                        {{--
                                                        |--------------------------------------------------------------------------
                                                        | MASQUER ET TRAITER APRÈS EXAMEN
                                                        |--------------------------------------------------------------------------
                                                        --}}

                                                        @if ($report->comment)

                                                            <form
                                                                method="POST"
                                                                action="{{ route(
                                                                    'admin.comment-reports.resolve',
                                                                    $report
                                                                ) }}"
                                                                onsubmit="
                                                                    return confirm(
                                                                        'Confirmer la modération ? Le commentaire sera masqué du blog.'
                                                                    );
                                                                "
                                                            >
                                                                @csrf
                                                                @method('PATCH')

                                                                <button
                                                                    type="submit"
                                                                    class="
                                                                        w-full
                                                                        rounded-lg
                                                                        bg-red-600
                                                                        px-3
                                                                        py-2.5
                                                                        text-xs
                                                                        font-black
                                                                        text-white
                                                                        transition
                                                                        hover:bg-red-700
                                                                    "
                                                                >
                                                                    Masquer et traiter
                                                                </button>

                                                            </form>

                                                        @endif


                                                    {{--
                                                    |--------------------------------------------------------------------------
                                                    | SIGNALEMENT TERMINÉ
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | Un signalement rejeté ou résolu ne présente plus
                                                    | d'action afin d'éviter une modification accidentelle
                                                    | d'une décision terminée.
                                                    |
                                                    --}}

                                                    @else

                                                        <div
                                                            class="
                                                                rounded-lg
                                                                border
                                                                border-zinc-200
                                                                bg-zinc-50
                                                                px-3
                                                                py-3
                                                                text-center
                                                                text-xs
                                                                font-bold
                                                                text-zinc-500
                                                            "
                                                        >
                                                            Aucune action requise
                                                        </div>

                                                    @endif

                                                </div>

                                            </td>

                                        </tr>

                                    @empty


                                        {{--
                                        |--------------------------------------------------------------------------
                                        | AUCUN SIGNALEMENT
                                        |--------------------------------------------------------------------------
                                        --}}

                                        <tr>

                                            <td
                                                colspan="7"
                                                class="
                                                    px-6
                                                    py-16
                                                    text-center
                                                "
                                            >

                                                <div class="mx-auto max-w-md">

                                                    <p
                                                        class="
                                                            text-lg
                                                            font-black
                                                            text-zinc-900
                                                        "
                                                    >
                                                        Aucun signalement
                                                    </p>

                                                    <p
                                                        class="
                                                            mt-2
                                                            text-sm
                                                            leading-6
                                                            text-zinc-500
                                                        "
                                                    >
                                                        Aucun commentaire du blog
                                                        n'a été signalé pour le moment.
                                                    </p>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{--
                    |--------------------------------------------------------------------------
                    | PAGINATION
                    |--------------------------------------------------------------------------
                    --}}

                    @if ($reports->hasPages())

                        <div class="mt-8">
                            {{ $reports->links() }}
                        </div>

                    @endif

                </main>

            </div>

        </div>

    </section>

@endsection