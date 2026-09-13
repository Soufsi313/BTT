@extends('layouts.app')


@section('title', 'Mes messages - Brussels Top Team')


@section(
    'meta_description',
    'Consultez vos conversations privées avec l’administration Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         MESSAGERIE PRIVÉE DE L'ADHÉRENT
         =========================================================
         Cette page affiche uniquement les conversations appartenant
         à l'utilisateur actuellement connecté.

         L'adhérent peut également démarrer une nouvelle conversation
         avec l'administration grâce au bouton placé dans l'en-tête.
         ========================================================= -->
    <section
        class="
            min-h-[70vh]
            bg-zinc-950
            px-4
            py-12
            sm:px-6
            lg:px-8
            lg:py-16
        "
    >

        <div class="mx-auto max-w-7xl">


            <!-- =================================================
                 RETOUR À L'ESPACE ADHÉRENT
                 ================================================= -->
            <a
                href="{{ route('member.dashboard') }}"
                class="
                    inline-flex
                    items-center
                    gap-2
                    text-sm
                    font-bold
                    text-zinc-400
                    transition
                    hover:text-red-500
                "
            >
                ← Retour à mon espace
            </a>


            <!-- =================================================
                 EN-TÊTE
                 ================================================= -->
            <div
                class="
                    mt-8
                    flex
                    flex-col
                    gap-6
                    border-b
                    border-zinc-800
                    pb-8
                    lg:flex-row
                    lg:items-end
                    lg:justify-between
                "
            >

                <!-- =============================================
                     TITRE
                     ============================================= -->
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
                            mt-4
                            max-w-2xl
                            text-sm
                            leading-6
                            text-zinc-400
                            sm:text-base
                        "
                    >
                        Retrouvez ici vos conversations privées avec
                        l'administration Brussels Top Team.
                    </p>

                </div>


                <!-- =============================================
                     NOUVELLE CONVERSATION
                     =============================================
                     L'adhérent peut maintenant démarrer une nouvelle
                     demande directement depuis sa messagerie privée.
                     ============================================= -->
                <div>

                    <a
                        href="{{ route('member.messages.create') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            gap-2
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

                        <!-- ICÔNE + -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 5v14M5 12h14"
                            />
                        </svg>

                        Nouvelle conversation

                    </a>

                </div>

            </div>


            <!-- =================================================
                 RÉSUMÉ DE LA MESSAGERIE
                 ================================================= -->
            <div
                class="
                    mt-8
                    flex
                    flex-col
                    gap-4
                    border-l-2
                    border-red-600
                    pl-5
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


                <p
                    class="
                        max-w-xl
                        text-sm
                        leading-6
                        text-zinc-500
                    "
                >
                    Les nouvelles réponses de l'administration apparaissent
                    automatiquement comme non lues jusqu'à leur consultation.
                </p>

            </div>


            <!-- =================================================
                 LISTE DES CONVERSATIONS
                 ================================================= -->
            <div class="mt-10">


                @if ($conversations->count() > 0)


                    <!-- =================================================
                         VERSION DESKTOP
                         ================================================= -->
                    <div
                        class="
                            hidden
                            overflow-hidden
                            border
                            border-zinc-800
                            lg:block
                        "
                    >

                        <table class="w-full text-left">

                            <!-- =========================================
                                 EN-TÊTE DU TABLEAU
                                 ========================================= -->
                            <thead class="bg-zinc-900">

                                <tr
                                    class="
                                        border-b
                                        border-zinc-800
                                    "
                                >

                                    <th
                                        class="
                                            px-6
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
                                            px-6
                                            py-4
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


                            <!-- =========================================
                                 CONVERSATIONS
                                 ========================================= -->
                            <tbody class="divide-y divide-zinc-800">

                                @foreach ($conversations as $conversation)

                                    <tr
                                        class="
                                            bg-zinc-950
                                            transition
                                            hover:bg-zinc-900
                                        "
                                    >


                                        <!-- =================================
                                             SUJET
                                             ================================= -->
                                        <td class="px-6 py-5">

                                            <div>

                                                <p
                                                    class="
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

                                            </div>

                                        </td>


                                        <!-- =================================
                                             STATUT
                                             ================================= -->
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


                                        <!-- =================================
                                             LECTURE
                                             ================================= -->
                                        <td class="px-6 py-5">

                                            @if (
                                                $conversation
                                                    ->unread_admin_messages_count > 0
                                            )

                                                <!-- =========================
                                                     NOUVELLE RÉPONSE
                                                     ========================= -->
                                                <span
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        gap-2
                                                        rounded-full
                                                        bg-green-500/10
                                                        px-3
                                                        py-1.5
                                                        text-xs
                                                        font-black
                                                        uppercase
                                                        text-green-500
                                                    "
                                                >

                                                    <!-- Pastille -->
                                                    <span
                                                        class="
                                                            relative
                                                            flex
                                                            h-2
                                                            w-2
                                                        "
                                                    >

                                                        <span
                                                            class="
                                                                absolute
                                                                inline-flex
                                                                h-full
                                                                w-full
                                                                animate-ping
                                                                rounded-full
                                                                bg-green-400
                                                                opacity-75
                                                            "
                                                        ></span>

                                                        <span
                                                            class="
                                                                relative
                                                                inline-flex
                                                                h-2
                                                                w-2
                                                                rounded-full
                                                                bg-green-500
                                                            "
                                                        ></span>

                                                    </span>


                                                    Nouveau

                                                    @if (
                                                        $conversation
                                                            ->unread_admin_messages_count > 1
                                                    )

                                                        <span>
                                                            {{
                                                                $conversation
                                                                    ->unread_admin_messages_count
                                                            }}
                                                        </span>

                                                    @endif

                                                </span>

                                            @else

                                                <!-- =========================
                                                     AUCUNE RÉPONSE NON LUE
                                                     ========================= -->
                                                <span
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        gap-2
                                                        text-xs
                                                        font-bold
                                                        uppercase
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


                                        <!-- =================================
                                             DERNIÈRE ACTIVITÉ
                                             ================================= -->
                                        <td
                                            class="
                                                px-6
                                                py-5
                                                text-sm
                                                text-zinc-400
                                            "
                                        >
                                            {{
                                                $conversation
                                                    ->updated_at
                                                    ->format('d/m/Y H:i')
                                            }}
                                        </td>


                                        <!-- =================================
                                             ACTION
                                             ================================= -->
                                        <td
                                            class="
                                                px-6
                                                py-5
                                                text-right
                                            "
                                        >

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
                                                    border-zinc-700
                                                    px-4
                                                    py-2.5
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
                                                Ouvrir
                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    <!-- =================================================
                         VERSION MOBILE / TABLETTE
                         ================================================= -->
                    <div
                        class="
                            space-y-4
                            lg:hidden
                        "
                    >

                        @foreach ($conversations as $conversation)

                            <div
                                class="
                                    border
                                    border-zinc-800
                                    bg-zinc-900
                                    p-5
                                "
                            >


                                <!-- =====================================
                                     SUJET + NOTIFICATION
                                     ===================================== -->
                                <div
                                    class="
                                        flex
                                        items-start
                                        justify-between
                                        gap-4
                                    "
                                >

                                    <div>

                                        <p
                                            class="
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

                                    </div>


                                    @if (
                                        $conversation
                                            ->unread_admin_messages_count > 0
                                    )

                                        <!-- =============================
                                             PASTILLE NOUVEAU
                                             ============================= -->
                                        <span
                                            class="
                                                relative
                                                flex
                                                h-3
                                                w-3
                                                shrink-0
                                            "
                                        >

                                            <span
                                                class="
                                                    absolute
                                                    inline-flex
                                                    h-full
                                                    w-full
                                                    animate-ping
                                                    rounded-full
                                                    bg-green-400
                                                    opacity-75
                                                "
                                            ></span>

                                            <span
                                                class="
                                                    relative
                                                    inline-flex
                                                    h-3
                                                    w-3
                                                    rounded-full
                                                    bg-green-500
                                                "
                                            ></span>

                                        </span>

                                    @endif

                                </div>


                                <!-- =====================================
                                     INFORMATIONS
                                     ===================================== -->
                                <div
                                    class="
                                        mt-5
                                        grid
                                        grid-cols-2
                                        gap-4
                                        border-t
                                        border-zinc-800
                                        pt-5
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


                                        <div class="mt-2">

                                            @if (
                                                $conversation->status
                                                === 'open'
                                            )

                                                <span
                                                    class="
                                                        text-xs
                                                        font-black
                                                        uppercase
                                                        text-green-500
                                                    "
                                                >
                                                    Ouverte
                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        text-xs
                                                        font-black
                                                        uppercase
                                                        text-zinc-500
                                                    "
                                                >
                                                    Fermée
                                                </span>

                                            @endif

                                        </div>

                                    </div>


                                    <!-- LECTURE -->
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
                                            Lecture
                                        </p>


                                        <div class="mt-2">

                                            @if (
                                                $conversation
                                                    ->unread_admin_messages_count
                                                > 0
                                            )

                                                <span
                                                    class="
                                                        text-xs
                                                        font-black
                                                        uppercase
                                                        text-green-500
                                                    "
                                                >
                                                    Nouveau
                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        text-xs
                                                        font-black
                                                        uppercase
                                                        text-zinc-500
                                                    "
                                                >
                                                    Lu
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>


                                <!-- =====================================
                                     DERNIÈRE ACTIVITÉ
                                     ===================================== -->
                                <div
                                    class="
                                        mt-5
                                        border-t
                                        border-zinc-800
                                        pt-5
                                    "
                                >

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
                                        {{
                                            $conversation
                                                ->updated_at
                                                ->format('d/m/Y H:i')
                                        }}
                                    </p>

                                </div>


                                <!-- =====================================
                                     OUVRIR
                                     ===================================== -->
                                <a
                                    href="{{ route(
                                        'member.messages.show',
                                        $conversation
                                    ) }}"
                                    class="
                                        mt-5
                                        flex
                                        w-full
                                        items-center
                                        justify-center
                                        rounded-md
                                        border
                                        border-zinc-700
                                        px-4
                                        py-3
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-white
                                        transition
                                        hover:border-red-600
                                        hover:text-red-500
                                    "
                                >
                                    Ouvrir la conversation
                                </a>

                            </div>

                        @endforeach

                    </div>


                    <!-- =================================================
                         PAGINATION
                         ================================================= -->
                    @if ($conversations->hasPages())

                        <div class="mt-10">
                            {{ $conversations->links() }}
                        </div>

                    @endif


                <!-- =================================================
                     AUCUNE CONVERSATION
                     ================================================= -->
                @else

                    <div
                        class="
                            border
                            border-zinc-800
                            bg-zinc-900
                            px-6
                            py-16
                            text-center
                        "
                    >

                        <!-- ICÔNE -->
                        <div
                            class="
                                mx-auto
                                flex
                                h-14
                                w-14
                                items-center
                                justify-center
                                rounded-full
                                border
                                border-zinc-700
                                text-zinc-500
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"
                                />
                            </svg>

                        </div>


                        <h2
                            class="
                                mt-6
                                text-xl
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
                                mt-3
                                max-w-lg
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Vous n'avez encore aucune conversation avec
                            l'administration Brussels Top Team.
                        </p>


                        <!-- =========================================
                             PREMIÈRE CONVERSATION
                             ========================================= -->
                        <a
                            href="{{ route('member.messages.create') }}"
                            class="
                                mt-7
                                inline-flex
                                items-center
                                justify-center
                                gap-2
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

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 5v14M5 12h14"
                                />
                            </svg>

                            Contacter l'administration

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </section>

@endsection