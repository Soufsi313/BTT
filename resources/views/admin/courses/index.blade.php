@extends('layouts.app')


@section('title', 'Calendrier des entraînements - BTT Admin')


@section(
    'meta_description',
    'Gestion du calendrier des entraînements Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         CALENDRIER ADMINISTRATION
         ========================================================= -->
    <section class="min-h-screen bg-white text-zinc-900">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">


            <!-- =================================================
                 EN-TÊTE
                 ================================================= -->
            <div
                class="
                    flex
                    flex-col
                    gap-6
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
                        Calendrier des entraînements
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
                        Gérez tous les entraînements qui apparaîtront
                        dans le calendrier privé des adhérents
                        Brussels Top Team.
                    </p>

                </div>


                <!-- =============================================
                     ACTIONS PRINCIPALES
                     ============================================= -->
                <div class="flex flex-wrap gap-3">

                    <a
                        href="{{ route('admin.dashboard') }}"
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
                        ← Tableau de bord
                    </a>


                    <a
                        href="{{ route('admin.courses.create') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            bg-red-600
                            px-5
                            py-2.5
                            text-sm
                            font-black
                            uppercase
                            tracking-wider
                            text-white
                            transition
                            hover:bg-red-700
                        "
                    >
                        + Ajouter un cours
                    </a>

                </div>

            </div>


            <!-- =================================================
                 MESSAGE DE CONFIRMATION
                 ================================================= -->
            @if (session('success'))

                <div
                    class="
                        mt-8
                        rounded-md
                        border
                        border-green-200
                        bg-green-50
                        px-5
                        py-4
                        text-sm
                        font-bold
                        text-green-700
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


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
                        Vous êtes
                        <strong>Super Admin</strong> :
                        vous pouvez consulter, ajouter, modifier et supprimer
                        les cours Homme et Femme.
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
                        Vous pouvez gérer uniquement les cours de votre catégorie :

                        <strong>
                            {{ auth()->user()->genre === 'homme' ? 'Homme' : 'Femme' }}
                        </strong>.
                    </div>

                @endif

            </div>


            <!-- =================================================
                 FILTRES
                 ================================================= -->
            <form
                method="GET"
                action="{{ route('admin.courses.index') }}"
                class="
                    mt-8
                    rounded-lg
                    border
                    border-zinc-200
                    bg-zinc-50
                    p-5
                "
            >

                <div
                    class="
                        grid
                        gap-4
                        md:grid-cols-2
                        xl:grid-cols-5
                    "
                >


                    <!-- =========================================
                         RECHERCHE
                         ========================================= -->
                    <div class="xl:col-span-2">

                        <label
                            for="search"
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
                            Rechercher
                        </label>


                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Titre, discipline ou description..."
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


                        <select
                            id="discipline"
                            name="discipline"
                            onchange="this.form.submit()"
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
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                            <option value="all">
                                Toutes
                            </option>


                            @foreach ($disciplines as $availableDiscipline)

                                <option
                                    value="{{ $availableDiscipline }}"
                                    @selected(
                                        $discipline === $availableDiscipline
                                    )
                                >
                                    {{ $availableDiscipline }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- =========================================
                         STATUT
                         ========================================= -->
                    <div>

                        <label
                            for="status"
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
                            Statut
                        </label>


                        <select
                            id="status"
                            name="status"
                            onchange="this.form.submit()"
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
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                            <option
                                value="all"
                                @selected($status === 'all')
                            >
                                Tous
                            </option>

                            <option
                                value="active"
                                @selected($status === 'active')
                            >
                                Actifs
                            </option>

                            <option
                                value="inactive"
                                @selected($status === 'inactive')
                            >
                                Inactifs
                            </option>

                        </select>

                    </div>


                    <!-- =========================================
                         TRI PAR DATE
                         ========================================= -->
                    <div>

                        <label
                            for="sort"
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


                        <select
                            id="sort"
                            name="sort"
                            onchange="this.form.submit()"
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
                                focus:ring-1
                                focus:ring-red-600
                            "
                        >

                            <option
                                value="asc"
                                @selected($sort === 'asc')
                            >
                                Plus proches
                            </option>

                            <option
                                value="desc"
                                @selected($sort === 'desc')
                            >
                                Plus éloignés
                            </option>

                        </select>

                    </div>

                </div>


                <!-- =================================================
                     DEUXIÈME LIGNE DES FILTRES
                     ================================================= -->
                <div
                    class="
                        mt-4
                        grid
                        gap-4
                        md:grid-cols-2
                        lg:grid-cols-4
                    "
                >


                    <!-- =========================================
                         CATÉGORIE
                         SUPER ADMIN UNIQUEMENT
                         ========================================= -->
                    @if (auth()->user()->isSuperAdmin())

                        <div>

                            <label
                                for="gender"
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
                                id="gender"
                                name="gender"
                                onchange="this.form.submit()"
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
                                    focus:ring-1
                                    focus:ring-red-600
                                "
                            >

                                <option
                                    value="all"
                                    @selected($gender === 'all')
                                >
                                    Toutes
                                </option>

                                <option
                                    value="homme"
                                    @selected($gender === 'homme')
                                >
                                    Homme
                                </option>

                                <option
                                    value="femme"
                                    @selected($gender === 'femme')
                                >
                                    Femme
                                </option>

                            </select>

                        </div>

                    @endif


                    <!-- =========================================
                         BOUTONS
                         ========================================= -->
                    <div
                        class="
                            flex
                            items-end
                            gap-3
                            md:col-span-2
                        "
                    >

                        <button
                            type="submit"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-md
                                bg-zinc-900
                                px-5
                                py-3
                                text-sm
                                font-bold
                                text-white
                                transition
                                hover:bg-red-600
                            "
                        >
                            Rechercher
                        </button>


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
                            Réinitialiser
                        </a>

                    </div>

                </div>

            </form>


            <!-- =================================================
                 RÉSUMÉ DES FILTRES
                 ================================================= -->
            <div
                class="
                    mt-6
                    flex
                    flex-wrap
                    items-center
                    gap-2
                    text-xs
                    font-bold
                    uppercase
                    tracking-wider
                    text-zinc-500
                "
            >

                <span>
                    Filtres :
                </span>


                @if ($discipline !== 'all')

                    <span
                        class="
                            rounded-full
                            bg-zinc-100
                            px-3
                            py-1
                            text-zinc-700
                        "
                    >
                        {{ $discipline }}
                    </span>

                @endif


                @if (
                    auth()->user()->isSuperAdmin()
                    && $gender !== 'all'
                )

                    <span
                        class="
                            rounded-full
                            bg-zinc-100
                            px-3
                            py-1
                            text-zinc-700
                        "
                    >
                        {{ $gender === 'homme' ? 'Homme' : 'Femme' }}
                    </span>

                @endif


                @if ($status !== 'all')

                    <span
                        class="
                            rounded-full
                            bg-zinc-100
                            px-3
                            py-1
                            text-zinc-700
                        "
                    >
                        {{ $status === 'active' ? 'Actifs' : 'Inactifs' }}
                    </span>

                @endif


                @if (
                    $search !== ''
                    || $discipline !== 'all'
                    || $status !== 'all'
                    || (
                        auth()->user()->isSuperAdmin()
                        && $gender !== 'all'
                    )
                )

                    <a
                        href="{{ route('admin.courses.index') }}"
                        class="
                            ml-2
                            text-red-600
                            transition
                            hover:text-red-700
                        "
                    >
                        Effacer les filtres
                    </a>

                @else

                    <span class="normal-case tracking-normal text-zinc-400">
                        Aucun filtre actif
                    </span>

                @endif

            </div>


            <!-- =================================================
                 TABLEAU DES COURS
                 ================================================= -->
            <div
                class="
                    mt-6
                    overflow-x-auto
                    rounded-lg
                    border
                    border-zinc-200
                "
            >

                <table class="min-w-full divide-y divide-zinc-200">

                    <thead class="bg-zinc-100">

                        <tr>

                            <th
                                class="
                                    px-5
                                    py-4
                                    text-left
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-600
                                "
                            >
                                Entraînement
                            </th>


                            <th
                                class="
                                    px-5
                                    py-4
                                    text-left
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-600
                                "
                            >
                                Date
                            </th>


                            <th
                                class="
                                    px-5
                                    py-4
                                    text-left
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-600
                                "
                            >
                                Horaire
                            </th>


                            <th
                                class="
                                    px-5
                                    py-4
                                    text-left
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-600
                                "
                            >
                                Catégorie
                            </th>


                            <th
                                class="
                                    px-5
                                    py-4
                                    text-left
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-600
                                "
                            >
                                Statut
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
                                    text-zinc-600
                                "
                            >
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-zinc-200 bg-white">

                        @forelse ($courses as $course)

                            <tr class="hover:bg-zinc-50">


                                <!-- =====================================
                                     COURS
                                     ===================================== -->
                                <td class="px-5 py-5">

                                    <p class="font-black text-zinc-900">
                                        {{ $course->title }}
                                    </p>

                                    <p class="mt-1 text-sm text-zinc-500">
                                        {{ $course->discipline }}
                                    </p>


                                    @if ($course->description)

                                        <p
                                            class="
                                                mt-2
                                                max-w-md
                                                text-sm
                                                leading-5
                                                text-zinc-400
                                            "
                                        >
                                            {{ $course->description }}
                                        </p>

                                    @endif

                                </td>


                                <!-- =====================================
                                     DATE
                                     ===================================== -->
                                <td
                                    class="
                                        whitespace-nowrap
                                        px-5
                                        py-5
                                        text-sm
                                        font-bold
                                        text-zinc-700
                                    "
                                >
                                    {{ $course->course_date->format('d/m/Y') }}
                                </td>


                                <!-- =====================================
                                     HORAIRE
                                     ===================================== -->
                                <td
                                    class="
                                        whitespace-nowrap
                                        px-5
                                        py-5
                                        text-sm
                                        text-zinc-700
                                    "
                                >
                                    {{ substr($course->start_time, 0, 5) }}
                                    —
                                    {{ substr($course->end_time, 0, 5) }}
                                </td>


                                <!-- =====================================
                                     CATÉGORIE
                                     ===================================== -->
                                <td class="px-5 py-5">

                                    @if ($course->target_gender === 'homme')

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-zinc-900
                                                px-3
                                                py-1
                                                text-xs
                                                font-black
                                                uppercase
                                                text-white
                                            "
                                        >
                                            Homme
                                        </span>

                                    @else

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-red-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-black
                                                uppercase
                                                text-red-700
                                            "
                                        >
                                            Femme
                                        </span>

                                    @endif

                                </td>


                                <!-- =====================================
                                     STATUT
                                     ===================================== -->
                                <td class="px-5 py-5">

                                    @if ($course->is_active)

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-green-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-black
                                                uppercase
                                                text-green-700
                                            "
                                        >
                                            Actif
                                        </span>

                                    @else

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-zinc-200
                                                px-3
                                                py-1
                                                text-xs
                                                font-black
                                                uppercase
                                                text-zinc-600
                                            "
                                        >
                                            Inactif
                                        </span>

                                    @endif

                                </td>


                                <!-- =====================================
                                     ACTIONS
                                     ===================================== -->
                                <td class="px-5 py-5">

                                    <div
                                        class="
                                            flex
                                            justify-end
                                            gap-2
                                        "
                                    >

                                        <!--
                                            La modification sera activée
                                            à l'étape suivante.
                                        -->
                                        <button
                                            type="button"
                                            disabled
                                            class="
                                                rounded-md
                                                border
                                                border-blue-300
                                                px-3
                                                py-2
                                                text-xs
                                                font-bold
                                                uppercase
                                                text-blue-600
                                                opacity-50
                                            "
                                        >
                                            Modifier
                                        </button>


                                        <!--
                                            La suppression sera activée
                                            à l'étape suivante.
                                        -->
                                        <button
                                            type="button"
                                            disabled
                                            class="
                                                rounded-md
                                                border
                                                border-red-300
                                                px-3
                                                py-2
                                                text-xs
                                                font-bold
                                                uppercase
                                                text-red-600
                                                opacity-50
                                            "
                                        >
                                            Supprimer
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="
                                        px-6
                                        py-16
                                        text-center
                                        text-sm
                                        text-zinc-500
                                    "
                                >
                                    Aucun entraînement ne correspond
                                    aux filtres sélectionnés.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- =================================================
                 PAGINATION
                 ================================================= -->
            <div
                class="
                    mt-6
                    flex
                    flex-col
                    gap-4
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                "
            >

                <p class="text-sm text-zinc-500">

                    {{ $courses->total() }}

                    @if ($courses->total() > 1)
                        cours enregistrés.
                    @else
                        cours enregistré.
                    @endif

                </p>


                @if ($courses->hasPages())

                    <div>
                        {{ $courses->links() }}
                    </div>

                @endif

            </div>

        </div>

    </section>

@endsection