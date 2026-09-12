@extends('layouts.app')


@section('title', 'Messages - Administration BTT')


@section(
    'meta_description',
    'Gestion des conversations reçues dans l’administration Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         MESSAGERIE ADMINISTRATION
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


                        <!-- TABLEAU DE BORD -->
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


                        <!-- ADHÉRENTS -->
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


                        <!-- CALENDRIER -->
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


                        <!-- ARTICLES -->
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


                        <!-- PRODUITS -->
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


                        <!-- MESSAGES -->
                        <a
                            href="{{ route('admin.messages.index') }}"
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
                            Messages
                        </a>


                        <!-- ADMINISTRATEURS -->
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
                            Messages
                        </h1>

                    </div>


                    <!-- ADMIN CONNECTÉ -->
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
                     CONTENU
                     ============================================= -->
                <main class="px-6 py-8 lg:px-10 lg:py-10">


                    <!-- =========================================
                         EN-TÊTE
                         ========================================= -->
                    <section
                        class="
                            flex
                            flex-col
                            gap-5
                            border-b
                            border-zinc-200
                            pb-8
                            lg:flex-row
                            lg:items-end
                            lg:justify-between
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
                                Messagerie
                            </p>

                            <h2
                                class="
                                    mt-2
                                    text-3xl
                                    font-black
                                    uppercase
                                    tracking-tight
                                    text-zinc-900
                                "
                            >
                                Boîte de réception
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
                                Cliquez directement sur les titres du tableau
                                pour modifier l'ordre d'affichage.
                            </p>

                        </div>


                        <!-- NOMBRE DE CONVERSATIONS -->
                        <div class="border-l-2 border-red-600 pl-4">

                            <p
                                class="
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-zinc-400
                                "
                            >
                                Conversations
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-2xl
                                    font-black
                                    text-zinc-900
                                "
                            >
                                {{ $conversations->total() }}
                            </p>

                        </div>

                    </section>


                    <!-- =========================================
                         TABLEAU
                         ========================================= -->
                    <section class="mt-8">

                        @if ($conversations->count() > 0)


                            <!-- =====================================
                                 VERSION ORDINATEUR
                                 ===================================== -->
                            <div
                                class="
                                    hidden
                                    overflow-hidden
                                    border
                                    border-zinc-200
                                    lg:block
                                "
                            >

                                <div class="overflow-x-auto">

                                    <table class="w-full">

                                        <thead class="bg-zinc-100">

                                            <tr class="border-b border-zinc-200">


                                                <!-- =====================
                                                     EXPÉDITEUR
                                                     ===================== -->
                                                <th class="p-0 text-left">

                                                    <a
                                                        href="{{ route(
                                                            'admin.messages.index',
                                                            [
                                                                'sort' => 'name',
                                                                'direction' => (
                                                                    $sort === 'name'
                                                                    && $direction === 'asc'
                                                                )
                                                                    ? 'desc'
                                                                    : 'asc'
                                                            ]
                                                        ) }}"
                                                        class="
                                                            group
                                                            flex
                                                            items-center
                                                            gap-2
                                                            px-5
                                                            py-4
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            transition
                                                            hover:bg-zinc-200
                                                            hover:text-red-600
                                                            {{ $sort === 'name'
                                                                ? 'text-red-600'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        Expéditeur

                                                        <span>
                                                            @if ($sort === 'name')
                                                                {{ $direction === 'asc' ? '↑' : '↓' }}
                                                            @else
                                                                ↕
                                                            @endif
                                                        </span>
                                                    </a>

                                                </th>


                                                <!-- =====================
                                                     SUJET
                                                     ===================== -->
                                                <th class="p-0 text-left">

                                                    <a
                                                        href="{{ route(
                                                            'admin.messages.index',
                                                            [
                                                                'sort' => 'subject',
                                                                'direction' => (
                                                                    $sort === 'subject'
                                                                    && $direction === 'asc'
                                                                )
                                                                    ? 'desc'
                                                                    : 'asc'
                                                            ]
                                                        ) }}"
                                                        class="
                                                            flex
                                                            items-center
                                                            gap-2
                                                            px-5
                                                            py-4
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            transition
                                                            hover:bg-zinc-200
                                                            hover:text-red-600
                                                            {{ $sort === 'subject'
                                                                ? 'text-red-600'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        Sujet

                                                        <span>
                                                            @if ($sort === 'subject')
                                                                {{ $direction === 'asc' ? '↑' : '↓' }}
                                                            @else
                                                                ↕
                                                            @endif
                                                        </span>
                                                    </a>

                                                </th>


                                                <!-- =====================
                                                     TYPE
                                                     ===================== -->
                                                <th class="p-0 text-left">

                                                    <a
                                                        href="{{ route(
                                                            'admin.messages.index',
                                                            [
                                                                'sort' => 'type',
                                                                'direction' => (
                                                                    $sort === 'type'
                                                                    && $direction === 'asc'
                                                                )
                                                                    ? 'desc'
                                                                    : 'asc'
                                                            ]
                                                        ) }}"
                                                        class="
                                                            flex
                                                            items-center
                                                            gap-2
                                                            px-5
                                                            py-4
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            transition
                                                            hover:bg-zinc-200
                                                            hover:text-red-600
                                                            {{ $sort === 'type'
                                                                ? 'text-red-600'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        Type

                                                        <span>
                                                            @if ($sort === 'type')
                                                                {{ $direction === 'asc' ? '↑' : '↓' }}
                                                            @else
                                                                ↕
                                                            @endif
                                                        </span>
                                                    </a>

                                                </th>


                                                <!-- =====================
                                                     STATUT
                                                     ===================== -->
                                                <th class="p-0 text-left">

                                                    <a
                                                        href="{{ route(
                                                            'admin.messages.index',
                                                            [
                                                                'sort' => 'status',
                                                                'direction' => (
                                                                    $sort === 'status'
                                                                    && $direction === 'asc'
                                                                )
                                                                    ? 'desc'
                                                                    : 'asc'
                                                            ]
                                                        ) }}"
                                                        class="
                                                            flex
                                                            items-center
                                                            gap-2
                                                            px-5
                                                            py-4
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            transition
                                                            hover:bg-zinc-200
                                                            hover:text-red-600
                                                            {{ $sort === 'status'
                                                                ? 'text-red-600'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        Statut

                                                        <span>
                                                            @if ($sort === 'status')
                                                                {{ $direction === 'asc' ? '↑' : '↓' }}
                                                            @else
                                                                ↕
                                                            @endif
                                                        </span>
                                                    </a>

                                                </th>


                                                <!-- =====================
                                                     LECTURE
                                                     ===================== -->
                                                <th class="p-0 text-left">

                                                    <a
                                                        href="{{ route(
                                                            'admin.messages.index',
                                                            [
                                                                'sort' => 'read',
                                                                'direction' => (
                                                                    $sort === 'read'
                                                                    && $direction === 'desc'
                                                                )
                                                                    ? 'asc'
                                                                    : 'desc'
                                                            ]
                                                        ) }}"
                                                        class="
                                                            flex
                                                            items-center
                                                            gap-2
                                                            px-5
                                                            py-4
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            transition
                                                            hover:bg-zinc-200
                                                            hover:text-red-600
                                                            {{ $sort === 'read'
                                                                ? 'text-red-600'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        Lecture

                                                        <span>
                                                            @if ($sort === 'read')
                                                                {{ $direction === 'asc' ? '↑' : '↓' }}
                                                            @else
                                                                ↕
                                                            @endif
                                                        </span>
                                                    </a>

                                                </th>


                                                <!-- =====================
                                                     DERNIÈRE ACTIVITÉ
                                                     ===================== -->
                                                <th class="p-0 text-left">

                                                    <a
                                                        href="{{ route(
                                                            'admin.messages.index',
                                                            [
                                                                'sort' => 'updated_at',
                                                                'direction' => (
                                                                    $sort === 'updated_at'
                                                                    && $direction === 'desc'
                                                                )
                                                                    ? 'asc'
                                                                    : 'desc'
                                                            ]
                                                        ) }}"
                                                        class="
                                                            flex
                                                            items-center
                                                            gap-2
                                                            px-5
                                                            py-4
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            transition
                                                            hover:bg-zinc-200
                                                            hover:text-red-600
                                                            {{ $sort === 'updated_at'
                                                                ? 'text-red-600'
                                                                : 'text-zinc-500'
                                                            }}
                                                        "
                                                    >
                                                        Dernière activité

                                                        <span>
                                                            @if ($sort === 'updated_at')
                                                                {{ $direction === 'asc' ? '↑' : '↓' }}
                                                            @else
                                                                ↕
                                                            @endif
                                                        </span>
                                                    </a>

                                                </th>


                                                <!-- ACTION -->
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
                                                    Action
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody class="divide-y divide-zinc-200">

                                            @foreach ($conversations as $conversation)

                                                <tr
                                                    class="
                                                        bg-white
                                                        transition
                                                        hover:bg-zinc-50
                                                    "
                                                >


                                                    <!-- EXPÉDITEUR -->
                                                    <td class="px-5 py-5">

                                                        <p class="font-black text-zinc-900">
                                                            {{ $conversation->name }}
                                                        </p>

                                                        <p
                                                            class="
                                                                mt-1
                                                                max-w-xs
                                                                truncate
                                                                text-xs
                                                                text-zinc-500
                                                            "
                                                        >
                                                            {{ $conversation->email }}
                                                        </p>

                                                    </td>


                                                    <!-- SUJET -->
                                                    <td class="px-5 py-5">

                                                        <p
                                                            class="
                                                                text-sm
                                                                font-bold
                                                                text-zinc-700
                                                            "
                                                        >
                                                            @switch($conversation->subject)

                                                                @case('abonnement')
                                                                    Abonnements / Affiliation
                                                                    @break

                                                                @case('entrainements')
                                                                    Nos entraînements
                                                                    @break

                                                                @case('compte')
                                                                    Inscription / Compte
                                                                    @break

                                                                @default
                                                                    Autre demande

                                                            @endswitch
                                                        </p>

                                                    </td>


                                                    <!-- TYPE -->
                                                    <td class="px-5 py-5">

                                                        @if ($conversation->user_id)

                                                            <span
                                                                class="
                                                                    inline-flex
                                                                    rounded-full
                                                                    bg-zinc-900
                                                                    px-3
                                                                    py-1.5
                                                                    text-[10px]
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-white
                                                                "
                                                            >
                                                                Adhérent
                                                            </span>

                                                        @else

                                                            <span
                                                                class="
                                                                    inline-flex
                                                                    rounded-full
                                                                    border
                                                                    border-zinc-300
                                                                    bg-white
                                                                    px-3
                                                                    py-1.5
                                                                    text-[10px]
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-zinc-600
                                                                "
                                                            >
                                                                Visiteur
                                                            </span>

                                                        @endif

                                                    </td>


                                                    <!-- STATUT -->
                                                    <td class="px-5 py-5">

                                                        @if ($conversation->status === 'open')

                                                            <span
                                                                class="
                                                                    inline-flex
                                                                    items-center
                                                                    gap-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    text-green-700
                                                                "
                                                            >
                                                                <span
                                                                    class="
                                                                        h-2
                                                                        w-2
                                                                        rounded-full
                                                                        bg-green-600
                                                                    "
                                                                ></span>

                                                                Ouverte
                                                            </span>

                                                        @else

                                                            <span
                                                                class="
                                                                    inline-flex
                                                                    items-center
                                                                    gap-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    text-zinc-500
                                                                "
                                                            >
                                                                <span
                                                                    class="
                                                                        h-2
                                                                        w-2
                                                                        rounded-full
                                                                        bg-zinc-400
                                                                    "
                                                                ></span>

                                                                Fermée
                                                            </span>

                                                        @endif

                                                    </td>


                                                    <!-- LECTURE -->
                                                    <td class="px-5 py-5">

                                                        @if ($conversation->unread_messages_count > 0)

                                                            <span
                                                                class="
                                                                    inline-flex
                                                                    items-center
                                                                    gap-2
                                                                    rounded-full
                                                                    bg-red-100
                                                                    px-3
                                                                    py-1.5
                                                                    text-[10px]
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-red-700
                                                                "
                                                            >
                                                                <span
                                                                    class="
                                                                        h-2
                                                                        w-2
                                                                        rounded-full
                                                                        bg-red-600
                                                                    "
                                                                ></span>

                                                                Nouveau
                                                            </span>

                                                        @else

                                                            <span
                                                                class="
                                                                    inline-flex
                                                                    items-center
                                                                    gap-2
                                                                    rounded-full
                                                                    bg-zinc-100
                                                                    px-3
                                                                    py-1.5
                                                                    text-[10px]
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-zinc-500
                                                                "
                                                            >
                                                                <span
                                                                    class="
                                                                        h-2
                                                                        w-2
                                                                        rounded-full
                                                                        bg-zinc-400
                                                                    "
                                                                ></span>

                                                                Lu
                                                            </span>

                                                        @endif

                                                    </td>


                                                    <!-- DERNIÈRE ACTIVITÉ -->
                                                    <td
                                                        class="
                                                            whitespace-nowrap
                                                            px-5
                                                            py-5
                                                            text-sm
                                                            font-bold
                                                            text-zinc-500
                                                        "
                                                    >
                                                        {{ $conversation->updated_at->format('d/m/Y H:i') }}
                                                    </td>


                                                    <!-- ACTION -->
                                                    <td class="px-5 py-5 text-right">

                                                        <a
                                                            href="{{ route(
                                                                'admin.messages.show',
                                                                $conversation
                                                            ) }}"
                                                            class="
                                                                inline-flex
                                                                items-center
                                                                justify-center
                                                                rounded-md
                                                                bg-zinc-900
                                                                px-4
                                                                py-2.5
                                                                text-xs
                                                                font-black
                                                                uppercase
                                                                tracking-wider
                                                                text-white
                                                                transition
                                                                hover:bg-red-600
                                                            "
                                                        >
                                                            Ouvrir
                                                        </a>

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>


                            <!-- =====================================
                                 VERSION MOBILE
                                 ===================================== -->
                            <div class="space-y-4 lg:hidden">

                                @foreach ($conversations as $conversation)

                                    <article
                                        class="
                                            border
                                            border-zinc-200
                                            bg-white
                                            p-5
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

                                            <div class="min-w-0">

                                                <p
                                                    class="
                                                        truncate
                                                        font-black
                                                        text-zinc-900
                                                    "
                                                >
                                                    {{ $conversation->name }}
                                                </p>

                                                <p
                                                    class="
                                                        mt-1
                                                        truncate
                                                        text-xs
                                                        text-zinc-500
                                                    "
                                                >
                                                    {{ $conversation->email }}
                                                </p>

                                            </div>


                                            <!-- LECTURE -->
                                            @if ($conversation->unread_messages_count > 0)

                                                <span
                                                    class="
                                                        shrink-0
                                                        rounded-full
                                                        bg-red-100
                                                        px-3
                                                        py-1.5
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        text-red-700
                                                    "
                                                >
                                                    Nouveau
                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        shrink-0
                                                        rounded-full
                                                        bg-zinc-100
                                                        px-3
                                                        py-1.5
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        text-zinc-500
                                                    "
                                                >
                                                    Lu
                                                </span>

                                            @endif

                                        </div>


                                        <div
                                            class="
                                                mt-5
                                                grid
                                                grid-cols-2
                                                gap-4
                                                border-y
                                                border-zinc-200
                                                py-4
                                            "
                                        >

                                            <!-- SUJET -->
                                            <div>

                                                <p
                                                    class="
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-zinc-400
                                                    "
                                                >
                                                    Sujet
                                                </p>

                                                <p
                                                    class="
                                                        mt-1
                                                        text-sm
                                                        font-bold
                                                        text-zinc-700
                                                    "
                                                >
                                                    @switch($conversation->subject)

                                                        @case('abonnement')
                                                            Abonnements / Affiliation
                                                            @break

                                                        @case('entrainements')
                                                            Nos entraînements
                                                            @break

                                                        @case('compte')
                                                            Inscription / Compte
                                                            @break

                                                        @default
                                                            Autre demande

                                                    @endswitch
                                                </p>

                                            </div>


                                            <!-- TYPE -->
                                            <div>

                                                <p
                                                    class="
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-zinc-400
                                                    "
                                                >
                                                    Type
                                                </p>

                                                <p
                                                    class="
                                                        mt-1
                                                        text-sm
                                                        font-bold
                                                        text-zinc-700
                                                    "
                                                >
                                                    @if ($conversation->user_id)
                                                        Adhérent
                                                    @else
                                                        Visiteur
                                                    @endif
                                                </p>

                                            </div>


                                            <!-- STATUT -->
                                            <div>

                                                <p
                                                    class="
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-zinc-400
                                                    "
                                                >
                                                    Statut
                                                </p>

                                                <p class="mt-1 text-sm font-bold">

                                                    @if ($conversation->status === 'open')

                                                        <span class="text-green-700">
                                                            Ouverte
                                                        </span>

                                                    @else

                                                        <span class="text-zinc-500">
                                                            Fermée
                                                        </span>

                                                    @endif

                                                </p>

                                            </div>


                                            <!-- DATE -->
                                            <div>

                                                <p
                                                    class="
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-zinc-400
                                                    "
                                                >
                                                    Dernière activité
                                                </p>

                                                <p
                                                    class="
                                                        mt-1
                                                        text-sm
                                                        font-bold
                                                        text-zinc-700
                                                    "
                                                >
                                                    {{ $conversation->updated_at->format('d/m/Y H:i') }}
                                                </p>

                                            </div>

                                        </div>


                                        <!-- ACTION -->
                                        <div class="mt-5">

                                            <a
                                                href="{{ route(
                                                    'admin.messages.show',
                                                    $conversation
                                                ) }}"
                                                class="
                                                    inline-flex
                                                    w-full
                                                    items-center
                                                    justify-center
                                                    rounded-md
                                                    bg-zinc-900
                                                    px-5
                                                    py-3
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-white
                                                    transition
                                                    hover:bg-red-600
                                                "
                                            >
                                                Ouvrir la conversation
                                            </a>

                                        </div>

                                    </article>

                                @endforeach

                            </div>


                            <!-- =====================================
                                 PAGINATION
                                 ===================================== -->
                            @if ($conversations->hasPages())

                                <div class="mt-8">
                                    {{ $conversations->links() }}
                                </div>

                            @endif


                        @else

                            <!-- =====================================
                                 AUCUNE CONVERSATION
                                 ===================================== -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-6
                                    py-14
                                    text-center
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-[0.2em]
                                        text-red-600
                                    "
                                >
                                    Messagerie BTT
                                </p>

                                <h3
                                    class="
                                        mt-3
                                        text-2xl
                                        font-black
                                        uppercase
                                        text-zinc-900
                                    "
                                >
                                    Aucun message
                                </h3>

                                <p
                                    class="
                                        mx-auto
                                        mt-3
                                        max-w-xl
                                        text-sm
                                        leading-6
                                        text-zinc-500
                                    "
                                >
                                    Aucune conversation n'a encore été reçue.
                                </p>

                            </div>

                        @endif

                    </section>

                </main>

            </div>

        </div>

    </section>

@endsection