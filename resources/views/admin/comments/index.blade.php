@extends('layouts.app')


@section('title', 'Commentaires - Administration BTT')


@section(
    'meta_description',
    'Modération des commentaires du blog Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         ESPACE ADMINISTRATION - COMMENTAIRES
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


                        <!-- =====================================
                             TABLEAU DE BORD
                             ===================================== -->
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


                        <!-- =====================================
                             ADHÉRENTS
                             ===================================== -->
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


                        <!-- =====================================
                             CALENDRIER
                             ===================================== -->
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
                             ===================================== -->
                        <a
                            href="{{ route('admin.articles.index') }}"
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
                            Articles
                        </a>


                        <!-- =====================================
                             COMMENTAIRES
                             PAGE ACTIVE
                             ===================================== -->
                        <a
                            href="{{ route('admin.comments.index') }}"
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
                            Commentaires
                        </a>


                        <!-- =====================================
                             PRODUITS
                             PAS ENCORE DÉVELOPPÉ
                             ===================================== -->
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


                        <!-- =====================================
                             MESSAGES
                             ===================================== -->
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


                        <!-- =====================================
                             ADMINISTRATEURS
                             SUPER ADMIN UNIQUEMENT
                             ===================================== -->
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
                            gap-4
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
                                Modération des commentaires
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
                                Consultez et modérez les commentaires publiés
                                sous les articles du Brussels Top Team.
                            </p>

                        </div>


                        <!-- =====================================
                             TOTAL DES COMMENTAIRES
                             ===================================== -->
                        <div
                            class="
                                rounded-lg
                                border
                                border-zinc-200
                                bg-zinc-50
                                px-5
                                py-4
                            "
                        >

                            <p
                                class="
                                    text-xs
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-500
                                "
                            >
                                Total
                            </p>


                            <p
                                class="
                                    mt-1
                                    text-2xl
                                    font-black
                                    text-zinc-900
                                "
                            >
                                {{ $comments->total() }}
                            </p>

                        </div>

                    </div>

                </header>


                <!-- =============================================
                     CONTENU
                     ============================================= -->
                <main class="bg-white px-6 py-8 lg:px-10 lg:py-10">


                    <!-- =========================================
                         MESSAGE DE SUCCÈS
                         ========================================= -->
                    @if (session('success'))

                        <div
                            class="
                                mb-8
                                rounded-lg
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
                                Modération
                            </p>


                            <h2
                                class="
                                    mt-2
                                    text-2xl
                                    font-black
                                    text-zinc-900
                                "
                            >
                                Commentaires
                            </h2>

                        </div>


                        <p class="text-sm font-bold text-zinc-500">

                            {{ $comments->total() }}

                            @if ($comments->total() > 1)

                                commentaires

                            @else

                                commentaire

                            @endif

                        </p>

                    </div>


                    <!-- =========================================
                         TABLEAU DES COMMENTAIRES
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

                            <table class="w-full min-w-[1200px]">


                                <!-- =================================
                                     EN-TÊTES
                                     ================================= -->
                                <thead class="bg-zinc-50">

                                    <tr class="border-b border-zinc-200">


                                        <!-- =========================
                                             AUTEUR
                                             ========================= -->
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


                                        <!-- =========================
                                             ARTICLE
                                             ========================= -->
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
                                            Article
                                        </th>


                                        <!-- =========================
                                             COMMENTAIRE
                                             ========================= -->
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
                                            Commentaire
                                        </th>


                                        <!-- =========================
                                             STATUT
                                             TRI CLIQUABLE
                                             ========================= -->
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
                                                href="{{ route('admin.comments.index', [
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


                                        <!-- =========================
                                             DATE
                                             TRI CLIQUABLE
                                             ========================= -->
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
                                                href="{{ route('admin.comments.index', [
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
                                                Date

                                                @if ($sort === 'created_at')

                                                    <span>
                                                        {{ $direction === 'asc' ? '↑' : '↓' }}
                                                    </span>

                                                @endif

                                            </a>

                                        </th>


                                        <!-- =========================
                                             ACTIONS
                                             ========================= -->
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


                                <!-- =================================
                                     CONTENU DU TABLEAU
                                     ================================= -->
                                <tbody class="divide-y divide-zinc-200">

                                    @forelse ($comments as $comment)

                                        <tr
                                            class="
                                                bg-white
                                                align-top
                                                transition
                                                hover:bg-zinc-50
                                            "
                                        >


                                            <!-- =====================
                                                 AUTEUR
                                                 ===================== -->
                                            <td class="px-5 py-5">

                                                @if ($comment->user)

                                                    <p
                                                        class="
                                                            font-black
                                                            text-zinc-900
                                                        "
                                                    >
                                                        {{ $comment->user->pseudo }}
                                                    </p>


                                                    <p
                                                        class="
                                                            mt-1
                                                            text-xs
                                                            text-zinc-500
                                                        "
                                                    >
                                                        {{ $comment->user->email }}
                                                    </p>

                                                @else

                                                    <p
                                                        class="
                                                            font-bold
                                                            text-zinc-500
                                                        "
                                                    >
                                                        Ancien membre BTT
                                                    </p>

                                                @endif

                                            </td>


                                            <!-- =====================
                                                 ARTICLE
                                                 ===================== -->
                                            <td class="px-5 py-5">

                                                @if ($comment->article)

                                                    <p
                                                        class="
                                                            max-w-[220px]
                                                            font-bold
                                                            leading-5
                                                            text-zinc-900
                                                        "
                                                    >
                                                        {{ $comment->article->title }}
                                                    </p>


                                                    @if (
                                                        $comment->article->status === 'published'
                                                        && ! $comment->article->trashed()
                                                    )

                                                        <a
                                                            href="{{ route('blog.show', $comment->article->slug) }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="
                                                                mt-2
                                                                inline-flex
                                                                text-xs
                                                                font-black
                                                                uppercase
                                                                tracking-wider
                                                                text-red-600
                                                                transition
                                                                hover:text-red-700
                                                            "
                                                        >
                                                            Voir l'article ↗
                                                        </a>

                                                    @endif

                                                @else

                                                    <span class="text-sm text-zinc-400">
                                                        Article indisponible
                                                    </span>

                                                @endif

                                            </td>


                                            <!-- =====================
                                                 COMMENTAIRE
                                                 ===================== -->
                                            <td class="px-5 py-5">

                                                <p
                                                    class="
                                                        max-w-md
                                                        whitespace-pre-line
                                                        break-words
                                                        text-sm
                                                        leading-6
                                                        text-zinc-700
                                                    "
                                                >{{ $comment->body }}</p>

                                            </td>


                                            <!-- =====================
                                                 STATUT
                                                 ===================== -->
                                            <td class="px-5 py-5">

                                                @if ($comment->trashed())

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

                                                @elseif ($comment->status === 'published')

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
                                                            bg-amber-100
                                                            px-3
                                                            py-1
                                                            text-xs
                                                            font-black
                                                            uppercase
                                                            tracking-wider
                                                            text-amber-700
                                                        "
                                                    >
                                                        Masqué
                                                    </span>

                                                @endif

                                            </td>


                                            <!-- =====================
                                                 DATE
                                                 ===================== -->
                                            <td
                                                class="
                                                    px-5
                                                    py-5
                                                    text-sm
                                                    text-zinc-600
                                                "
                                            >
                                                {{ $comment->created_at->format('d/m/Y H:i') }}
                                            </td>


                                            <!-- =====================
                                                 ACTIONS
                                                 ===================== -->
                                            <td class="px-5 py-5">

                                                <div
                                                    class="
                                                        flex
                                                        flex-wrap
                                                        justify-end
                                                        gap-2
                                                    "
                                                >


                                                    <!-- =================
                                                         COMMENTAIRE SUPPRIMÉ
                                                         ================= -->
                                                    @if ($comment->trashed())

                                                        <form
                                                            action="{{ route('admin.comments.restore', $comment->id) }}"
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
                                                                    border
                                                                    border-green-300
                                                                    bg-green-50
                                                                    px-3
                                                                    py-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-green-700
                                                                    transition
                                                                    hover:bg-green-100
                                                                "
                                                            >
                                                                Restaurer
                                                            </button>

                                                        </form>


                                                    <!-- =================
                                                         COMMENTAIRE PUBLIÉ
                                                         ================= -->
                                                    @elseif ($comment->status === 'published')

                                                        <form
                                                            action="{{ route('admin.comments.hide', $comment) }}"
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
                                                                    border
                                                                    border-amber-300
                                                                    bg-amber-50
                                                                    px-3
                                                                    py-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-amber-700
                                                                    transition
                                                                    hover:bg-amber-100
                                                                "
                                                            >
                                                                Masquer
                                                            </button>

                                                        </form>


                                                        <form
                                                            action="{{ route('admin.comments.destroy', $comment) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');"
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
                                                                    border-red-300
                                                                    bg-red-50
                                                                    px-3
                                                                    py-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-red-700
                                                                    transition
                                                                    hover:bg-red-100
                                                                "
                                                            >
                                                                Supprimer
                                                            </button>

                                                        </form>


                                                    <!-- =================
                                                         COMMENTAIRE MASQUÉ
                                                         ================= -->
                                                    @else

                                                        <form
                                                            action="{{ route('admin.comments.publish', $comment) }}"
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
                                                                    border
                                                                    border-green-300
                                                                    bg-green-50
                                                                    px-3
                                                                    py-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-green-700
                                                                    transition
                                                                    hover:bg-green-100
                                                                "
                                                            >
                                                                Publier
                                                            </button>

                                                        </form>


                                                        <form
                                                            action="{{ route('admin.comments.destroy', $comment) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');"
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
                                                                    border-red-300
                                                                    bg-red-50
                                                                    px-3
                                                                    py-2
                                                                    text-xs
                                                                    font-black
                                                                    uppercase
                                                                    tracking-wider
                                                                    text-red-700
                                                                    transition
                                                                    hover:bg-red-100
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

                                        <!-- =========================
                                             AUCUN COMMENTAIRE
                                             ========================= -->
                                        <tr>

                                            <td
                                                colspan="6"
                                                class="
                                                    px-6
                                                    py-16
                                                    text-center
                                                "
                                            >

                                                <div
                                                    class="
                                                        mx-auto
                                                        max-w-md
                                                    "
                                                >

                                                    <p
                                                        class="
                                                            text-lg
                                                            font-black
                                                            text-zinc-900
                                                        "
                                                    >
                                                        Aucun commentaire
                                                    </p>


                                                    <p
                                                        class="
                                                            mt-2
                                                            text-sm
                                                            leading-6
                                                            text-zinc-500
                                                        "
                                                    >
                                                        Aucun commentaire n'a encore
                                                        été publié sur le blog Brussels
                                                        Top Team.
                                                    </p>

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
                    @if ($comments->hasPages())

                        <div class="mt-8">
                            {{ $comments->links() }}
                        </div>

                    @endif

                </main>

            </div>

        </div>

    </section>

@endsection