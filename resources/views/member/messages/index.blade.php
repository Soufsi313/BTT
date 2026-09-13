@extends('layouts.app')


@section('title', 'Mes messages - Brussels Top Team')


@section(
    'meta_description',
    'Consultez vos conversations avec l’administration Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         MESSAGERIE ADHÉRENT
         =========================================================
         Cette page affiche uniquement les conversations appartenant
         à l'utilisateur actuellement connecté.

         La sécurité principale est assurée dans
         MemberMessageController.
         ========================================================= -->
    <section
        class="
            min-h-[70vh]
            bg-zinc-950
            px-6
            py-16
            lg:px-8
            lg:py-20
        "
    >

        <div class="mx-auto max-w-7xl">


            <!-- =================================================
                 EN-TÊTE
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-6
                    border-b
                    border-zinc-800
                    pb-10
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
                            tracking-[0.35em]
                            text-red-500
                        "
                    >
                        Espace adhérent
                    </p>


                    <h1
                        class="
                            mt-4
                            text-4xl
                            font-black
                            uppercase
                            tracking-tight
                            text-white
                            sm:text-5xl
                        "
                    >
                        Mes messages
                    </h1>


                    <p
                        class="
                            mt-5
                            max-w-2xl
                            text-base
                            leading-7
                            text-zinc-400
                        "
                    >
                        Retrouvez ici vos conversations et les réponses
                        envoyées par l'administration Brussels Top Team.
                    </p>

                </div>


                <!-- =============================================
                     RETOUR ESPACE ADHÉRENT
                     ============================================= -->
                <div>

                    <a
                        href="{{ route('member.dashboard') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            border
                            border-zinc-700
                            px-5
                            py-3
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-300
                            transition
                            hover:border-red-600
                            hover:text-red-500
                        "
                    >
                        ← Mon espace
                    </a>

                </div>

            </div>


            <!-- =================================================
                 INFORMATIONS MESSAGERIE
                 ================================================= -->
            <div
                class="
                    mt-10
                    flex
                    flex-col
                    gap-5
                    border-l-4
                    border-red-600
                    bg-zinc-900
                    px-6
                    py-5
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
                            tracking-[0.25em]
                            text-red-500
                        "
                    >
                        Boîte de réception
                    </p>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-6
                            text-zinc-400
                        "
                    >
                        Une conversation marquée
                        <span class="font-bold text-red-400">
                            Nouveau
                        </span>
                        contient au moins une réponse de l'administration
                        que vous n'avez pas encore consultée.
                    </p>

                </div>


                <!-- =============================================
                     NOMBRE DE CONVERSATIONS
                     ============================================= -->
                <div class="shrink-0 sm:text-right">

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        Conversations
                    </p>


                    <p
                        class="
                            mt-1
                            text-2xl
                            font-black
                            text-white
                        "
                    >
                        {{ $conversations->total() }}
                    </p>

                </div>

            </div>


            <!-- =================================================
                 LISTE DES CONVERSATIONS
                 ================================================= -->
            <div class="mt-10">

                @if ($conversations->count() > 0)


                    <!-- =============================================
                         VERSION ORDINATEUR
                         ============================================= -->
                    <div
                        class="
                            hidden
                            overflow-hidden
                            rounded-lg
                            border
                            border-zinc-800
                            lg:block
                        "
                    >

                        <div class="overflow-x-auto">

                            <table class="w-full">


                                <!-- =====================================
                                     EN-TÊTE DU TABLEAU
                                     ===================================== -->
                                <thead class="bg-zinc-900">

                                    <tr class="border-b border-zinc-800">

                                        <th
                                            class="
                                                px-6
                                                py-4
                                                text-left
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
                                                px-6
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
                                                px-6
                                                py-4
                                                text-left
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
                                                px-6
                                                py-4
                                                text-left
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-500
                                            "
                                        >
                                            Dernière activité
                                        </th>


                                        <th
                                            class="
                                                px-6
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


                                <!-- =====================================
                                     CONVERSATIONS
                                     ===================================== -->
                                <tbody class="divide-y divide-zinc-800">

                                    @foreach ($conversations as $conversation)

                                        <tr
                                            class="
                                                bg-zinc-950
                                                transition
                                                hover:bg-zinc-900
                                            "
                                        >


                                            <!-- =========================
                                                 SUJET
                                                 ========================= -->
                                            <td class="px-6 py-5">

                                                <p
                                                    class="
                                                        text-sm
                                                        font-black
                                                        text-white
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


                                                <p
                                                    class="
                                                        mt-1
                                                        text-xs
                                                        text-zinc-600
                                                    "
                                                >
                                                    Conversation
                                                    #{{ $conversation->id }}
                                                </p>

                                            </td>


                                            <!-- =========================
                                                 STATUT DE LA CONVERSATION
                                                 ========================= -->
                                            <td class="px-6 py-5">

                                                @if ($conversation->status === 'open')

                                                    <span
                                                        class="
                                                            inline-flex
                                                            items-center
                                                            gap-2
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-green-500
                                                        "
                                                    >

                                                        <span
                                                            class="
                                                                h-2
                                                                w-2
                                                                rounded-full
                                                                bg-green-500
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
                                                            tracking-wider
                                                            text-zinc-500
                                                        "
                                                    >

                                                        <span
                                                            class="
                                                                h-2
                                                                w-2
                                                                rounded-full
                                                                bg-zinc-600
                                                            "
                                                        ></span>

                                                        Fermée

                                                    </span>

                                                @endif

                                            </td>


                                            <!-- =========================
                                                 ÉTAT DE LECTURE
                                                 =========================
                                                 Seules les réponses envoyées
                                                 par l'administration comptent
                                                 ici.
                                                 ========================= -->
                                            <td class="px-6 py-5">

                                                @if (
                                                    $conversation->unread_admin_messages_count > 0
                                                )

                                                    <span
                                                        class="
                                                            inline-flex
                                                            items-center
                                                            gap-2
                                                            rounded-full
                                                            bg-red-600/15
                                                            px-3
                                                            py-1.5
                                                            text-[10px]
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-red-400
                                                        "
                                                    >

                                                        <span
                                                            class="
                                                                h-2
                                                                w-2
                                                                rounded-full
                                                                bg-red-500
                                                            "
                                                        ></span>

                                                        Nouveau

                                                        @if (
                                                            $conversation
                                                                ->unread_admin_messages_count > 1
                                                        )

                                                            <span>
                                                                ({{ $conversation
                                                                    ->unread_admin_messages_count }})
                                                            </span>

                                                        @endif

                                                    </span>

                                                @else

                                                    <span
                                                        class="
                                                            inline-flex
                                                            items-center
                                                            gap-2
                                                            rounded-full
                                                            bg-zinc-900
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
                                                                bg-zinc-600
                                                            "
                                                        ></span>

                                                        Lu

                                                    </span>

                                                @endif

                                            </td>


                                            <!-- =========================
                                                 DERNIÈRE ACTIVITÉ
                                                 ========================= -->
                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-6
                                                    py-5
                                                    text-sm
                                                    font-bold
                                                    text-zinc-500
                                                "
                                            >
                                                {{ $conversation
                                                    ->updated_at
                                                    ->format('d/m/Y H:i') }}
                                            </td>


                                            <!-- =========================
                                                 ACTION
                                                 ========================= -->
                                            <td class="px-6 py-5 text-right">

                                                <a
                                                    href="{{ route(
                                                        'member.messages.show',
                                                        $conversation
                                                    ) }}"
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        justify-center
                                                        rounded-md
                                                        border
                                                        border-red-600/60
                                                        px-4
                                                        py-2.5
                                                        text-xs
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-red-500
                                                        transition
                                                        hover:bg-red-600
                                                        hover:text-white
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


                    <!-- =============================================
                         VERSION MOBILE / TABLETTE
                         ============================================= -->
                    <div class="space-y-4 lg:hidden">

                        @foreach ($conversations as $conversation)

                            <article
                                class="
                                    rounded-lg
                                    border
                                    border-zinc-800
                                    bg-zinc-900
                                    p-5
                                "
                            >


                                <!-- =====================================
                                     SUJET + LECTURE
                                     ===================================== -->
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
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-600
                                            "
                                        >
                                            Sujet
                                        </p>


                                        <h2
                                            class="
                                                mt-1
                                                font-black
                                                text-white
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
                                        </h2>

                                    </div>


                                    <!-- =================================
                                         BADGE NOUVEAU / LU
                                         ================================= -->
                                    <div class="shrink-0">

                                        @if (
                                            $conversation->unread_admin_messages_count > 0
                                        )

                                            <span
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-2
                                                    rounded-full
                                                    bg-red-600/15
                                                    px-3
                                                    py-1.5
                                                    text-[10px]
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-red-400
                                                "
                                            >

                                                <span
                                                    class="
                                                        h-2
                                                        w-2
                                                        rounded-full
                                                        bg-red-500
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
                                                    bg-zinc-950
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
                                                        bg-zinc-600
                                                    "
                                                ></span>

                                                Lu

                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <!-- =====================================
                                     INFORMATIONS
                                     ===================================== -->
                                <div
                                    class="
                                        mt-5
                                        grid
                                        grid-cols-2
                                        gap-5
                                        border-y
                                        border-zinc-800
                                        py-5
                                    "
                                >


                                    <!-- STATUT -->
                                    <div>

                                        <p
                                            class="
                                                text-[10px]
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-600
                                            "
                                        >
                                            Statut
                                        </p>


                                        @if ($conversation->status === 'open')

                                            <p
                                                class="
                                                    mt-2
                                                    text-sm
                                                    font-black
                                                    text-green-500
                                                "
                                            >
                                                Ouverte
                                            </p>

                                        @else

                                            <p
                                                class="
                                                    mt-2
                                                    text-sm
                                                    font-black
                                                    text-zinc-500
                                                "
                                            >
                                                Fermée
                                            </p>

                                        @endif

                                    </div>


                                    <!-- DERNIÈRE ACTIVITÉ -->
                                    <div>

                                        <p
                                            class="
                                                text-[10px]
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-600
                                            "
                                        >
                                            Dernière activité
                                        </p>


                                        <p
                                            class="
                                                mt-2
                                                text-sm
                                                font-bold
                                                text-zinc-400
                                            "
                                        >
                                            {{ $conversation
                                                ->updated_at
                                                ->format('d/m/Y H:i') }}
                                        </p>

                                    </div>

                                </div>


                                <!-- =====================================
                                     ACTION
                                     ===================================== -->
                                <div class="mt-5">

                                    <a
                                        href="{{ route(
                                            'member.messages.show',
                                            $conversation
                                        ) }}"
                                        class="
                                            inline-flex
                                            w-full
                                            items-center
                                            justify-center
                                            rounded-md
                                            bg-red-600
                                            px-5
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

                                </div>

                            </article>

                        @endforeach

                    </div>


                    <!-- =============================================
                         PAGINATION
                         ============================================= -->
                    @if ($conversations->hasPages())

                        <div class="mt-8">
                            {{ $conversations->links() }}
                        </div>

                    @endif


                @else


                    <!-- =============================================
                         AUCUNE CONVERSATION
                         ============================================= -->
                    <div
                        class="
                            rounded-lg
                            border
                            border-zinc-800
                            bg-zinc-900
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
                                tracking-[0.3em]
                                text-red-500
                            "
                        >
                            Messagerie BTT
                        </p>


                        <h2
                            class="
                                mt-4
                                text-2xl
                                font-black
                                uppercase
                                text-white
                            "
                        >
                            Aucune conversation
                        </h2>


                        <p
                            class="
                                mx-auto
                                mt-4
                                max-w-xl
                                text-sm
                                leading-7
                                text-zinc-500
                            "
                        >
                            Vous n'avez encore aucune conversation avec
                            l'administration Brussels Top Team.
                        </p>


                        <!-- =========================================
                             CONTACTER L'ADMINISTRATION
                             =========================================
                             Pour le moment, une nouvelle conversation
                             est créée depuis le formulaire Contact.
                             ========================================= -->
                        <a
                            href="{{ route('contact') }}"
                            class="
                                mt-7
                                inline-flex
                                items-center
                                justify-center
                                rounded-md
                                bg-red-600
                                px-6
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
                            Contacter l'administration
                        </a>

                    </div>

                @endif

            </div>


            <!-- =================================================
                 AIDE SUR LES STATUTS
                 ================================================= -->
            @if ($conversations->count() > 0)

                <div
                    class="
                        mt-10
                        border-t
                        border-zinc-800
                        pt-8
                    "
                >

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.25em]
                            text-zinc-600
                        "
                    >
                        Comprendre les statuts
                    </p>


                    <div
                        class="
                            mt-5
                            grid
                            gap-6
                            sm:grid-cols-2
                        "
                    >


                        <!-- NOUVEAU / LU -->
                        <div>

                            <p class="font-black text-white">
                                Nouveau / Lu
                            </p>


                            <p
                                class="
                                    mt-2
                                    text-sm
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                Indique si une nouvelle réponse de
                                l'administration attend d'être consultée.
                            </p>

                        </div>


                        <!-- OUVERTE / FERMÉE -->
                        <div>

                            <p class="font-black text-white">
                                Ouverte / Fermée
                            </p>


                            <p
                                class="
                                    mt-2
                                    text-sm
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                Une conversation ouverte peut recevoir de
                                nouveaux messages. Une conversation fermée
                                reste consultable mais ne peut plus recevoir
                                de réponse.
                            </p>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </section>

@endsection