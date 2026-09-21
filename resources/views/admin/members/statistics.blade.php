
{{-- 
|--------------------------------------------------------------------------
| BTT — STATISTIQUES DES ADHÉRENTS
|--------------------------------------------------------------------------
|
| Cette page affiche les nouvelles inscriptions des adhérents.
|
| Les filtres et les données sont préparés par :
| AdminMemberStatisticsController
|
| Les autorisations sont contrôlées côté serveur.
| Le filtrage affiché ici ne remplace jamais ces vérifications.
|
--}}

@extends('layouts.app')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | PARAMÈTRES DE LA PAGE
    |--------------------------------------------------------------------------
    */

    $periodLabels = [
        'day' => 'Jour',
        'week' => 'Semaine',
        'month' => 'Mois',
        'year' => 'Année',
    ];

    $selectedPeriod = $filters['period'] ?? 'month';
    $selectedGenre = $filters['genre'] ?? 'tous';

    $groups = $statistics['groups'] ?? [];

    $genreLabels = [
        'tous' => 'Tous les adhérents',
        'homme' => 'Hommes',
        'femme' => 'Femmes',
    ];

    $exportParameters = [
        'period' => $selectedPeriod,
        'start_date' => $filters['start_date'],
        'end_date' => $filters['end_date'],
        'genre' => $selectedGenre,
    ];
@endphp

<div class="min-h-screen bg-zinc-950 text-white">

    <div class="mx-auto w-full max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{--
        |--------------------------------------------------------------------------
        | EN-TÊTE
        |--------------------------------------------------------------------------
        --}}

        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

            <div>
                <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-red-500">
                    Administration BTT
                </p>

                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                    Statistiques des adhérents
                </h1>

                <p class="mt-3 max-w-3xl text-sm leading-6 text-zinc-400">
                    Consultez l'évolution des nouvelles inscriptions et exportez
                    les résultats au format Excel.
                </p>
            </div>

            <a
                href="{{ route('admin.members.index') }}"
                class="inline-flex shrink-0 items-center justify-center rounded-lg border border-zinc-700 px-4 py-2.5 text-sm font-semibold text-zinc-200 transition hover:border-zinc-500 hover:bg-zinc-900"
            >
                Retour aux adhérents
            </a>

        </div>


        {{--
        |--------------------------------------------------------------------------
        | FILTRES
        |--------------------------------------------------------------------------
        |
        | Le formulaire utilise GET afin de conserver les filtres dans l'URL.
        |
        --}}

        <section class="mb-8 rounded-2xl border border-zinc-800 bg-zinc-900/70 p-5 sm:p-6">

            <div class="mb-6">
                <h2 class="text-lg font-bold">
                    Filtres
                </h2>

                <p class="mt-1 text-sm text-zinc-400">
                    Choisissez le regroupement, la période et les adhérents à afficher.
                </p>
            </div>

            <form
                method="GET"
                action="{{ route('admin.members.statistics') }}"
                class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4"
            >

                {{--
                | REGROUPEMENT
                --}}

                <div>
                    <label
                        for="period"
                        class="mb-2 block text-sm font-semibold text-zinc-200"
                    >
                        Regroupement
                    </label>

                    <select
                        id="period"
                        name="period"
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2.5 text-sm text-white outline-none transition focus:border-red-500 focus:ring-1 focus:ring-red-500"
                    >
                        @foreach ($periodLabels as $value => $label)
                            <option
                                value="{{ $value }}"
                                @selected($selectedPeriod === $value)
                            >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{--
                | DATE DE DÉBUT
                --}}

                <div>
                    <label
                        for="start_date"
                        class="mb-2 block text-sm font-semibold text-zinc-200"
                    >
                        Date de début
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date', $filters['start_date']) }}"
                        required
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2.5 text-sm text-white outline-none transition focus:border-red-500 focus:ring-1 focus:ring-red-500"
                    >
                </div>


                {{--
                | DATE DE FIN
                --}}

                <div>
                    <label
                        for="end_date"
                        class="mb-2 block text-sm font-semibold text-zinc-200"
                    >
                        Date de fin
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date', $filters['end_date']) }}"
                        required
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2.5 text-sm text-white outline-none transition focus:border-red-500 focus:ring-1 focus:ring-red-500"
                    >
                </div>


                {{--
                | GENRE
                |
                | Seul le Super Admin peut modifier ce filtre.
                | Pour un Admin classique, le genre est imposé par le serveur.
                --}}

                <div>
                    <label
                        for="genre"
                        class="mb-2 block text-sm font-semibold text-zinc-200"
                    >
                        Adhérents
                    </label>

                    @if ($isSuperAdmin)

                        <select
                            id="genre"
                            name="genre"
                            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2.5 text-sm text-white outline-none transition focus:border-red-500 focus:ring-1 focus:ring-red-500"
                        >
                            @foreach ($genreLabels as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected($selectedGenre === $value)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                    @else

                        <input
                            type="hidden"
                            name="genre"
                            value="{{ $selectedGenre }}"
                        >

                        <div class="flex min-h-11 items-center rounded-lg border border-zinc-800 bg-zinc-800/60 px-3 text-sm text-zinc-300">
                            {{ $genreLabels[$selectedGenre] ?? 'Mon groupe' }}
                        </div>

                    @endif
                </div>


                {{--
                | ERREURS DE VALIDATION
                --}}

                @if ($errors->any())

                    <div class="sm:col-span-2 xl:col-span-4">
                        <div class="rounded-lg border border-red-800 bg-red-950/40 p-4 text-sm text-red-200">

                            <p class="mb-2 font-semibold">
                                Vérifiez les filtres :
                            </p>

                            <ul class="list-inside list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    </div>

                @endif


                {{--
                | ACTIONS
                --}}

                <div class="flex flex-wrap gap-3 sm:col-span-2 xl:col-span-4">

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-red-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-zinc-900"
                    >
                        Appliquer les filtres
                    </button>

                    <a
                        href="{{ route('admin.members.statistics') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-zinc-700 px-5 py-2.5 text-sm font-semibold text-zinc-200 transition hover:bg-zinc-800"
                    >
                        Réinitialiser
                    </a>

                    <a
                        href="{{ route('admin.members.statistics.export', $exportParameters) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-emerald-700 bg-emerald-950/40 px-5 py-2.5 text-sm font-bold text-emerald-300 transition hover:bg-emerald-900/40"
                    >
                        Télécharger Excel (.xlsx)
                    </a>

                </div>

            </form>

        </section>


        {{--
        |--------------------------------------------------------------------------
        | INFORMATIONS SUR LA PÉRIODE
        |--------------------------------------------------------------------------
        --}}

        <div class="mb-6 flex flex-wrap items-center gap-2 text-sm text-zinc-400">

            <span class="rounded-full border border-zinc-700 bg-zinc-900 px-3 py-1">
                Du {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }}
                au {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}
            </span>

            <span class="rounded-full border border-zinc-700 bg-zinc-900 px-3 py-1">
                Par {{ strtolower($periodLabels[$selectedPeriod] ?? 'mois') }}
            </span>

            <span class="rounded-full border border-zinc-700 bg-zinc-900 px-3 py-1">
                {{ $genreLabels[$selectedGenre] ?? 'Adhérents' }}
            </span>

        </div>


        {{--
        |--------------------------------------------------------------------------
        | RÉSULTATS PAR GROUPE
        |--------------------------------------------------------------------------
        |
        | En mode "tous", le Super Admin voit trois tableaux.
        | Dans les autres cas, un seul tableau est affiché.
        |
        --}}

        @forelse ($groups as $groupKey => $group)

            @php
                $groupTitle = match ($groupKey) {
                    'tous' => 'Tous les adhérents',
                    'homme' => 'Hommes',
                    'femme' => 'Femmes',
                    default => 'Adhérents',
                };
            @endphp

            <section class="mb-8 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900/70">

                {{--
                | EN-TÊTE DU GROUPE ET TOTAL
                --}}

                <div class="flex flex-col gap-4 border-b border-zinc-800 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">

                    <div>
                        <h2 class="text-xl font-bold">
                            {{ $groupTitle }}
                        </h2>

                        <p class="mt-1 text-sm text-zinc-400">
                            Nouvelles inscriptions sur la période sélectionnée
                        </p>
                    </div>

                    <div class="rounded-xl border border-red-900/50 bg-red-950/30 px-5 py-3 sm:text-right">

                        <p class="text-xs font-semibold uppercase tracking-wider text-red-300">
                            Total des inscriptions
                        </p>

                        <p class="mt-1 text-3xl font-extrabold text-white">
                            {{ number_format($group['total_registrations'], 0, ',', ' ') }}
                        </p>

                    </div>

                </div>


                {{--
                | TABLEAU DES INSCRIPTIONS
                --}}

                <div class="overflow-x-auto">

                    <table class="min-w-full text-left text-sm">

                        <thead class="bg-zinc-950/70 text-xs uppercase tracking-wider text-zinc-400">

                            <tr>
                                <th scope="col" class="px-5 py-4 font-semibold">
                                    Période
                                </th>

                                <th scope="col" class="px-5 py-4 font-semibold">
                                    Début
                                </th>

                                <th scope="col" class="px-5 py-4 font-semibold">
                                    Fin
                                </th>

                                <th scope="col" class="px-5 py-4 text-right font-semibold">
                                    Nouvelles inscriptions
                                </th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-zinc-800">

                            @forelse ($group['rows'] as $row)

                                <tr class="transition hover:bg-zinc-800/40">

                                    <td class="whitespace-nowrap px-5 py-4 font-semibold text-zinc-100">
                                        {{ $row['label'] }}
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-zinc-400">
                                        {{ \Carbon\Carbon::parse($row['start_date'])->format('d/m/Y') }}
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-zinc-400">
                                        {{ \Carbon\Carbon::parse($row['end_date'])->format('d/m/Y') }}
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-right font-bold tabular-nums text-white">
                                        {{ number_format($row['registrations'], 0, ',', ' ') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-zinc-400">
                                        Aucune période à afficher.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                        <tfoot class="border-t border-zinc-700 bg-zinc-950/50">

                            <tr>
                                <th colspan="3" scope="row" class="px-5 py-4 text-left font-bold text-zinc-200">
                                    TOTAL
                                </th>

                                <td class="px-5 py-4 text-right text-lg font-extrabold tabular-nums text-white">
                                    {{ number_format($group['total_registrations'], 0, ',', ' ') }}
                                </td>
                            </tr>

                        </tfoot>

                    </table>

                </div>

            </section>

        @empty

            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-8 text-center text-zinc-400">
                Aucune statistique disponible pour les filtres sélectionnés.
            </div>

        @endforelse


        {{--
        |--------------------------------------------------------------------------
        | NOTE MÉTHODOLOGIQUE
        |--------------------------------------------------------------------------
        |
        | Le compteur représente des inscriptions historiques et non
        | le nombre d'adhérents actuellement actifs.
        |
        --}}

        <div class="rounded-xl border border-zinc-800 bg-zinc-900/50 p-5 text-sm leading-6 text-zinc-400">

            <p class="font-semibold text-zinc-200">
                À propos de ces statistiques
            </p>

            <p class="mt-2">
                Les chiffres correspondent aux comptes dont la date de création
                se situe dans la période sélectionnée. Les comptes archivés
                restent comptabilisés dans les inscriptions historiques.
                Il ne s'agit pas du nombre d'adhérents actuellement actifs.
            </p>

            <p class="mt-2">
                Les statistiques portent sur les utilisateurs dont le rôle
                actuel est « adhérent ». Un compte promu administrateur
                n'est donc plus inclus dans ces résultats.
            </p>

        </div>

    </div>

</div>

@endsection