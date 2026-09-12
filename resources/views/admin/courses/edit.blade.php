@extends('layouts.app')


@section('title', 'Modifier un cours - BTT Admin')


@section(
    'meta_description',
    'Modification d’un entraînement Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         MODIFICATION D'UN COURS
         ========================================================= -->
    <section class="min-h-screen bg-white text-zinc-900">

        <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">


            <!-- =================================================
                 EN-TÊTE
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-5
                    border-b
                    border-zinc-200
                    pb-8
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
                            tracking-[0.3em]
                            text-red-600
                        "
                    >
                        Administration
                    </p>


                    <h1
                        class="
                            mt-2
                            text-3xl
                            font-black
                            uppercase
                            tracking-tight
                            text-zinc-900
                        "
                    >
                        Modifier un cours
                    </h1>


                    <p class="mt-3 text-sm text-zinc-500">
                        Modifiez les informations de l'entraînement sélectionné.
                    </p>

                </div>


                <a
                    href="{{ route('admin.courses.index') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-md
                        border
                        border-zinc-300
                        px-4
                        py-2.5
                        text-sm
                        font-bold
                        text-zinc-700
                        transition
                        hover:bg-zinc-100
                    "
                >
                    ← Retour au calendrier
                </a>

            </div>


            <!-- =================================================
                 INFORMATIONS SUR LES DROITS
                 ================================================= -->
            <div class="mt-8">

                @if (auth()->user()->isSuperAdmin())

                    <div
                        class="
                            border
                            border-red-200
                            bg-red-50
                            px-5
                            py-4
                            text-sm
                            text-red-800
                        "
                    >
                        En tant que
                        <strong>Super Admin</strong>,
                        vous pouvez modifier la catégorie Homme ou Femme.
                    </div>

                @else

                    <div
                        class="
                            border
                            border-zinc-200
                            bg-zinc-50
                            px-5
                            py-4
                            text-sm
                            text-zinc-700
                        "
                    >
                        Ce cours reste obligatoirement dans votre catégorie :

                        <strong>
                            {{ $forcedGender === 'homme' ? 'Homme' : 'Femme' }}
                        </strong>.
                    </div>

                @endif

            </div>


            <!-- =================================================
                 ERREURS DE VALIDATION
                 ================================================= -->
            @if ($errors->any())

                <div
                    class="
                        mt-8
                        border
                        border-red-200
                        bg-red-50
                        px-5
                        py-4
                        text-sm
                        text-red-700
                    "
                >

                    <p class="font-black">
                        Certains champs doivent être corrigés :
                    </p>

                    <ul class="mt-3 list-disc space-y-1 pl-5">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- =================================================
                 FORMULAIRE
                 ================================================= -->
            <form
                action="{{ route('admin.courses.update', $course) }}"
                method="POST"
                class="
                    mt-8
                    border
                    border-zinc-200
                    bg-zinc-50
                    p-6
                    sm:p-8
                "
            >

                @csrf
                @method('PATCH')


                <div
                    class="
                        grid
                        gap-6
                        md:grid-cols-2
                    "
                >


                    <!-- =========================================
                         TITRE
                         ========================================= -->
                    <div class="md:col-span-2">

                        <label
                            for="title"
                            class="
                                mb-2
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Titre du cours
                        </label>


                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $course->title) }}"
                            required
                            maxlength="150"
                            class="
                                w-full
                                rounded-md
                                border
                                border-zinc-300
                                bg-white
                                px-4
                                py-3
                                text-zinc-900
                                outline-none
                                focus:border-red-600
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                    </div>


                    <!-- =========================================
                         DISCIPLINE
                         ========================================= -->
                    <div>

                        <label
                            for="discipline"
                            class="
                                mb-2
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Discipline
                        </label>


                        <input
                            type="text"
                            id="discipline"
                            name="discipline"
                            value="{{ old('discipline', $course->discipline) }}"
                            required
                            maxlength="100"
                            class="
                                w-full
                                rounded-md
                                border
                                border-zinc-300
                                bg-white
                                px-4
                                py-3
                                text-zinc-900
                                outline-none
                                focus:border-red-600
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                    </div>


                    <!-- =========================================
                         DATE
                         ========================================= -->
                    <div>

                        <label
                            for="course_date"
                            class="
                                mb-2
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Date
                        </label>


                        <input
                            type="date"
                            id="course_date"
                            name="course_date"
                            value="{{ old(
                                'course_date',
                                $course->course_date->format('Y-m-d')
                            ) }}"
                            required
                            class="
                                w-full
                                rounded-md
                                border
                                border-zinc-300
                                bg-white
                                px-4
                                py-3
                                text-zinc-900
                                outline-none
                                focus:border-red-600
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                    </div>


                    <!-- =========================================
                         CATÉGORIE
                         ========================================= -->
                    @if (auth()->user()->isSuperAdmin())

                        <div>

                            <label
                                for="target_gender"
                                class="
                                    mb-2
                                    block
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-600
                                "
                            >
                                Catégorie
                            </label>


                            <select
                                id="target_gender"
                                name="target_gender"
                                required
                                class="
                                    w-full
                                    rounded-md
                                    border
                                    border-zinc-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-zinc-900
                                    outline-none
                                    focus:border-red-600
                                    focus:ring-1
                                    focus:ring-red-600
                                "
                            >

                                <option
                                    value="homme"
                                    @selected(
                                        old(
                                            'target_gender',
                                            $course->target_gender
                                        ) === 'homme'
                                    )
                                >
                                    Homme
                                </option>

                                <option
                                    value="femme"
                                    @selected(
                                        old(
                                            'target_gender',
                                            $course->target_gender
                                        ) === 'femme'
                                    )
                                >
                                    Femme
                                </option>

                            </select>

                        </div>

                    @else

                        <div>

                            <p
                                class="
                                    mb-2
                                    block
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-600
                                "
                            >
                                Catégorie
                            </p>


                            <div
                                class="
                                    rounded-md
                                    border
                                    border-zinc-200
                                    bg-zinc-100
                                    px-4
                                    py-3
                                    font-bold
                                    text-zinc-700
                                "
                            >
                                {{ $forcedGender === 'homme' ? 'Homme' : 'Femme' }}
                            </div>

                        </div>

                    @endif


                    <!-- =========================================
                         HEURE DE DÉBUT
                         ========================================= -->
                    <div>

                        <label
                            for="start_time"
                            class="
                                mb-2
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Heure de début
                        </label>


                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            value="{{ old(
                                'start_time',
                                substr($course->start_time, 0, 5)
                            ) }}"
                            required
                            class="
                                w-full
                                rounded-md
                                border
                                border-zinc-300
                                bg-white
                                px-4
                                py-3
                                text-zinc-900
                                outline-none
                                focus:border-red-600
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                    </div>


                    <!-- =========================================
                         HEURE DE FIN
                         ========================================= -->
                    <div>

                        <label
                            for="end_time"
                            class="
                                mb-2
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Heure de fin
                        </label>


                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            value="{{ old(
                                'end_time',
                                substr($course->end_time, 0, 5)
                            ) }}"
                            required
                            class="
                                w-full
                                rounded-md
                                border
                                border-zinc-300
                                bg-white
                                px-4
                                py-3
                                text-zinc-900
                                outline-none
                                focus:border-red-600
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                    </div>


                    <!-- =========================================
                         DESCRIPTION
                         ========================================= -->
                    <div class="md:col-span-2">

                        <label
                            for="description"
                            class="
                                mb-2
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Description
                        </label>


                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="
                                w-full
                                rounded-md
                                border
                                border-zinc-300
                                bg-white
                                px-4
                                py-3
                                text-zinc-900
                                outline-none
                                focus:border-red-600
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >{{ old('description', $course->description) }}</textarea>

                    </div>


                    <!-- =========================================
                         STATUT
                         ========================================= -->
                    <div class="md:col-span-2">

                        <label
                            class="
                                flex
                                cursor-pointer
                                items-center
                                gap-3
                                border
                                border-zinc-200
                                bg-white
                                px-4
                                py-4
                            "
                        >

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked(
                                    old(
                                        'is_active',
                                        $course->is_active
                                    )
                                )
                                class="
                                    h-4
                                    w-4
                                    accent-red-600
                                "
                            >

                            <span>

                                <span class="block font-bold text-zinc-900">
                                    Cours actif
                                </span>

                                <span class="mt-1 block text-sm text-zinc-500">
                                    Le cours apparaît dans le calendrier des adhérents.
                                </span>

                            </span>

                        </label>

                    </div>

                </div>


                <!-- =================================================
                     ACTIONS
                     ================================================= -->
                <div
                    class="
                        mt-8
                        flex
                        flex-col
                        gap-3
                        border-t
                        border-zinc-200
                        pt-6
                        sm:flex-row
                        sm:justify-end
                    "
                >

                    <a
                        href="{{ route('admin.courses.index') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            border
                            border-zinc-300
                            px-5
                            py-3
                            text-sm
                            font-bold
                            text-zinc-700
                            transition
                            hover:bg-white
                        "
                    >
                        Annuler
                    </a>


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
                        "
                    >
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>

    </section>

@endsection