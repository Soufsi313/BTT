@extends('layouts.app')


@section('title', 'Messages - Administration BTT')


@section(
    'meta_description',
    'Boîte de réception de l’administration Brussels Top Team.'
)


@section('content')


    <!-- =========================================================
         MESSAGERIE ADMINISTRATION
         =========================================================

         Cette page affiche toutes les conversations reçues par BTT.

         Une conversation peut provenir :

         - d'un visiteur non connecté ;
         - d'un adhérent connecté.

         L'état de lecture est représenté clairement :

         - Nouveau : au moins un message entrant non lu ;
         - Lu      : tous les messages entrants ont été consultés.

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



                        <!-- =====================================
                             MESSAGES
                             Page actuellement active.
                             ===================================== -->
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
                         TITRE DE LA BOÎTE DE RÉCEPTION
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
                            Boîte de réception
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
                            Consultez les demandes envoyées par les visiteurs
                            et les adhérents Brussels Top Team.
                        </p>

                    </section>



                    <!-- =========================================
                         NAVIGATION MOBILE
                         ========================================= -->
                    <section class="mt-8 lg:hidden">

                        <div class="flex flex-wrap gap-3">

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="
                                    rounded-md
                                    border
                                    border-zinc-300
                                    px-4
                                    py-2.5
                                    text-sm
                                    font-bold
                                    text-zinc-700
                                "
                            >
                                Dashboard
                            </a>


                            <a
                                href="{{ route('admin.members.index') }}"
                                class="
                                    rounded-md
                                    border
                                    border-zinc-300
                                    px-4
                                    py-2.5
                                    text-sm
                                    font-bold
                                    text-zinc-700
                                "
                            >
                                Adhérents
                            </a>


                            <a
                                href="{{ route('admin.courses.index') }}"
                                class="
                                    rounded-md
                                    border
                                    border-zinc-300
                                    px-4
                                    py-2.5
                                    text-sm
                                    font-bold
                                    text-zinc-700
                                "
                            >
                                Calendrier
                            </a>

                        </div>

                    </section>



                    <!-- =========================================
                         LISTE DES CONVERSATIONS
                         ========================================= -->
                    <section class="mt-10">


                        @if ($conversations->count() > 0)


                            <!-- =====================================
                                 TABLEAU DESKTOP
                                 ===================================== -->
                            <div
                                class="
                                    hidden
                                    overflow-hidden
                                    border
                                    border-zinc-200
                                    md:block
                                "
                            >

                                <table class="w-full">

                                    <thead class="bg-zinc-50">

                                        <tr class="border-b border-zinc-200 text-left">

                                            <th
                                                class="
                                                    px-5
                                                    py-4
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-zinc-500
                                                "
                                            >
                                                Expéditeur
                                            </th>


                                            <th
                                                class="
                                                    px-5
                                                    py-4
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-zinc-500
                                                "
                                            >
                                                Sujet
                                            </th>


                                            <th
                                                class="
                                                    px-5
                                                    py-4
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-zinc-500
                                                "
                                            >
                                                Type
                                            </th>


                                            <th
                                                class="
                                                    px-5
                                                    py-4
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-zinc-500
                                                "
                                            >
                                                Lecture
                                            </th>


                                            <th
                                                class="
                                                    px-5
                                                    py-4
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
                                                Action
                                            </th>

                                        </tr>

                                    </thead>



                                    <tbody class="divide-y divide-zinc-200">


                                        @foreach ($conversations as $conversation)

                                            <tr
                                                class="
                                                    transition
                                                    hover:bg-zinc-50
                                                "
                                            >


                                                <!-- =====================
                                                     EXPÉDITEUR
                                                     ===================== -->
                                                <td class="px-5 py-5">

                                                    <p class="text-sm font-black text-zinc-900">
                                                        {{ $conversation->name }}
                                                    </p>


                                                    <p class="mt-1 text-xs text-zinc-500">
                                                        {{ $conversation->email }}
                                                    </p>

                                                </td>



                                                <!-- =====================
                                                     SUJET
                                                     ===================== -->
                                                <td class="px-5 py-5">

                                                    <p class="text-sm font-bold text-zinc-700">

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



                                                <!-- =====================
                                                     TYPE
                                                     ===================== -->
                                                <td class="px-5 py-5">

                                                    @if ($conversation->user_id)

                                                        <span
                                                            class="
                                                                inline-flex
                                                                rounded-full
                                                                bg-zinc-900
                                                                px-3
                                                                py-1.5
                                                                text-xs
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
                                                                bg-zinc-100
                                                                px-3
                                                                py-1.5
                                                                text-xs
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



                                                <!-- =====================
                                                     ÉTAT DE LECTURE
                                                     ===================== -->
                                                <td class="px-5 py-5">


                                                    @if ($conversation->unread_messages_count > 0)

                                                        <!-- =================
                                                             MESSAGE NON LU
                                                             ================= -->
                                                        <span
                                                            class="
                                                                inline-flex
                                                                items-center
                                                                gap-2
                                                                rounded-full
                                                                bg-red-100
                                                                px-3
                                                                py-1.5
                                                                text-xs
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

                                                        <!-- =================
                                                             MESSAGE LU
                                                             =================
                                                             Si tous les
                                                             messages entrants
                                                             ont is_read = 1,
                                                             ce badge apparaît.
                                                             ================= -->
                                                        <span
                                                            class="
                                                                inline-flex
                                                                items-center
                                                                gap-2
                                                                rounded-full
                                                                bg-zinc-200
                                                                px-3
                                                                py-1.5
                                                                text-xs
                                                                font-black
                                                                uppercase
                                                                tracking-wider
                                                                text-zinc-700
                                                            "
                                                        >

                                                            <span
                                                                class="
                                                                    h-2
                                                                    w-2
                                                                    rounded-full
                                                                    bg-zinc-500
                                                                "
                                                            ></span>

                                                            Lu

                                                        </span>

                                                    @endif

                                                </td>



                                                <!-- =====================
                                                     DATE
                                                     ===================== -->
                                                <td
                                                    class="
                                                        px-5
                                                        py-5
                                                        text-sm
                                                        text-zinc-500
                                                    "
                                                >
                                                    {{ $conversation->created_at->format('d/m/Y H:i') }}
                                                </td>



                                                <!-- =====================
                                                     OUVRIR
                                                     ===================== -->
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
                                                            bg-red-600
                                                            px-4
                                                            py-2.5
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-white
                                                            transition
                                                            hover:bg-red-700
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



                            <!-- =====================================
                                 AFFICHAGE MOBILE
                                 ===================================== -->
                            <div class="space-y-4 md:hidden">


                                @foreach ($conversations as $conversation)

                                    <article
                                        class="
                                            border
                                            border-zinc-200
                                            bg-white
                                            p-5
                                        "
                                    >


                                        <!-- =========================
                                             NOM + ÉTAT
                                             ========================= -->
                                        <div
                                            class="
                                                flex
                                                items-start
                                                justify-between
                                                gap-4
                                            "
                                        >

                                            <div>

                                                <p class="text-sm font-black text-zinc-900">
                                                    {{ $conversation->name }}
                                                </p>


                                                <p
                                                    class="
                                                        mt-1
                                                        break-all
                                                        text-xs
                                                        text-zinc-500
                                                    "
                                                >
                                                    {{ $conversation->email }}
                                                </p>

                                            </div>



                                            <!-- =====================
                                                 ÉTAT MOBILE
                                                 ===================== -->
                                            @if ($conversation->unread_messages_count > 0)

                                                <span
                                                    class="
                                                        inline-flex
                                                        shrink-0
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
                                                        shrink-0
                                                        items-center
                                                        gap-2
                                                        rounded-full
                                                        bg-zinc-200
                                                        px-3
                                                        py-1.5
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-zinc-700
                                                    "
                                                >

                                                    <span
                                                        class="
                                                            h-2
                                                            w-2
                                                            rounded-full
                                                            bg-zinc-500
                                                        "
                                                    ></span>

                                                    Lu

                                                </span>

                                            @endif

                                        </div>



                                        <!-- =========================
                                             INFORMATIONS
                                             ========================= -->
                                        <div class="mt-5 space-y-4">


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


                                                <p class="mt-1 text-sm font-bold text-zinc-700">

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
                                                    Expéditeur
                                                </p>


                                                <p class="mt-1 text-sm font-bold text-zinc-700">

                                                    @if ($conversation->user_id)

                                                        Adhérent

                                                    @else

                                                        Visiteur

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
                                                    Reçu le
                                                </p>


                                                <p class="mt-1 text-sm text-zinc-600">
                                                    {{ $conversation->created_at->format('d/m/Y H:i') }}
                                                </p>

                                            </div>

                                        </div>



                                        <!-- =========================
                                             OUVRIR
                                             ========================= -->
                                        <a
                                            href="{{ route(
                                                'admin.messages.show',
                                                $conversation
                                            ) }}"
                                            class="
                                                mt-5
                                                inline-flex
                                                w-full
                                                items-center
                                                justify-center
                                                rounded-md
                                                bg-red-600
                                                px-4
                                                py-3
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-white
                                                transition
                                                hover:bg-red-700
                                            "
                                        >
                                            Ouvrir la conversation
                                        </a>

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
                                 AUCUN MESSAGE
                                 ===================================== -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-zinc-50
                                    px-6
                                    py-12
                                    text-center
                                "
                            >

                                <p
                                    class="
                                        text-sm
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-900
                                    "
                                >
                                    Aucun message
                                </p>


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
                                    Les messages envoyés depuis le formulaire
                                    de contact ou depuis l'espace adhérent
                                    apparaîtront ici.
                                </p>

                            </div>

                        @endif

                    </section>

                </main>

            </div>

        </div>

    </section>


@endsection