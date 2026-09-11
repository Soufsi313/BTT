@extends('layouts.app')


@section('title', 'Gestion des adhérents - BTT Admin')


@section(
    'meta_description',
    'Gestion des adhérents de Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         PAGE DE GESTION DES ADHÉRENTS
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
                        Adhérents
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
                        Recherchez, consultez et contrôlez le statut des
                        adhérents Brussels Top Team.
                    </p>

                </div>


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
                 INFORMATIONS SUR LES DROITS
                 ================================================= -->
            <div class="mt-8">

                @if (auth()->user()->isSuperAdmin())

                    <div
                        class="
                            border-l-4
                            border-red-600
                            bg-red-50
                            px-5
                            py-4
                        "
                    >
                        <p class="text-sm font-bold text-zinc-900">
                            Mode Super Admin
                        </p>

                        <p class="mt-1 text-sm text-zinc-600">
                            Vous pouvez consulter les adhérents Hommes et
                            Femmes ainsi que les comptes supprimés.
                        </p>
                    </div>

                @else

                    <div
                        class="
                            border-l-4
                            border-zinc-900
                            bg-zinc-100
                            px-5
                            py-4
                        "
                    >
                        <p class="text-sm font-bold text-zinc-900">
                            Catégorie autorisée :
                            {{ ucfirst(auth()->user()->genre) }}
                        </p>

                        <p class="mt-1 text-sm text-zinc-600">
                            Votre compte administrateur peut uniquement
                            consulter les adhérents de cette catégorie.
                        </p>
                    </div>

                @endif

            </div>


            <!-- =================================================
                 RECHERCHE ET FILTRES
                 ================================================= -->
            <form
                id="members-filter-form"
                action="{{ route('admin.members.index') }}"
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
                            Rechercher un adhérent
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
                         TRI
                         ACTUALISATION AUTOMATIQUE
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
                         SUPER ADMIN UNIQUEMENT
                         ACTUALISATION AUTOMATIQUE
                         ========================================= -->
                    @if (auth()->user()->isSuperAdmin())

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

                    @endif

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

                    <!-- =========================================
                         RECHERCHE MANUELLE
                         ========================================= -->
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


                    <!-- =========================================
                         RÉINITIALISER LES FILTRES
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
                 LISTE DES ADHÉRENTS
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
                        Liste des adhérents
                    </h2>

                    <p class="text-sm font-bold text-zinc-500">
                        {{ $members->total() }}
                        {{ $members->total() > 1 ? 'adhérents trouvés' : 'adhérent trouvé' }}
                    </p>

                </div>


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
                                    Statut
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
                                    Inscription
                                </th>

                                @if (auth()->user()->isSuperAdmin())

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

                                @endif

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-zinc-200">

                            @forelse ($members as $member)

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
                                            {{ $member->nom }}
                                            {{ $member->prenom }}
                                        </p>

                                        <p class="mt-1 text-xs text-zinc-400">
                                            ID #{{ $member->id }}
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
                                        {{ $member->pseudo }}
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
                                        {{ $member->email }}
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
                                            {{ ucfirst($member->genre) }}
                                        </span>

                                    </td>


                                    <!-- =========================
                                         STATUT
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                        "
                                    >

                                        @if ($member->trashed())

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
                                                Supprimé
                                            </span>

                                        @else

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
                                                    tracking-wider
                                                    text-green-700
                                                "
                                            >
                                                Actif
                                            </span>

                                        @endif

                                    </td>


                                    <!-- =========================
                                         INSCRIPTION
                                         ========================= -->
                                    <td
                                        class="
                                            whitespace-nowrap
                                            px-5
                                            py-4
                                            text-sm
                                            text-zinc-500
                                        "
                                    >
                                        {{ $member->created_at->format('d/m/Y') }}
                                    </td>


                                    <!-- =========================
                                         ACTION SUPER ADMIN
                                         ========================= -->
                                    @if (auth()->user()->isSuperAdmin())

                                        <td
                                            class="
                                                whitespace-nowrap
                                                px-5
                                                py-4
                                                text-right
                                            "
                                        >

                                            @if ($member->trashed())

                                                <form
                                                    action="{{ route('admin.members.restore', $member->id) }}"
                                                    method="POST"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="
                                                            rounded-md
                                                            bg-green-600
                                                            px-4
                                                            py-2
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-white
                                                            transition
                                                            hover:bg-green-700
                                                        "
                                                    >
                                                        Réactiver
                                                    </button>

                                                </form>

                                            @else

                                                <span
                                                    class="
                                                        text-xs
                                                        font-bold
                                                        uppercase
                                                        tracking-wider
                                                        text-zinc-400
                                                    "
                                                >
                                                    Actif
                                                </span>

                                            @endif

                                        </td>

                                    @endif

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="{{ auth()->user()->isSuperAdmin() ? 7 : 6 }}"
                                        class="
                                            px-5
                                            py-14
                                            text-center
                                        "
                                    >

                                        <p
                                            class="
                                                text-sm
                                                font-bold
                                                text-zinc-700
                                            "
                                        >
                                            Aucun adhérent trouvé.
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
                @if ($members->hasPages())

                    <div class="mt-6">
                        {{ $members->links() }}
                    </div>

                @endif

            </section>

        </div>

    </section>

@endsection