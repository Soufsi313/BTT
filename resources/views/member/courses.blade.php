@extends('layouts.app')


@section('title', 'Mon calendrier - Brussels Top Team')


@section(
    'meta_description',
    'Consultez votre calendrier privé des entraînements Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         CALENDRIER PRIVÉ DE L'ADHÉRENT
         ========================================================= -->
    <section class="min-h-[70vh] bg-zinc-950 px-4 py-12 sm:px-6 lg:px-8 lg:py-16">

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
                        Mon calendrier
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
                        Retrouvez les entraînements correspondant
                        à votre catégorie directement dans le calendrier.
                    </p>

                </div>


                <!-- =============================================
                     CATÉGORIE
                     ============================================= -->
                <div class="border-l-2 border-red-600 pl-5">

                    <p
                        class="
                            text-xs
                            font-bold
                            uppercase
                            tracking-wider
                            text-zinc-500
                        "
                    >
                        Catégorie
                    </p>

                    <p
                        class="
                            mt-1
                            text-lg
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        @if (auth()->user()->genre === 'homme')
                            Homme
                        @else
                            Femme
                        @endif
                    </p>

                </div>

            </div>


            <!-- =================================================
                 NAVIGATION DU CALENDRIER
                 ================================================= -->
            <div
                class="
                    mt-10
                    flex
                    flex-col
                    gap-6
                    lg:flex-row
                    lg:items-center
                    lg:justify-between
                "
            >

                <!-- =============================================
                     MOIS AFFICHÉ
                     ============================================= -->
                <div>

                    <p
                        class="
                            text-xs
                            font-black
                            uppercase
                            tracking-[0.3em]
                            text-red-500
                        "
                    >
                        Calendrier
                    </p>

                    <h2
                        class="
                            mt-2
                            text-3xl
                            font-black
                            uppercase
                            text-white
                        "
                    >
                        {{ $monthName }}
                    </h2>

                </div>


                <!-- =============================================
                     BOUTONS DE NAVIGATION
                     ============================================= -->
                <div
                    class="
                        flex
                        flex-wrap
                        items-center
                        gap-3
                    "
                >

                    <!-- =========================================
                         MOIS PRÉCÉDENT
                         ========================================= -->
                    <a
                        href="{{ route('member.courses', [
                            'month' => $previousMonth->month,
                            'year' => $previousMonth->year,
                        ]) }}"
                        class="
                            inline-flex
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
                            text-zinc-300
                            transition
                            hover:border-red-600
                            hover:text-white
                        "
                    >
                        ← Mois précédent
                    </a>


                    <!-- =========================================
                         RETOUR AU MOIS ACTUEL
                         ========================================= -->
                    <a
                        href="{{ route('member.courses') }}"
                        class="
                            inline-flex
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
                        Aujourd'hui
                    </a>


                    <!-- =========================================
                         MOIS SUIVANT
                         ========================================= -->
                    <a
                        href="{{ route('member.courses', [
                            'month' => $nextMonth->month,
                            'year' => $nextMonth->year,
                        ]) }}"
                        class="
                            inline-flex
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
                            text-zinc-300
                            transition
                            hover:border-red-600
                            hover:text-white
                        "
                    >
                        Mois suivant →
                    </a>

                </div>

            </div>


            <!-- =================================================
                 DATE DU JOUR
                 ================================================= -->
            <div class="mt-6">

                <p class="text-sm text-zinc-500">

                    Aujourd'hui :

                    <span class="font-bold text-white">
                        {{ $today->locale('fr')->translatedFormat('d F Y') }}
                    </span>

                </p>

            </div>


            <!-- =================================================
                 CALENDRIER
                 ================================================= -->
            <div
                class="
                    mt-8
                    overflow-x-auto
                    border
                    border-zinc-800
                    bg-zinc-900
                "
            >

                <div class="min-w-[900px]">


                    <!-- =========================================
                         JOURS DE LA SEMAINE
                         ========================================= -->
                    <div
                        class="
                            grid
                            grid-cols-7
                            border-b
                            border-zinc-800
                            bg-black
                        "
                    >

                        @foreach ([
                            'Lundi',
                            'Mardi',
                            'Mercredi',
                            'Jeudi',
                            'Vendredi',
                            'Samedi',
                            'Dimanche'
                        ] as $dayName)

                            <div
                                class="
                                    border-r
                                    border-zinc-800
                                    px-3
                                    py-4
                                    text-center
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-400
                                    last:border-r-0
                                "
                            >
                                {{ $dayName }}
                            </div>

                        @endforeach

                    </div>


                    <!-- =========================================
                         GRILLE DU CALENDRIER
                         ========================================= -->
                    <div class="grid grid-cols-7">


                        <!-- =====================================
                             CASES VIDES AVANT LE JOUR 1
                             ===================================== -->
                        @for ($emptyDay = 1; $emptyDay < $firstDayOfWeek; $emptyDay++)

                            <div
                                class="
                                    min-h-[150px]
                                    border-r
                                    border-b
                                    border-zinc-800
                                    bg-zinc-950/60
                                "
                            >
                            </div>

                        @endfor


                        <!-- =====================================
                             JOURS DU MOIS
                             ===================================== -->
                        @for ($day = 1; $day <= $daysInMonth; $day++)

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | DATE DE LA CASE
                                |--------------------------------------------------------------------------
                                */
                                $date = $currentMonth
                                    ->copy()
                                    ->day($day);

                                $dateKey = $date->format('Y-m-d');


                                /*
                                |--------------------------------------------------------------------------
                                | JOUR ACTUEL
                                |--------------------------------------------------------------------------
                                */
                                $isToday = $date->isSameDay($today);


                                /*
                                |--------------------------------------------------------------------------
                                | COURS DU JOUR
                                |--------------------------------------------------------------------------
                                */
                                $dayCourses = $coursesByDate->get(
                                    $dateKey,
                                    collect()
                                );

                            @endphp


                            <div
                                class="
                                    relative
                                    min-h-[150px]
                                    border-r
                                    border-b
                                    border-zinc-800
                                    p-3

                                    @if ($isToday)
                                        bg-red-950/30
                                    @else
                                        bg-zinc-900
                                    @endif
                                "
                            >


                                <!-- =============================
                                     NUMÉRO DU JOUR
                                     ============================= -->
                                <div
                                    class="
                                        flex
                                        items-center
                                        justify-between
                                    "
                                >

                                    <span
                                        class="
                                            flex
                                            h-9
                                            w-9
                                            items-center
                                            justify-center
                                            rounded-full
                                            text-sm
                                            font-black

                                            @if ($isToday)
                                                bg-red-600
                                                text-white
                                            @else
                                                text-zinc-300
                                            @endif
                                        "
                                    >
                                        {{ $day }}
                                    </span>


                                    @if ($isToday)

                                        <span
                                            class="
                                                text-[10px]
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-red-500
                                            "
                                        >
                                            Aujourd'hui
                                        </span>

                                    @endif

                                </div>


                                <!-- =============================
                                     COURS DU JOUR
                                     ============================= -->
                                @if ($dayCourses->isNotEmpty())

                                    <div class="mt-4 space-y-2">

                                        @foreach ($dayCourses as $course)

                                            <div
                                                class="
                                                    border-l-2
                                                    border-red-600
                                                    bg-black/40
                                                    px-3
                                                    py-2
                                                "
                                            >

                                                <!-- =====================
                                                     DISCIPLINE
                                                     ===================== -->
                                                <p
                                                    class="
                                                        text-[10px]
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-red-500
                                                    "
                                                >
                                                    {{ $course->discipline }}
                                                </p>


                                                <!-- =====================
                                                     TITRE DU COURS
                                                     ===================== -->
                                                <p
                                                    class="
                                                        mt-1
                                                        text-sm
                                                        font-black
                                                        uppercase
                                                        text-white
                                                    "
                                                >
                                                    {{ $course->title }}
                                                </p>


                                                <!-- =====================
                                                     HORAIRE
                                                     ===================== -->
                                                <p
                                                    class="
                                                        mt-1
                                                        text-xs
                                                        text-zinc-400
                                                    "
                                                >
                                                    {{ substr($course->start_time, 0, 5) }}

                                                    -

                                                    {{ substr($course->end_time, 0, 5) }}
                                                </p>


                                                <!-- =====================
                                                     STATUT DU COURS
                                                     ===================== -->
                                                <div class="mt-2">

                                                    <!-- =================================
                                                         COURS TERMINÉ
                                                         ================================= -->
                                                    @if ($course->hasEnded())

                                                        <span
                                                            class="
                                                                inline-flex
                                                                rounded-full
                                                                bg-blue-500/15
                                                                px-2.5
                                                                py-1
                                                                text-[9px]
                                                                font-black
                                                                uppercase
                                                                tracking-wider
                                                                text-blue-400
                                                            "
                                                        >
                                                            Terminé
                                                        </span>


                                                    <!-- =================================
                                                         COURS ACTIF
                                                         ================================= -->
                                                    @else

                                                        <span
                                                            class="
                                                                inline-flex
                                                                rounded-full
                                                                bg-green-500/15
                                                                px-2.5
                                                                py-1
                                                                text-[9px]
                                                                font-black
                                                                uppercase
                                                                tracking-wider
                                                                text-green-400
                                                            "
                                                        >
                                                            Actif
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        @endfor


                        <!-- =====================================
                             CASES VIDES APRÈS LE DERNIER JOUR
                             ===================================== -->
                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | NOMBRE DE CASES UTILISÉES
                            |--------------------------------------------------------------------------
                            */
                            $usedCells = ($firstDayOfWeek - 1) + $daysInMonth;


                            /*
                            |--------------------------------------------------------------------------
                            | CASES RESTANTES POUR TERMINER LA LIGNE
                            |--------------------------------------------------------------------------
                            */
                            $remainingCells = (7 - ($usedCells % 7)) % 7;

                        @endphp


                        @for ($emptyDay = 0; $emptyDay < $remainingCells; $emptyDay++)

                            <div
                                class="
                                    min-h-[150px]
                                    border-r
                                    border-b
                                    border-zinc-800
                                    bg-zinc-950/60
                                "
                            >
                            </div>

                        @endfor

                    </div>

                </div>

            </div>


            <!-- =================================================
                 LÉGENDE
                 ================================================= -->
            <div
                class="
                    mt-6
                    flex
                    flex-wrap
                    gap-x-8
                    gap-y-3
                    text-sm
                    text-zinc-500
                "
            >

                <!-- =============================================
                     DATE DU JOUR
                     ============================================= -->
                <div class="flex items-center gap-2">

                    <span
                        class="
                            h-3
                            w-3
                            rounded-full
                            bg-red-600
                        "
                    >
                    </span>

                    <span>
                        Date du jour
                    </span>

                </div>


                <!-- =============================================
                     ENTRAÎNEMENT PROGRAMMÉ
                     ============================================= -->
                <div class="flex items-center gap-2">

                    <span class="h-4 w-1 bg-red-600">
                    </span>

                    <span>
                        Entraînement programmé
                    </span>

                </div>


                <!-- =============================================
                     COURS ACTIF
                     ============================================= -->
                <div class="flex items-center gap-2">

                    <span
                        class="
                            h-3
                            w-3
                            rounded-full
                            bg-green-500
                        "
                    >
                    </span>

                    <span>
                        Cours actif
                    </span>

                </div>


                <!-- =============================================
                     COURS TERMINÉ
                     ============================================= -->
                <div class="flex items-center gap-2">

                    <span
                        class="
                            h-3
                            w-3
                            rounded-full
                            bg-blue-500
                        "
                    >
                    </span>

                    <span>
                        Cours terminé
                    </span>

                </div>

            </div>

        </div>

    </section>

@endsection