@extends('layouts.app')


@section('title', 'Conversation - Brussels Top Team')


@section(
    'meta_description',
    'Consultez votre conversation avec l’administration Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         CONVERSATION ADHÉRENT
         =========================================================
         Cette page affiche l'historique complet d'une conversation
         appartenant à l'utilisateur connecté.
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

        <div class="mx-auto max-w-5xl">

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
                            tracking-[0.35em]
                            text-red-500
                        "
                    >
                        Messagerie
                    </p>


                    <h1
                        class="
                            mt-4
                            text-3xl
                            font-black
                            uppercase
                            tracking-tight
                            text-white
                            sm:text-4xl
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
                    </h1>


                    <p class="mt-3 text-sm text-zinc-500">
                        Conversation #{{ $conversation->id }}
                    </p>

                </div>


                <a
                    href="{{ route('member.messages.index') }}"
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
                    ← Mes messages
                </a>

            </div>


            <!-- =================================================
                 MESSAGES FLASH
                 ================================================= -->
            @if (session('success'))

                <div
                    class="
                        mt-8
                        border-l-4
                        border-green-500
                        bg-green-500/10
                        px-5
                        py-4
                        text-sm
                        font-bold
                        text-green-400
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            @if (session('error'))

                <div
                    class="
                        mt-8
                        border-l-4
                        border-red-600
                        bg-red-600/10
                        px-5
                        py-4
                        text-sm
                        font-bold
                        text-red-400
                    "
                >
                    {{ session('error') }}
                </div>

            @endif


            <!-- =================================================
                 STATUT DE LA CONVERSATION
                 ================================================= -->
            <div
                class="
                    mt-8
                    flex
                    flex-col
                    gap-4
                    border
                    border-zinc-800
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
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        Statut de la conversation
                    </p>


                    <div class="mt-2">

                        @if ($conversation->status === 'open')

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    text-sm
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
                                    text-sm
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

                    </div>

                </div>


                <p class="text-sm text-zinc-500">
                    Dernière activité :
                    <span class="font-bold text-zinc-300">
                        {{ $conversation->updated_at->format('d/m/Y H:i') }}
                    </span>
                </p>

            </div>


            <!-- =================================================
                 HISTORIQUE DE LA CONVERSATION
                 ================================================= -->
            <div class="mt-10 space-y-6">

                @foreach ($conversation->messages as $message)

                    <!-- =============================================
                         MESSAGE DE L'ADMINISTRATION
                         =============================================
                         Fond sombre neutre pour améliorer le confort
                         de lecture.

                         On évite volontairement le rouge en fond.
                         ============================================= -->
                    @if ($message->sender_type === 'admin')

                        <div class="flex justify-start">

                            <div
                                class="
                                    max-w-3xl
                                    rounded-lg
                                    border
                                    border-zinc-700
                                    border-l-4
                                    bg-zinc-900
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
                                            text-zinc-300
                                        "
                                    >
                                        Administration BTT
                                    </p>


                                    <p class="text-xs text-zinc-600">
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                    </p>

                                </div>


                                <p
                                    class="
                                        mt-4
                                        whitespace-pre-line
                                        text-sm
                                        leading-7
                                        text-zinc-300
                                    "
                                >
                                    {{ $message->body }}
                                </p>

                            </div>

                        </div>


                    <!-- =============================================
                         MESSAGE DE L'ADHÉRENT
                         =============================================
                         Les messages de l'adhérent restent alignés
                         à droite pour les différencier.

                         Le fond rouge a été remplacé par un gris
                         légèrement plus clair que celui de l'admin.
                         ============================================= -->
                    @else

                        <div class="flex justify-end">

                            <div
                                class="
                                    max-w-3xl
                                    rounded-lg
                                    border
                                    border-zinc-700
                                    bg-zinc-800
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
                                            text-white
                                        "
                                    >
                                        Vous
                                    </p>


                                    <p class="text-xs text-zinc-500">
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                    </p>

                                </div>


                                <p
                                    class="
                                        mt-4
                                        whitespace-pre-line
                                        text-sm
                                        leading-7
                                        text-zinc-200
                                    "
                                >
                                    {{ $message->body }}
                                </p>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>


            <!-- =================================================
                 FORMULAIRE DE RÉPONSE
                 ================================================= -->
            @if ($conversation->status === 'open')

                <div
                    class="
                        mt-12
                        border-t
                        border-zinc-800
                        pt-10
                    "
                >

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.25em]
                            text-red-500
                        "
                    >
                        Répondre
                    </p>


                    <h2
                        class="
                            mt-3
                            text-2xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        Envoyer un message
                    </h2>


                    <form
                        action="{{ route(
                            'member.messages.reply',
                            $conversation
                        ) }}"
                        method="POST"
                        class="mt-7"
                    >

                        @csrf


                        <!-- =========================================
                             MESSAGE
                             ========================================= -->
                        <div>

                            <label
                                for="reply"
                                class="
                                    block
                                    text-sm
                                    font-black
                                    text-white
                                "
                            >
                                Votre message
                            </label>


                            <textarea
                                id="reply"
                                name="reply"
                                rows="7"
                                required
                                class="
                                    mt-3
                                    w-full
                                    rounded-md
                                    border
                                    border-zinc-700
                                    bg-zinc-900
                                    px-4
                                    py-3
                                    text-sm
                                    text-white
                                    outline-none
                                    transition
                                    placeholder:text-zinc-600
                                    focus:border-red-600
                                "
                                placeholder="Écrivez votre réponse..."
                            >{{ old('reply') }}</textarea>


                            @error('reply')

                                <p class="mt-2 text-sm font-bold text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <!-- =========================================
                             BOUTON D'ENVOI
                             ========================================= -->
                        <div class="mt-6 flex justify-end">

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
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-white
                                    transition
                                    hover:bg-red-700
                                "
                            >
                                Envoyer la réponse
                            </button>

                        </div>

                    </form>

                </div>


            <!-- =================================================
                 CONVERSATION FERMÉE
                 ================================================= -->
            @else

                <div
                    class="
                        mt-12
                        border-t
                        border-zinc-800
                        pt-10
                    "
                >

                    <div
                        class="
                            border-l-4
                            border-zinc-700
                            bg-zinc-900
                            px-6
                            py-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                font-black
                                uppercase
                                text-zinc-400
                            "
                        >
                            Conversation fermée
                        </p>


                        <p
                            class="
                                mt-2
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Cette conversation reste disponible dans votre
                            historique, mais il n'est plus possible d'y répondre.
                        </p>

                    </div>

                </div>

            @endif

        </div>

    </section>

@endsection