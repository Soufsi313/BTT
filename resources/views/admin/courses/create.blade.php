@extends('layouts.app')


@section('title', 'Ajouter un cours - Administration BTT')


@section(
    'meta_description',
    'Ajouter un entraînement au calendrier Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         ADMINISTRATION - AJOUTER UN COURS
         ========================================================= -->
    <section class="min-h-screen bg-white px-6 py-10 text-zinc-900 lg:px-10">

        <div class="mx-auto max-w-4xl">


            <!-- =================================================
                 EN-TÊTE DE LA PAGE
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-6
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
                        Ajouter un cours
                    </h1>

                    <p
                        class="
                            mt-3
                            max-w-2xl
                            text-sm
                            leading-6
                            text-zinc-500
                        "
                    >
                        Ajoutez un nouvel entraînement au calendrier privé
                        des adhérents Brussels Top Team.
                    </p>

                </div>


                <!-- Retour vers le calendrier -->
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
                        Vous êtes <strong>Super Admin</strong>.

                        Vous pouvez créer un cours pour la catégorie
                        <strong>Homme</strong> ou
                        <strong>Femme</strong>.
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
                        Le cours sera automatiquement créé pour votre catégorie :

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
                        Le formulaire contient une ou plusieurs erreurs.
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
                 FORMULAIRE DE CRÉATION
                 ================================================= -->
            <form
                method="POST"
                action="{{ route('admin.courses.store') }}"
                class="mt-8 space-y-8"
            >

                @csrf


                <!-- =================================================
                     INFORMATIONS PRINCIPALES
                     ================================================= -->
                <div
                    class="
                        border
                        border-zinc-200
                        bg-zinc-50
                        p-6
                    "
                >

                    <h2
                        class="
                            text-lg
                            font-black
                            uppercase
                            tracking-tight
                            text-zinc-900
                        "
                    >
                        Informations du cours
                    </h2>

                    <div class="mt-6 grid gap-6 md:grid-cols-2">


                        <!-- Titre -->
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
                                Nom du cours
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                maxlength="150"
                                required
                                placeholder="Ex. Boxe anglaise"
                                class="
                                    w-full
                                    rounded-md
                                    border
                                    border-zinc-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-zinc-900
                                    outline-none
                                    transition
                                    focus:border-red-600
                                "
                            >

                        </div>


                        <!-- Discipline -->
                        <div class="md:col-span-2">

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
                                value="{{ old('discipline') }}"
                                maxlength="100"
                                required
                                placeholder="Ex. Boxe, HYROX, Futsal..."
                                class="
                                    w-full
                                    rounded-md
                                    border
                                    border-zinc-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-zinc-900
                                    outline-none
                                    transition
                                    focus:border-red-600
                                "
                            >

                        </div>


                        <!-- Date -->
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
                                value="{{ old('course_date') }}"
                                required
                                class="
                                    w-full
                                    rounded-md
                                    border
                                    border-zinc-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-zinc-900
                                    outline-none
                                    transition
                                    focus:border-red-600
                                "
                            >

                        </div>


                        <!-- Catégorie -->
                        <div>

                            <label
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


                            @if (auth()->user()->isSuperAdmin())

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
                                        text-sm
                                        text-zinc-900
                                        outline-none
                                        transition
                                        focus:border-red-600
                                    "
                                >

                                    <option value="">
                                        Sélectionner une catégorie
                                    </option>

                                    <option
                                        value="homme"
                                        @selected(old('target_gender') === 'homme')
                                    >
                                        Homme
                                    </option>

                                    <option
                                        value="femme"
                                        @selected(old('target_gender') === 'femme')
                                    >
                                        Femme
                                    </option>

                                </select>

                            @else

                                <div
                                    class="
                                        rounded-md
                                        border
                                        border-zinc-300
                                        bg-zinc-100
                                        px-4
                                        py-3
                                        text-sm
                                        font-bold
                                        text-zinc-700
                                    "
                                >
                                    {{ $forcedGender === 'homme' ? 'Homme' : 'Femme' }}
                                </div>

                                <p class="mt-2 text-xs leading-5 text-zinc-500">
                                    Cette catégorie est automatiquement définie
                                    selon votre compte administrateur.
                                </p>

                            @endif

                        </div>


                        <!-- Heure de début -->
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
                                value="{{ old('start_time') }}"
                                required
                                class="
                                    w-full
                                    rounded-md
                                    border
                                    border-zinc-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-zinc-900
                                    outline-none
                                    transition
                                    focus:border-red-600
                                "
                            >

                        </div>


                        <!-- Heure de fin -->
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
                                value="{{ old('end_time') }}"
                                required
                                class="
                                    w-full
                                    rounded-md
                                    border
                                    border-zinc-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-zinc-900
                                    outline-none
                                    transition
                                    focus:border-red-600
                                "
                            >

                        </div>


                        <!-- Description -->
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
                                <span class="font-normal normal-case text-zinc-400">
                                    (facultatif)
                                </span>
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Informations complémentaires sur l'entraînement..."
                                class="
                                    w-full
                                    resize-y
                                    rounded-md
                                    border
                                    border-zinc-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-zinc-900
                                    outline-none
                                    transition
                                    focus:border-red-600
                                "
                            >{{ old('description') }}</textarea>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     STATUT DU COURS
                     ================================================= -->
                <div
                    class="
                        border
                        border-zinc-200
                        bg-zinc-50
                        p-6
                    "
                >

                    <h2
                        class="
                            text-lg
                            font-black
                            uppercase
                            tracking-tight
                            text-zinc-900
                        "
                    >
                        Publication
                    </h2>

                    <div class="mt-5">

                        <label
                            for="is_active"
                            class="
                                flex
                                cursor-pointer
                                items-start
                                gap-3
                            "
                        >

                            <input
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', true))
                                class="
                                    mt-1
                                    h-4
                                    w-4
                                    accent-red-600
                                "
                            >

                            <span>

                                <span class="block text-sm font-black text-zinc-900">
                                    Cours actif
                                </span>

                                <span
                                    class="
                                        mt-1
                                        block
                                        text-sm
                                        leading-5
                                        text-zinc-500
                                    "
                                >
                                    Un cours actif apparaît automatiquement dans
                                    le calendrier des adhérents de la catégorie concernée.
                                </span>

                            </span>

                        </label>

                    </div>

                </div>


                <!-- =================================================
                     ACTIONS DU FORMULAIRE
                     ================================================= -->
                <div
                    class="
                        flex
                        flex-col-reverse
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
                            hover:bg-zinc-100
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
                        Ajouter le cours
                    </button>

                </div>

            </form>

        </div>

    </section>

@endsection