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


            {{--
            |--------------------------------------------------------------------------
            | BARRE LATÉRALE ADMIN COMMUNE
            |--------------------------------------------------------------------------
            |
            | La navigation de l'administration est centralisée dans
            | resources/views/admin/partials/sidebar.blade.php.
            |
            | Cela permet de conserver exactement le même menu sur
            | toutes les pages de l'administration.
            |
            | Le partial détecte automatiquement la route active.
            | Sur cette page, "Commentaires" sera donc affiché en rouge.
            |
            |--------------------------------------------------------------------------
            --}}
            @include('admin.partials.sidebar')


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
                                {{ $totalCommentsCount }}
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
                         STATISTIQUES DES COMMENTAIRES
                         =========================================
                         
                         Les compteurs sont indépendants du tri
                         et de la pagination du tableau.
                         
                         Le total comprend également les commentaires
                         supprimés logiquement.
                         
                         ========================================= -->
                    <section class="mb-8">

                        <div
                            class="
                                grid
                                gap-4
                                sm:grid-cols-2
                                xl:grid-cols-4
                            "
                        >


                            <!-- =================================
                                 TOTAL
                                 ================================= -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Total des commentaires
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format(
                                        $totalCommentsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Tous statuts confondus.
                                </p>

                            </div>


                            <!-- =================================
                                 PUBLIÉS
                                 ================================= -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Publiés
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format(
                                        $publishedCommentsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Commentaires visibles publiquement.
                                </p>

                            </div>


                            <!-- =================================
                                 MASQUÉS
                                 ================================= -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Masqués
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-amber-600
                                    "
                                >
                                    {{ number_format(
                                        $hiddenCommentsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Commentaires masqués au public.
                                </p>

                            </div>


                            <!-- =================================
                                 SUPPRIMÉS
                                 ================================= -->
                            <div
                                class="
                                    border
                                    border-zinc-200
                                    bg-white
                                    p-5
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
                                    Supprimés
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-red-600
                                    "
                                >
                                    {{ number_format(
                                        $deletedCommentsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) }}
                                </p>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Commentaires supprimés temporairement.
                                </p>

                            </div>

                        </div>

                    </section>


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