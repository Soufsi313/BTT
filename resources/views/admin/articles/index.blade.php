@extends('layouts.app')


@section('title', 'Articles - Administration BTT')


@section(
    'meta_description',
    'Gestion des articles du blog Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         ESPACE ADMINISTRATION - ARTICLES
         ========================================================= -->
    <section class="min-h-screen bg-white text-zinc-900">

        <div class="flex min-h-screen">


            <!-- =================================================
                 BARRE LATÉRALE ADMIN
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


                        <!-- =====================================
                             ARTICLES
                             PAGE ACTIVE
                             ===================================== -->
                        <a
                            href="{{ route('admin.articles.index') }}"
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
                            Articles
                        </a>


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
                     EN-TÊTE
                     ============================================= -->
                <header
                    class="
                        border-b
                        border-zinc-200
                        bg-white
                        px-6
                        py-6
                        lg:px-10
                    "
                >

                    <div
                        class="
                            flex
                            flex-col
                            gap-5
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
                                    tracking-[0.3em]
                                    text-red-600
                                "
                            >
                                Blog BTT
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
                                Gestion des articles
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
                                Créez, modifiez, publiez, supprimez
                                et restaurez les actualités du Brussels Top Team.
                            </p>

                        </div>


                        <!-- =====================================
                             NOUVEL ARTICLE
                             ===================================== -->
                        <a
                            href="{{ route('admin.articles.create') }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-md
                                bg-red-600
                                px-5
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
                            + Nouvel article
                        </a>

                    </div>

                </header>


                <!-- =============================================
                     CONTENU
                     ============================================= -->
                <main class="bg-white px-6 py-8 lg:px-10 lg:py-10">


                    <!-- =========================================
                         MESSAGE DE CONFIRMATION
                         ========================================= -->
                    @if (session('success'))

                        <div
                            class="
                                mb-8
                                rounded-md
                                border
                                border-green-200
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


                    <!-- =========================================
                         RÉSUMÉ
                         ========================================= -->
                    <div
                        class="
                            mb-8
                            flex
                            flex-col
                            gap-4
                            border-b
                            border-zinc-200
                            pb-6
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
                                    tracking-[0.25em]
                                    text-zinc-500
                                "
                            >
                                Bibliothèque
                            </p>

                            <h2
                                class="
                                    mt-2
                                    text-2xl
                                    font-black
                                    text-zinc-900
                                "
                            >
                                Articles
                            </h2>

                        </div>


                        <p class="text-sm font-bold text-zinc-500">

                            {{ $articles->total() }}

                            @if ($articles->total() > 1)
                                articles
                            @else
                                article
                            @endif

                        </p>

                    </div>


                    <!-- =========================================
                         TABLEAU DES ARTICLES
                         ========================================= -->
                    <div
                        class="
                            overflow-hidden
                            rounded-lg
                            border
                            border-zinc-200
                            bg-white
                        "
                    >

                        <div class="overflow-x-auto">

                            <table class="w-full min-w-[1350px]">


                                <!-- =============================
                                     EN-TÊTES
                                     ============================= -->
                                <thead class="bg-zinc-50">

                                    <tr class="border-b border-zinc-200">


                                        <!-- BANNIÈRE -->
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
                                            Bannière
                                        </th>


                                        <!-- TITRE -->
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

                                            <a
                                                href="{{ route('admin.articles.index', [
                                                    'sort' => 'title',
                                                    'direction' => $sort === 'title' && $direction === 'asc'
                                                        ? 'desc'
                                                        : 'asc',
                                                ]) }}"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-2
                                                    transition
                                                    hover:text-red-600
                                                "
                                            >
                                                Titre

                                                @if ($sort === 'title')
                                                    <span>
                                                        {{ $direction === 'asc' ? '↑' : '↓' }}
                                                    </span>
                                                @endif
                                            </a>

                                        </th>


                                        <!-- CATÉGORIE -->
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

                                            <a
                                                href="{{ route('admin.articles.index', [
                                                    'sort' => 'category',
                                                    'direction' => $sort === 'category' && $direction === 'asc'
                                                        ? 'desc'
                                                        : 'asc',
                                                ]) }}"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-2
                                                    transition
                                                    hover:text-red-600
                                                "
                                            >
                                                Catégorie

                                                @if ($sort === 'category')
                                                    <span>
                                                        {{ $direction === 'asc' ? '↑' : '↓' }}
                                                    </span>
                                                @endif
                                            </a>

                                        </th>


                                        <!-- AUTEUR -->
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
                                            Auteur
                                        </th>


                                        <!-- STATUT -->
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

                                            <a
                                                href="{{ route('admin.articles.index', [
                                                    'sort' => 'status',
                                                    'direction' => $sort === 'status' && $direction === 'asc'
                                                        ? 'desc'
                                                        : 'asc',
                                                ]) }}"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-2
                                                    transition
                                                    hover:text-red-600
                                                "
                                            >
                                                Statut

                                                @if ($sort === 'status')
                                                    <span>
                                                        {{ $direction === 'asc' ? '↑' : '↓' }}
                                                    </span>
                                                @endif
                                            </a>

                                        </th>


                                        <!-- PUBLICATION -->
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

                                            <a
                                                href="{{ route('admin.articles.index', [
                                                    'sort' => 'published_at',
                                                    'direction' => $sort === 'published_at' && $direction === 'asc'
                                                        ? 'desc'
                                                        : 'asc',
                                                ]) }}"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-2
                                                    transition
                                                    hover:text-red-600
                                                "
                                            >
                                                Publication

                                                @if ($sort === 'published_at')
                                                    <span>
                                                        {{ $direction === 'asc' ? '↑' : '↓' }}
                                                    </span>
                                                @endif
                                            </a>

                                        </th>


                                        <!-- CRÉATION -->
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

                                            <a
                                                href="{{ route('admin.articles.index', [
                                                    'sort' => 'created_at',
                                                    'direction' => $sort === 'created_at' && $direction === 'asc'
                                                        ? 'desc'
                                                        : 'asc',
                                                ]) }}"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-2
                                                    transition
                                                    hover:text-red-600
                                                "
                                            >
                                                Création

                                                @if ($sort === 'created_at')
                                                    <span>
                                                        {{ $direction === 'asc' ? '↑' : '↓' }}
                                                    </span>
                                                @endif
                                            </a>

                                        </th>


                                        <!-- ACTIONS -->
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
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                <!-- =============================
                                     CONTENU DU TABLEAU
                                     ============================= -->
                                <tbody class="divide-y divide-zinc-200">

                                    @forelse ($articles as $article)

                                        <tr
                                            class="
                                                bg-white
                                                transition
                                                hover:bg-zinc-50
                                            "
                                        >


                                            <!-- =================
                                                 BANNIÈRE
                                                 ================= -->
                                            <td class="px-5 py-4">

                                                @if ($article->banner_image)

                                                    <div
                                                        class="
                                                            h-20
                                                            w-32
                                                            overflow-hidden
                                                            rounded-md
                                                            border
                                                            border-zinc-200
                                                            bg-zinc-100
                                                        "
                                                    >

                                                        <img
                                                            src="{{ asset('storage/' . $article->banner_image) }}"
                                                            alt="Bannière de {{ $article->title }}"
                                                            class="
                                                                h-full
                                                                w-full
                                                                object-cover
                                                            "
                                                        >

                                                    </div>

                                                @else

                                                    <div
                                                        class="
                                                            flex
                                                            h-20
                                                            w-32
                                                            items-center
                                                            justify-center
                                                            rounded-md
                                                            border
                                                            border-dashed
                                                            border-zinc-300
                                                            bg-zinc-50
                                                            px-3
                                                            text-center
                                                        "
                                                    >

                                                        <span class="text-xs font-bold text-zinc-400">
                                                            Aucune bannière
                                                        </span>

                                                    </div>

                                                @endif

                                            </td>


                                            <!-- =================
                                                 TITRE
                                                 ================= -->
                                            <td class="px-5 py-5">

                                                <p
                                                    class="
                                                        max-w-xs
                                                        font-bold
                                                        text-zinc-900
                                                    "
                                                >
                                                    {{ $article->title }}
                                                </p>


                                                @if ($article->deleted_at)

                                                    <p
                                                        class="
                                                            mt-2
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-red-600
                                                        "
                                                    >
                                                        Supprimé
                                                    </p>

                                                @endif


                                                @if ($article->is_featured)

                                                    <p
                                                        class="
                                                            mt-2
                                                            text-xs
                                                            font-bold
                                                            text-red-600
                                                        "
                                                    >
                                                        Article mis en avant
                                                    </p>

                                                @endif

                                            </td>


                                            <!-- =================
                                                 CATÉGORIE
                                                 ================= -->
                                            <td
                                                class="
                                                    px-5
                                                    py-5
                                                    text-sm
                                                    text-zinc-600
                                                "
                                            >
                                                {{ $article->category }}
                                            </td>


                                            <!-- =================
                                                 AUTEUR
                                                 ================= -->
                                            <td
                                                class="
                                                    px-5
                                                    py-5
                                                    text-sm
                                                    text-zinc-600
                                                "
                                            >

                                                @if ($article->author)

                                                    {{ $article->author->prenom }}
                                                    {{ $article->author->nom }}

                                                @else

                                                    <span class="text-zinc-400">
                                                        Auteur indisponible
                                                    </span>

                                                @endif

                                            </td>


                                            <!-- =================
                                                 STATUT
                                                 ================= -->
                                            <td class="px-5 py-5">

                                                @if ($article->deleted_at)

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

                                                @elseif ($article->status === 'published')

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
                                                        Publié
                                                    </span>

                                                @else

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
                                                            text-zinc-600
                                                        "
                                                    >
                                                        Brouillon
                                                    </span>

                                                @endif

                                            </td>


                                            <!-- =================
                                                 PUBLICATION
                                                 ================= -->
                                            <td
                                                class="
                                                    px-5
                                                    py-5
                                                    text-sm
                                                    text-zinc-600
                                                "
                                            >

                                                @if ($article->published_at)

                                                    {{ $article->published_at->format('d/m/Y H:i') }}

                                                @else

                                                    <span class="text-zinc-400">
                                                        —
                                                    </span>

                                                @endif

                                            </td>


                                            <!-- =================
                                                 CRÉATION
                                                 ================= -->
                                            <td
                                                class="
                                                    px-5
                                                    py-5
                                                    text-sm
                                                    text-zinc-600
                                                "
                                            >
                                                {{ $article->created_at->format('d/m/Y H:i') }}
                                            </td>


                                            <!-- =================
                                                 ACTIONS
                                                 ================= -->
                                            <td class="px-5 py-5">

                                                <div
                                                    class="
                                                        flex
                                                        items-center
                                                        justify-end
                                                        gap-2
                                                    "
                                                >


                                                    @if ($article->deleted_at)

                                                        <!-- =================
                                                             RESTAURER
                                                             ================= -->
                                                        <form
                                                            action="{{ route(
                                                                'admin.articles.restore',
                                                                $article->id
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
                                                                Restaurer
                                                            </button>

                                                        </form>

                                                    @else

                                                        <!-- =================
                                                             MODIFIER
                                                             ================= -->
                                                        <a
                                                            href="{{ route(
                                                                'admin.articles.edit',
                                                                $article
                                                            ) }}"
                                                            class="
                                                                inline-flex
                                                                items-center
                                                                justify-center
                                                                rounded-md
                                                                border
                                                                border-zinc-300
                                                                bg-white
                                                                px-4
                                                                py-2
                                                                text-xs
                                                                font-black
                                                                uppercase
                                                                tracking-wider
                                                                text-zinc-700
                                                                transition
                                                                hover:border-red-600
                                                                hover:text-red-600
                                                            "
                                                        >
                                                            Modifier
                                                        </a>


                                                        <!-- =================
                                                             SUPPRIMER
                                                             =================
                                                             Un message de
                                                             confirmation évite
                                                             les suppressions
                                                             accidentelles.
                                                             ================= -->
                                                        <form
                                                            action="{{ route(
                                                                'admin.articles.destroy',
                                                                $article
                                                            ) }}"
                                                            method="POST"
                                                            onsubmit="
                                                                return confirm(
                                                                    'Voulez-vous vraiment supprimer cet article ?'
                                                                );
                                                            "
                                                        >

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="
                                                                    inline-flex
                                                                    items-center
                                                                    justify-center
                                                                    rounded-md
                                                                    border
                                                                    border-red-200
                                                                    bg-red-50
                                                                    px-4
                                                                    py-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-red-700
                                                                    transition
                                                                    hover:border-red-600
                                                                    hover:bg-red-600
                                                                    hover:text-white
                                                                "
                                                            >
                                                                Supprimer
                                                            </button>

                                                        </form>

                                                    @endif

                                                </div>

                                            </td>

                                        </tr>

                                    @empty


                                        <!-- =====================
                                             AUCUN ARTICLE
                                             ===================== -->
                                        <tr>

                                            <td
                                                colspan="8"
                                                class="
                                                    px-6
                                                    py-16
                                                    text-center
                                                "
                                            >

                                                <div class="mx-auto max-w-md">

                                                    <p
                                                        class="
                                                            text-lg
                                                            font-black
                                                            text-zinc-900
                                                        "
                                                    >
                                                        Aucun article
                                                    </p>

                                                    <p
                                                        class="
                                                            mt-2
                                                            text-sm
                                                            leading-6
                                                            text-zinc-500
                                                        "
                                                    >
                                                        Aucun article n'a encore
                                                        été créé dans le blog
                                                        Brussels Top Team.
                                                    </p>


                                                    <a
                                                        href="{{ route('admin.articles.create') }}"
                                                        class="
                                                            mt-6
                                                            inline-flex
                                                            items-center
                                                            justify-center
                                                            rounded-md
                                                            bg-red-600
                                                            px-5
                                                            py-3
                                                            text-sm
                                                            font-black
                                                            text-white
                                                            transition
                                                            hover:bg-red-700
                                                        "
                                                    >
                                                        Créer le premier article
                                                    </a>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>


                    <!-- =========================================
                         PAGINATION
                         ========================================= -->
                    @if ($articles->hasPages())

                        <div class="mt-8">
                            {{ $articles->links() }}
                        </div>

                    @endif

                </main>

            </div>

        </div>

    </section>

@endsection