@extends('layouts.app')


@section('title', 'Administrateurs - BTT Admin')


@section(
    'meta_description',
    'Gestion des administrateurs de Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         GESTION DES ADMINISTRATEURS
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
                    gap-5
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
                            sm:text-4xl
                        "
                    >
                        Administrateurs
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
                        Consultez et gérez les comptes ayant accès
                        à l'administration Brussels Top Team.
                    </p>

                </div>


                <div
                    class="
                        flex
                        flex-col
                        gap-3
                        sm:flex-row
                    "
                >

                    <!-- =========================================
                         ADHÉRENTS
                         ========================================= -->
                    <a
                        href="{{ route('admin.members.index') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            border
                            border-zinc-300
                            px-4
                            py-3
                            text-sm
                            font-bold
                            text-zinc-700
                            transition
                            hover:border-red-600
                            hover:text-red-600
                        "
                    >
                        Adhérents
                    </a>


                    <!-- =========================================
                         TABLEAU DE BORD
                         ========================================= -->
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
                            py-3
                            text-sm
                            font-bold
                            text-zinc-700
                            transition
                            hover:border-zinc-900
                            hover:text-zinc-900
                        "
                    >
                        ← Tableau de bord
                    </a>

                </div>

            </div>


            <!-- =================================================
                 MESSAGE DE SUCCÈS
                 ================================================= -->
            @if (session('success'))

                <div
                    class="
                        mt-8
                        border-l-4
                        border-green-600
                        bg-green-50
                        px-5
                        py-4
                    "
                >

                    <p class="text-sm font-bold text-green-800">
                        {{ session('success') }}
                    </p>

                </div>

            @endif


            <!-- =================================================
                 INFORMATION SUPER ADMIN
                 ================================================= -->
            <div
                class="
                    mt-8
                    border-l-4
                    border-red-600
                    bg-red-50
                    px-5
                    py-4
                "
            >

                <p class="text-sm font-bold text-zinc-900">
                    Gestion réservée au Super Admin
                </p>

                <p class="mt-1 text-sm leading-6 text-zinc-600">
                    Vous pouvez consulter les administrateurs Hommes et
                    Femmes et rétrograder un Admin en adhérent.
                    Le compte Super Admin est protégé.
                </p>

            </div>


            <!-- =================================================
                 RECHERCHE ET FILTRES
                 ================================================= -->
            <form
                action="{{ route('admin.administrators.index') }}"
                method="GET"
                class="
                    mt-8
                    border
                    border-zinc-200
                    bg-zinc-50
                    p-5
                    sm:p-6
                "
            >

                <div
                    class="
                        grid
                        gap-5
                        md:grid-cols-2
                        xl:grid-cols-4
                    "
                >


                    <!-- =========================================
                         RECHERCHE
                         ========================================= -->
                    <div
                        class="
                            md:col-span-2
                            xl:col-span-2
                        "
                    >

                        <label
                            for="search"
                            class="
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
                            id="search"
                            name="search"
                            type="search"
                            value="{{ $search }}"
                            placeholder="Nom, prénom, pseudo ou email..."
                            class="
                                mt-2
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
                                placeholder:text-zinc-400
                                focus:border-red-600
                                focus:ring-2
                                focus:ring-red-600/10
                            "
                        >

                    </div>


                    <!-- =========================================
                         TRI ALPHABÉTIQUE
                         ========================================= -->
                    <div>

                        <label
                            for="sort"
                            class="
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Ordre alphabétique
                        </label>

                        <select
                            id="sort"
                            name="sort"
                            onchange="this.form.submit()"
                            class="
                                mt-2
                                w-full
                                cursor-pointer
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
                                focus:ring-2
                                focus:ring-red-600/10
                            "
                        >

                            <option
                                value="asc"
                                @selected($sort === 'asc')
                            >
                                A → Z
                            </option>

                            <option
                                value="desc"
                                @selected($sort === 'desc')
                            >
                                Z → A
                            </option>

                        </select>

                    </div>


                    <!-- =========================================
                         GENRE
                         ========================================= -->
                    <div>

                        <label
                            for="genre"
                            class="
                                block
                                text-xs
                                font-black
                                uppercase
                                tracking-wider
                                text-zinc-600
                            "
                        >
                            Genre
                        </label>

                        <select
                            id="genre"
                            name="genre"
                            onchange="this.form.submit()"
                            class="
                                mt-2
                                w-full
                                cursor-pointer
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
                                focus:ring-2
                                focus:ring-red-600/10
                            "
                        >

                            <option
                                value="all"
                                @selected($gender === 'all')
                            >
                                Tous
                            </option>

                            <option
                                value="homme"
                                @selected($gender === 'homme')
                            >
                                Hommes
                            </option>

                            <option
                                value="femme"
                                @selected($gender === 'femme')
                            >
                                Femmes
                            </option>

                        </select>

                    </div>

                </div>


                <!-- =============================================
                     BOUTONS
                     ============================================= -->
                <div
                    class="
                        mt-5
                        flex
                        flex-col
                        gap-3
                        sm:flex-row
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
                        Rechercher
                    </button>


                    <a
                        href="{{ route('admin.administrators.index') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-md
                            border
                            border-zinc-300
                            bg-white
                            px-5
                            py-3
                            text-xs
                            font-black
                            uppercase
                            tracking-wider
                            text-zinc-600
                            transition
                            hover:border-zinc-900
                            hover:text-zinc-900
                        "
                    >
                        Réinitialiser
                    </a>

                </div>

            </form>


            <!-- =================================================
                 LISTE DES ADMINISTRATEURS
                 ================================================= -->
            <section class="mt-10">

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

                    <h2
                        class="
                            text-xl
                            font-black
                            uppercase
                            tracking-tight
                            text-zinc-900
                        "
                    >
                        Équipe administrative
                    </h2>


                    <p class="text-sm font-bold text-zinc-500">

                        {{ $administrators->total() }}

                        {{ $administrators->total() > 1
                            ? 'comptes administrateurs'
                            : 'compte administrateur'
                        }}

                    </p>

                </div>


                <!-- =============================================
                     TABLEAU
                     ============================================= -->
                <div
                    class="
                        mt-5
                        overflow-x-auto
                        border
                        border-zinc-200
                    "
                >

                    <table class="min-w-full bg-white">

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
                                        text-zinc-500
                                    "
                                >
                                    Nom
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
                                        text-zinc-500
                                    "
                                >
                                    Pseudo
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
                                        text-zinc-500
                                    "
                                >
                                    Email
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
                                        text-zinc-500
                                    "
                                >
                                    Genre
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
                                        text-zinc-500
                                    "
                                >
                                    Rôle
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

                            @forelse ($administrators as $administrator)

                                <tr class="transition hover:bg-zinc-50">


                                    <!-- =========================
                                         IDENTITÉ
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                        "
                                    >

                                        <p class="text-sm font-bold text-zinc-900">

                                            {{ $administrator->nom }}
                                            {{ $administrator->prenom }}

                                        </p>

                                        <p class="mt-1 text-xs text-zinc-400">
                                            ID #{{ $administrator->id }}
                                        </p>

                                    </td>


                                    <!-- =========================
                                         PSEUDO
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                            text-sm
                                            font-semibold
                                            text-zinc-700
                                        "
                                    >
                                        {{ $administrator->pseudo }}
                                    </td>


                                    <!-- =========================
                                         EMAIL
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                            text-sm
                                            text-zinc-600
                                        "
                                    >
                                        {{ $administrator->email }}
                                    </td>


                                    <!-- =========================
                                         GENRE
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                        "
                                    >

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-zinc-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-black
                                                uppercase
                                                tracking-wider
                                                text-zinc-700
                                            "
                                        >
                                            {{ ucfirst($administrator->genre) }}
                                        </span>

                                    </td>


                                    <!-- =========================
                                         RÔLE
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                        "
                                    >

                                        @if ($administrator->isSuperAdmin())

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
                                                    tracking-wider
                                                    text-red-700
                                                "
                                            >
                                                Super Admin
                                            </span>

                                        @else

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
                                                    tracking-wider
                                                    text-white
                                                "
                                            >
                                                Admin
                                            </span>

                                        @endif

                                    </td>


                                    <!-- =========================
                                         ACTION
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                            text-right
                                        "
                                    >

                                        @if ($administrator->isAdmin())

                                            <form
                                                action="{{ route(
                                                    'admin.administrators.demote',
                                                    $administrator->id
                                                ) }}"
                                                method="POST"
                                                onsubmit="
                                                    return confirm(
                                                        'Confirmer la rétrogradation de cet administrateur en adhérent ?'
                                                    );
                                                "
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="
                                                        rounded-md
                                                        border
                                                        border-red-600
                                                        bg-white
                                                        px-4
                                                        py-2
                                                        text-xs
                                                        font-black
                                                        uppercase
                                                        tracking-wider
                                                        text-red-600
                                                        transition
                                                        hover:bg-red-600
                                                        hover:text-white
                                                    "
                                                >
                                                    Rétrograder
                                                </button>

                                            </form>

                                        @else

                                            <!-- =================
                                                 SUPER ADMIN
                                                 AUCUNE ACTION
                                                 ================= -->
                                            <span
                                                class="
                                                    text-xs
                                                    font-black
                                                    uppercase
                                                    tracking-wider
                                                    text-zinc-400
                                                "
                                            >
                                                Protégé
                                            </span>

                                        @endif

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="
                                            px-5
                                            py-14
                                            text-center
                                        "
                                    >

                                        <p class="text-sm font-bold text-zinc-700">
                                            Aucun administrateur trouvé.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- =============================================
                     PAGINATION
                     ============================================= -->
                @if ($administrators->hasPages())

                    <div class="mt-6">
                        {{ $administrators->links() }}
                    </div>

                @endif

            </section>

        </div>

    </section>

@endsection