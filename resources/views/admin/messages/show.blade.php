@extends('layouts.app')


@section('title', 'Conversation - Administration BTT')


@section(
    'meta_description',
    'Lecture et gestion d’une conversation dans l’administration Brussels Top Team.'
)


@section('content')


    <!-- =========================================================
         CONVERSATION ADMINISTRATION
         =========================================================

         Cette page permet à un administrateur :

         - de consulter les informations de la conversation ;
         - de lire l'historique complet des messages ;
         - de répondre à l'expéditeur ;
         - de fermer une conversation terminée ;
         - de rouvrir une conversation si nécessaire.

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
                            Conversation
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
                     CONTENU DE LA CONVERSATION
                     ============================================= -->
                <main class="px-6 py-8 lg:px-10 lg:py-10">


                    <!-- =========================================
                         RETOUR + ACTION SUR LA CONVERSATION
                         ========================================= -->
                    <div
                        class="
                            flex
                            flex-col
                            gap-4
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

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



                        <!-- =====================================
                             FERMER / ROUVRIR
                             ===================================== -->
                        <div>


                            @if ($conversation->status === 'open')

                                <!-- =============================
                                     FERMER LA CONVERSATION
                                     ============================= -->
                                <form
                                    action="{{ route(
                                        'admin.messages.close',
                                        $conversation
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="
                                            inline-flex
                                            items-center
                                            justify-center
                                            rounded-md
                                            border
                                            border-zinc-300
                                            bg-white
                                            px-4
                                            py-2.5
                                            text-xs
                                            font-black
                                            uppercase
                                            tracking-wider
                                            text-zinc-700
                                            transition
                                            hover:border-zinc-900
                                            hover:bg-zinc-900
                                            hover:text-white
                                        "
                                    >
                                        Fermer la conversation
                                    </button>

                                </form>

                            @else

                                <!-- =============================
                                     ROUVRIR LA CONVERSATION
                                     ============================= -->
                                <form
                                    action="{{ route(
                                        'admin.messages.reopen',
                                        $conversation
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        type="submit"
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
                                        Rouvrir la conversation
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>



                    <!-- =========================================
                         MESSAGE DE CONFIRMATION
                         ========================================= -->
                    @if (session('success'))

                        <div
                            class="
                                mt-6
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



                    <!-- =========================================
                         MESSAGE D'ERREUR
                         ========================================= -->
                    @if (session('error'))

                        <div
                            class="
                                mt-6
                                border
                                border-red-200
                                bg-red-50
                                px-5
                                py-4
                                text-sm
                                font-bold
                                text-red-700
                            "
                        >
                            {{ session('error') }}
                        </div>

                    @endif



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

                                <!-- EXPÉDITEUR -->
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



                                <!-- TYPE D'EXPÉDITEUR -->
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


                                <div class="mt-2">

                                    @if ($conversation->status === 'open')

                                        <span
                                            class="
                                                inline-flex
                                                items-center
                                                gap-2
                                                rounded-full
                                                bg-green-100
                                                px-3
                                                py-1.5
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
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
                                                rounded-full
                                                bg-zinc-200
                                                px-3
                                                py-1.5
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-600
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

                                            Fermée

                                        </span>

                                    @endif

                                </div>

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



                        <!-- =====================================
                             LISTE DES MESSAGES
                             ===================================== -->
                        <div class="mt-6 space-y-5">


                            @foreach ($conversation->messages as $message)


                                <!-- =================================
                                     MESSAGE ADMINISTRATION
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

                                            <div>

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


                                                @if ($message->user)

                                                    <p
                                                        class="
                                                            mt-1
                                                            text-xs
                                                            text-zinc-400
                                                        "
                                                    >
                                                        {{ $message->user->prenom }}
                                                        {{ $message->user->nom }}

                                                        @if ($message->user->pseudo)
                                                            — {{ $message->user->pseudo }}
                                                        @endif
                                                    </p>

                                                @endif

                                            </div>


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
                                        >{{ $message->body }}</p>

                                    </article>



                                <!-- =================================
                                     MESSAGE VISITEUR / ADHÉRENT
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

                                            <div>

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


                                                @if (
                                                    $message->sender_type === 'member'
                                                    && $message->user
                                                )

                                                    <p
                                                        class="
                                                            mt-1
                                                            text-xs
                                                            text-zinc-400
                                                        "
                                                    >
                                                        {{ $message->user->prenom }}
                                                        {{ $message->user->nom }}

                                                        @if ($message->user->pseudo)
                                                            — {{ $message->user->pseudo }}
                                                        @endif
                                                    </p>

                                                @endif

                                            </div>


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
                                        >{{ $message->body }}</p>

                                    </article>

                                @endif


                            @endforeach

                        </div>

                    </section>



                    <!-- =========================================
                         ZONE DE RÉPONSE
                         ========================================= -->
                    <section
                        class="
                            mt-10
                            border-t
                            border-zinc-200
                            pt-8
                        "
                    >


                        <!-- =====================================
                             CONVERSATION OUVERTE
                             ===================================== -->
                        @if ($conversation->status === 'open')

                            <div class="max-w-3xl">

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-[0.2em]
                                        text-red-600
                                    "
                                >
                                    Administration BTT
                                </p>


                                <h2
                                    class="
                                        mt-2
                                        text-2xl
                                        font-black
                                        uppercase
                                        tracking-tight
                                        text-zinc-900
                                    "
                                >
                                    Répondre
                                </h2>


                                <p
                                    class="
                                        mt-3
                                        text-sm
                                        leading-6
                                        text-zinc-500
                                    "
                                >
                                    Votre réponse sera enregistrée dans
                                    l'historique de cette conversation.
                                </p>



                                <!-- =============================
                                     FORMULAIRE DE RÉPONSE
                                     ============================= -->
                                <form
                                    action="{{ route(
                                        'admin.messages.reply',
                                        $conversation
                                    ) }}"
                                    method="POST"
                                    class="mt-6"
                                >

                                    @csrf


                                    <!-- =========================
                                         CHAMP RÉPONSE
                                         ========================= -->
                                    <div>

                                        <label
                                            for="reply"
                                            class="
                                                block
                                                text-sm
                                                font-black
                                                text-zinc-900
                                            "
                                        >
                                            Votre réponse
                                        </label>


                                        <textarea
                                            id="reply"
                                            name="reply"
                                            rows="7"
                                            minlength="2"
                                            maxlength="5000"
                                            required
                                            placeholder="Écrivez votre réponse..."
                                            class="
                                                mt-3
                                                block
                                                w-full
                                                resize-y
                                                rounded-md
                                                border
                                                border-zinc-300
                                                bg-white
                                                px-4
                                                py-3
                                                text-sm
                                                leading-6
                                                text-zinc-900
                                                outline-none
                                                transition
                                                placeholder:text-zinc-400
                                                focus:border-red-600
                                                focus:ring-2
                                                focus:ring-red-600/20
                                            "
                                        >{{ old('reply') }}</textarea>



                                        <!-- ERREUR DE VALIDATION -->
                                        @error('reply')

                                            <p
                                                class="
                                                    mt-2
                                                    text-sm
                                                    font-bold
                                                    text-red-600
                                                "
                                            >
                                                {{ $message }}
                                            </p>

                                        @enderror


                                        <p
                                            class="
                                                mt-2
                                                text-xs
                                                text-zinc-400
                                            "
                                        >
                                            Maximum : 5 000 caractères.
                                        </p>

                                    </div>



                                    <!-- =========================
                                         ENVOI
                                         ========================= -->
                                    <div
                                        class="
                                            mt-5
                                            flex
                                            flex-col
                                            gap-3
                                            sm:flex-row
                                            sm:items-center
                                        "
                                    >

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
                                                focus:outline-none
                                                focus:ring-2
                                                focus:ring-red-600
                                                focus:ring-offset-2
                                            "
                                        >
                                            Envoyer la réponse
                                        </button>


                                        <p class="text-xs text-zinc-400">
                                            Aucun e-mail n'est encore envoyé à cette étape.
                                        </p>

                                    </div>

                                </form>

                            </div>



                        <!-- =====================================
                             CONVERSATION FERMÉE
                             ===================================== -->
                        @else

                            <div
                                class="
                                    max-w-3xl
                                    border
                                    border-zinc-200
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
                                    Conversation fermée
                                </p>


                                <h2
                                    class="
                                        mt-2
                                        text-xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    Cette demande est terminée.
                                </h2>


                                <p
                                    class="
                                        mt-3
                                        text-sm
                                        leading-6
                                        text-zinc-500
                                    "
                                >
                                    Il n'est plus possible d'envoyer une
                                    nouvelle réponse tant que la conversation
                                    reste fermée.
                                </p>


                                <p
                                    class="
                                        mt-2
                                        text-sm
                                        leading-6
                                        text-zinc-500
                                    "
                                >
                                    Utilisez le bouton
                                    <strong class="text-zinc-700">
                                        Rouvrir la conversation
                                    </strong>
                                    en haut de cette page si vous devez
                                    reprendre cet échange.
                                </p>

                            </div>

                        @endif

                    </section>

                </main>

            </div>

        </div>

    </section>


@endsection