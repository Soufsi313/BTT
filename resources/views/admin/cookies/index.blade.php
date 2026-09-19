
@extends('layouts.app')


@section('title', 'Statistiques des cookies - Administration BTT')


@section(
    'meta_description',
    'Statistiques des préférences de cookies du site Brussels Top Team.'
)


@section('content')

    <!-- =========================================================
         STATISTIQUES DES COOKIES - ADMINISTRATION BTT
         =========================================================
         Cette page présente les choix de consentement actuellement
         enregistrés dans la table cookie_consents.

         Elle ne permet pas de modifier les préférences des visiteurs.
         ========================================================= -->
    <section class="min-h-screen bg-white text-zinc-900">

        <div class="flex min-h-screen">


            <!-- =================================================
                 MENU LATÉRAL COMMUN
                 ================================================= -->
            @include('admin.partials.sidebar')


            <!-- =================================================
                 CONTENU PRINCIPAL
                 ================================================= -->
            <div class="min-w-0 flex-1">


                <!-- =============================================
                     BARRE SUPÉRIEURE
                     ============================================= -->
                <header
                    class="
                        flex
                        flex-wrap
                        items-center
                        justify-between
                        gap-4
                        border-b
                        border-zinc-200
                        px-6
                        py-5
                        lg:px-10
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
                                mt-1
                                text-2xl
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Statistiques des cookies
                        </h1>

                    </div>


                    <!-- =========================================
                         ADMINISTRATEUR CONNECTÉ
                         ========================================= -->
                    <div class="text-right">

                        <p class="text-sm font-bold text-zinc-900">
                            {{ auth()->user()->prenom }}
                            {{ auth()->user()->nom }}
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

                </header>


                <!-- =============================================
                     CONTENU DES STATISTIQUES
                     ============================================= -->
                <main class="px-6 py-8 lg:px-10 lg:py-10">


                    <!-- =========================================
                         INTRODUCTION
                         ========================================= -->
                    <section>

                        <p
                            class="
                                text-xs
                                font-black
                                uppercase
                                tracking-[0.3em]
                                text-red-600
                            "
                        >
                            Confidentialité
                        </p>

                        <h2
                            class="
                                mt-2
                                text-3xl
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Préférences des visiteurs
                        </h2>

                        <p
                            class="
                                mt-3
                                max-w-3xl
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            Consultez les décisions relatives aux cookies
                            optionnels enregistrées sur le site Brussels Top Team.
                            Les statistiques sont calculées à partir des
                            préférences actuellement conservées en base de données.
                        </p>

                    </section>


                    <!-- =========================================
                         INDICATEURS PRINCIPAUX
                         ========================================= -->
                    <section class="mt-10">

                        <h3
                            class="
                                text-lg
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Vue d'ensemble
                        </h3>

                        <div
                            class="
                                mt-5
                                grid
                                gap-4
                                sm:grid-cols-2
                                xl:grid-cols-4
                            "
                        >


                            <!-- =====================================
                                 TOTAL DES CONSENTEMENTS
                                 ===================================== -->
                            <article class="border border-zinc-200 bg-white p-6">

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Choix enregistrés
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format($totalConsents, 0, ',', ' ') }}
                                </p>

                                <p class="mt-2 text-xs font-bold text-zinc-500">
                                    Préférences actuellement conservées
                                </p>

                            </article>


                            <!-- =====================================
                                 TOUT ACCEPTER
                                 ===================================== -->
                            <article class="border border-zinc-200 bg-white p-6">

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Tout accepter
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format($acceptedCount, 0, ',', ' ') }}
                                </p>

                                <p class="mt-2 text-xs font-bold text-red-600">
                                    {{ number_format($acceptedPercentage, 1, ',', ' ') }} %
                                    des choix enregistrés
                                </p>

                            </article>


                            <!-- =====================================
                                 TOUT REFUSER
                                 ===================================== -->
                            <article class="border border-zinc-200 bg-white p-6">

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Tout refuser
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format($rejectedCount, 0, ',', ' ') }}
                                </p>

                                <p class="mt-2 text-xs font-bold text-red-600">
                                    {{ number_format($rejectedPercentage, 1, ',', ' ') }} %
                                    des choix enregistrés
                                </p>

                            </article>


                            <!-- =====================================
                                 CHOIX PERSONNALISÉS
                                 ===================================== -->
                            <article class="border border-zinc-200 bg-white p-6">

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-zinc-500
                                    "
                                >
                                    Choix personnalisés
                                </p>

                                <p
                                    class="
                                        mt-3
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format($customizedCount, 0, ',', ' ') }}
                                </p>

                                <p class="mt-2 text-xs font-bold text-red-600">
                                    {{ number_format($customizedPercentage, 1, ',', ' ') }} %
                                    des choix enregistrés
                                </p>

                            </article>

                        </div>

                    </section>


                    <!-- =========================================
                         RÉPARTITION DES DÉCISIONS
                         ========================================= -->
                    <section class="mt-10">

                        <h3
                            class="
                                text-lg
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Répartition des décisions
                        </h3>

                        <p class="mt-2 text-sm text-zinc-500">
                            Proportion de chaque type de choix parmi tous les
                            consentements enregistrés.
                        </p>

                        <div class="mt-5 border border-zinc-200 bg-white p-6">

                            @foreach ([
                                [
                                    'label' => 'Tout accepter',
                                    'count' => $acceptedCount,
                                    'percentage' => $acceptedPercentage,
                                ],
                                [
                                    'label' => 'Tout refuser',
                                    'count' => $rejectedCount,
                                    'percentage' => $rejectedPercentage,
                                ],
                                [
                                    'label' => 'Personnaliser',
                                    'count' => $customizedCount,
                                    'percentage' => $customizedPercentage,
                                ],
                            ] as $stat)

                                <div class="{{ ! $loop->first ? 'mt-7' : '' }}">

                                    <div
                                        class="
                                            flex
                                            flex-wrap
                                            items-center
                                            justify-between
                                            gap-2
                                        "
                                    >

                                        <p class="text-sm font-bold text-zinc-900">
                                            {{ $stat['label'] }}
                                        </p>

                                        <p class="text-sm font-black text-zinc-900">
                                            {{ number_format($stat['count'], 0, ',', ' ') }}

                                            <span class="ml-2 text-red-600">
                                                {{ number_format($stat['percentage'], 1, ',', ' ') }} %
                                            </span>
                                        </p>

                                    </div>

                                    <!-- Barre de progression purement visuelle. -->
                                    <div
                                        class="
                                            mt-3
                                            h-3
                                            w-full
                                            overflow-hidden
                                            rounded-full
                                            bg-zinc-100
                                        "
                                    >

                                        <div
                                            class="h-full rounded-full bg-red-600"
                                            style="width: {{ $stat['percentage'] }}%;"
                                        ></div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </section>


                    <!-- =========================================
                         AUTORISATIONS PAR CATÉGORIE
                         ========================================= -->
                    <section class="mt-10">

                        <h3
                            class="
                                text-lg
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Autorisations par catégorie
                        </h3>

                        <p class="mt-2 max-w-3xl text-sm leading-6 text-zinc-500">
                            Ces chiffres indiquent combien de choix enregistrés
                            autorisent chaque catégorie. Un visiteur peut autoriser
                            une catégorie et refuser l'autre.
                        </p>

                        <div class="mt-5 grid gap-4 lg:grid-cols-2">


                            <!-- =====================================
                                 MESURE D'AUDIENCE
                                 ===================================== -->
                            <article class="border border-zinc-200 bg-white p-6">

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-red-600
                                    "
                                >
                                    Catégorie optionnelle
                                </p>

                                <h4
                                    class="
                                        mt-2
                                        text-lg
                                        font-black
                                        uppercase
                                        text-zinc-900
                                    "
                                >
                                    Mesure d'audience
                                </h4>

                                <p
                                    class="
                                        mt-4
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format($analyticsAllowedCount, 0, ',', ' ') }}
                                </p>

                                <p class="mt-2 text-sm text-zinc-500">
                                    {{ number_format($analyticsAllowedPercentage, 1, ',', ' ') }} %
                                    des choix enregistrés autorisent cette catégorie.
                                </p>

                                <div
                                    class="
                                        mt-5
                                        h-3
                                        w-full
                                        overflow-hidden
                                        rounded-full
                                        bg-zinc-100
                                    "
                                >

                                    <div
                                        class="h-full rounded-full bg-red-600"
                                        style="width: {{ $analyticsAllowedPercentage }}%;"
                                    ></div>

                                </div>

                            </article>


                            <!-- =====================================
                                 CONTENUS EXTERNES
                                 ===================================== -->
                            <article class="border border-zinc-200 bg-white p-6">

                                <p
                                    class="
                                        text-xs
                                        font-black
                                        uppercase
                                        tracking-wider
                                        text-red-600
                                    "
                                >
                                    Catégorie optionnelle
                                </p>

                                <h4
                                    class="
                                        mt-2
                                        text-lg
                                        font-black
                                        uppercase
                                        text-zinc-900
                                    "
                                >
                                    Contenus externes
                                </h4>

                                <p
                                    class="
                                        mt-4
                                        text-3xl
                                        font-black
                                        text-zinc-900
                                    "
                                >
                                    {{ number_format($externalMediaAllowedCount, 0, ',', ' ') }}
                                </p>

                                <p class="mt-2 text-sm text-zinc-500">
                                    {{ number_format($externalMediaAllowedPercentage, 1, ',', ' ') }} %
                                    des choix enregistrés autorisent cette catégorie.
                                </p>

                                <div
                                    class="
                                        mt-5
                                        h-3
                                        w-full
                                        overflow-hidden
                                        rounded-full
                                        bg-zinc-100
                                    "
                                >

                                    <div
                                        class="h-full rounded-full bg-red-600"
                                        style="width: {{ $externalMediaAllowedPercentage }}%;"
                                    ></div>

                                </div>

                            </article>

                        </div>

                    </section>


                    <!-- =========================================
                         VALIDITÉ DES CONSENTEMENTS
                         ========================================= -->
                    <section class="mt-10">

                        <h3
                            class="
                                text-lg
                                font-black
                                uppercase
                                tracking-tight
                                text-zinc-900
                            "
                        >
                            Validité des consentements
                        </h3>

                        <div class="mt-5 border border-zinc-200 bg-white p-6">

                            <div
                                class="
                                    flex
                                    flex-wrap
                                    items-end
                                    justify-between
                                    gap-4
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
                                        Choix encore valides
                                    </p>

                                    <p
                                        class="
                                            mt-3
                                            text-3xl
                                            font-black
                                            text-zinc-900
                                        "
                                    >
                                        {{ number_format($validConsentsCount, 0, ',', ' ') }}
                                    </p>

                                </div>

                                <p class="text-lg font-black text-red-600">
                                    {{ number_format($validConsentsPercentage, 1, ',', ' ') }} %
                                </p>

                            </div>

                            <div
                                class="
                                    mt-5
                                    h-3
                                    w-full
                                    overflow-hidden
                                    rounded-full
                                    bg-zinc-100
                                "
                            >

                                <div
                                    class="h-full rounded-full bg-red-600"
                                    style="width: {{ $validConsentsPercentage }}%;"
                                ></div>

                            </div>

                            <p class="mt-4 text-sm leading-6 text-zinc-500">
                                Un choix est considéré comme valide lorsqu'il
                                n'a pas expiré et correspond à la version
                                actuelle du consentement.
                            </p>

                        </div>

                    </section>


                    <!-- =========================================
                         NOTE SUR L'INTERPRÉTATION DES DONNÉES
                         ========================================= -->
                    <section class="mt-10">

                        <div class="border-l-4 border-red-600 bg-zinc-50 p-6">

                            <h3
                                class="
                                    text-sm
                                    font-black
                                    uppercase
                                    tracking-wider
                                    text-zinc-900
                                "
                            >
                                À propos de ces statistiques
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-zinc-600">
                                Les résultats représentent les préférences
                                actuellement enregistrées, y compris les choix
                                expirés dans les statistiques générales.
                                Ils ne constituent pas un compteur de visites
                                ou de visiteurs uniques.
                            </p>

                            <p class="mt-3 text-sm leading-6 text-zinc-600">
                                Lorsqu'un visiteur modifie ses préférences,
                                son enregistrement est mis à jour. Les décisions
                                précédentes ne sont donc pas comptabilisées
                                séparément.
                            </p>

                        </div>

                    </section>


                </main>

            </div>

        </div>

    </section>

@endsection