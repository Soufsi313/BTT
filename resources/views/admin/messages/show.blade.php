@extends('layouts.app')


@section('title', 'Conversation - Administration BTT')


@section(
    'meta_description',
    'Lecture d’une conversation dans l’administration Brussels Top Team.'
)


@section('content')


    <!-- =========================================================
         CONVERSATION ADMINISTRATION
         =========================================================
         Cette page permet à un administrateur de consulter
         l'intégralité d'une conversation.

         Pour le moment :
         - lecture de la conversation ;
         - identification de l'expéditeur ;
         - affichage de tous les messages.

         La réponse de l'administration sera ajoutée ensuite.
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



                        <!-- =====================================
                             ADMINISTRATEURS
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
                            Conversation
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
                     CONTENU DE LA CONVERSATION
                     ============================================= -->
                <main class="px-6 py-8 lg:px-10 lg:py-10">


                    <!-- =========================================
                         RETOUR À LA BOÎTE DE RÉCEPTION
                         ========================================= -->
                    <a
                        href="{{ route('admin.messages.index') }}"
                        class="
                            inline-flex
                            items-center
                            text-sm
                            font-bold
                            text-zinc-500
                            transition
                            hover:text-red-600
                        "
                    >
                        ← Retour aux messages
                    </a>



                    <!-- =========================================
                         INFORMATIONS DE LA CONVERSATION
                         ========================================= -->
                    <section
                        class="
                            mt-8
                            border
                            border-zinc-200
                            bg-zinc-50
                        "
                    >

                        <div
                            class="
                                border-b
                                border-zinc-200
                                px-6
                                py-5
                            "
                        >

                            <div
                                class="
                                    flex
                                    flex-col
                                    gap-4
                                    sm:flex-row
                                    sm:items-start
                                    sm:justify-between
                                "
                            >

                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-[0.2em]
                                            text-red-600
                                        "
                                    >
                                        Expéditeur
                                    </p>


                                    <h2
                                        class="
                                            mt-2
                                            text-xl
                                            font-black
                                            text-zinc-900
                                        "
                                    >
                                        {{ $conversation->name }}
                                    </h2>


                                    <p
                                        class="
                                            mt-1
                                            break-all
                                            text-sm
                                            text-zinc-500
                                        "
                                    >
                                        {{ $conversation->email }}
                                    </p>

                                </div>



                                <!-- =============================
                                     TYPE D'EXPÉDITEUR
                                     ============================= -->
                                <div>

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
                                                border
                                                border-zinc-300
                                                bg-white
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

                                </div>

                            </div>

                        </div>



                        <!-- =====================================
                             INFORMATIONS COMPLÉMENTAIRES
                             ===================================== -->
                        <div
                            class="
                                grid
                                gap-6
                                px-6
                                py-5
                                sm:grid-cols-3
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
                                        mt-2
                                        text-sm
                                        font-bold
                                        text-zinc-800
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


                                <p class="mt-2">

                                    @if ($conversation->status === 'open')

                                        <span
                                            class="
                                                text-sm
                                                font-black
                                                text-green-700
                                            "
                                        >
                                            Ouverte
                                        </span>

                                    @else

                                        <span
                                            class="
                                                text-sm
                                                font-black
                                                text-zinc-500
                                            "
                                        >
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
                                    Reçue le
                                </p>


                                <p
                                    class="
                                        mt-2
                                        text-sm
                                        font-bold
                                        text-zinc-700
                                    "
                                >
                                    {{ $conversation->created_at->format('d/m/Y H:i') }}
                                </p>

                            </div>

                        </div>

                    </section>



                    <!-- =========================================
                         HISTORIQUE DES MESSAGES
                         ========================================= -->
                    <section class="mt-10">

                        <div
                            class="
                                flex
                                items-center
                                justify-between
                                border-b
                                border-zinc-200
                                pb-4
                            "
                        >

                            <h2
                                class="
                                    text-xl
                                    font-black
                                    uppercase
                                    tracking-tight
                                    text-zinc-900
                                "
                            >
                                Historique
                            </h2>


                            <p class="text-xs font-bold text-zinc-400">
                                {{ $conversation->messages->count() }}
                                message{{ $conversation->messages->count() > 1 ? 's' : '' }}
                            </p>

                        </div>



                        <div class="mt-6 space-y-5">


                            @foreach ($conversation->messages as $message)


                                <!-- =================================
                                     MESSAGE DE L'ADMINISTRATION
                                     ================================= -->
                                @if ($message->sender_type === 'admin')

                                    <article
                                        class="
                                            ml-auto
                                            max-w-3xl
                                            border-l-4
                                            border-red-600
                                            bg-zinc-900
                                            px-6
                                            py-5
                                            text-white
                                        "
                                    >

                                        <div
                                            class="
                                                flex
                                                flex-col
                                                gap-2
                                                sm:flex-row
                                                sm:items-center
                                                sm:justify-between
                                            "
                                        >

                                            <p
                                                class="
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-red-500
                                                "
                                            >
                                                Administration BTT
                                            </p>


                                            <p class="text-xs text-zinc-400">
                                                {{ $message->created_at->format('d/m/Y H:i') }}
                                            </p>

                                        </div>


                                        <p
                                            class="
                                                mt-4
                                                whitespace-pre-line
                                                break-words
                                                text-sm
                                                leading-7
                                                text-zinc-100
                                            "
                                        >
                                            {{ $message->body }}
                                        </p>

                                    </article>



                                <!-- =================================
                                     MESSAGE ADHÉRENT / VISITEUR
                                     ================================= -->
                                @else

                                    <article
                                        class="
                                            max-w-3xl
                                            border
                                            border-zinc-200
                                            bg-white
                                            px-6
                                            py-5
                                        "
                                    >

                                        <div
                                            class="
                                                flex
                                                flex-col
                                                gap-2
                                                sm:flex-row
                                                sm:items-center
                                                sm:justify-between
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

                                                @if ($message->sender_type === 'member')

                                                    Adhérent

                                                @else

                                                    Visiteur

                                                @endif

                                            </p>


                                            <p class="text-xs text-zinc-400">
                                                {{ $message->created_at->format('d/m/Y H:i') }}
                                            </p>

                                        </div>


                                        <p
                                            class="
                                                mt-4
                                                whitespace-pre-line
                                                break-words
                                                text-sm
                                                leading-7
                                                text-zinc-700
                                            "
                                        >
                                            {{ $message->body }}
                                        </p>

                                    </article>

                                @endif


                            @endforeach

                        </div>

                    </section>



                    <!-- =========================================
                         FUTURE ZONE DE RÉPONSE
                         =========================================
                         On n'active pas encore l'envoi.

                         Nous allons d'abord vérifier que :
                         - le message est correctement lu ;
                         - le passage Nouveau -> Lu fonctionne ;
                         - l'historique s'affiche correctement.
                         ========================================= -->
                    <section
                        class="
                            mt-10
                            border-t
                            border-zinc-200
                            pt-8
                        "
                    >

                        <div
                            class="
                                border
                                border-dashed
                                border-zinc-300
                                bg-zinc-50
                                px-6
                                py-6
                            "
                        >

                            <p
                                class="
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-[0.2em]
                                    text-zinc-500
                                "
                            >
                                Réponse administration
                            </p>


                            <p
                                class="
                                    mt-3
                                    max-w-2xl
                                    text-sm
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                La fonction de réponse sera activée à la
                                prochaine étape, après validation de la lecture
                                des conversations.
                            </p>

                        </div>

                    </section>

                </main>

            </div>

        </div>

    </section>


@endsection