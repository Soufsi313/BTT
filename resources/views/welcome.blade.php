@extends('layouts.app')

@section('title', 'Brussels Top Team')

@section('meta_description', 'Découvrez Brussels Top Team, ses disciplines sportives, ses coachs et ses activités à Bruxelles.')

@section('content')

    <section class="flex min-h-[calc(100vh-6rem)] items-center justify-center px-6">
        <div class="text-center">

            <p class="mb-4 text-sm font-bold uppercase tracking-[0.35em] text-red-500">
                Brussels Top Team
            </p>

            <h1 class="text-5xl font-black uppercase tracking-tight sm:text-6xl lg:text-8xl">
                Dépasse tes limites
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-lg text-zinc-400">
                Boxe anglaise, fitness, HYROX, futsal et activités sportives
                au cœur de Bruxelles.
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">

                <a
                    href="#"
                    class="rounded-md bg-red-600 px-7 py-4 font-bold uppercase transition hover:bg-red-700"
                >
                    Découvrir nos disciplines
                </a>

                <a
                    href="#"
                    class="rounded-md border border-zinc-700 px-7 py-4 font-bold uppercase transition hover:border-white"
                >
                    En savoir plus
                </a>

            </div>

        </div>
    </section>

@endsection