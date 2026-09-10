@extends('layouts.app')

@section('title', 'Brussels Top Team')

@section(
    'meta_description',
    'Découvrez Brussels Top Team, ses disciplines sportives, ses coachs et ses activités à Bruxelles.'
)

@section('content')

    <!-- Hero -->
    <section class="relative w-full overflow-hidden bg-black">

        <!-- Bannière principale -->
        <img
            src="{{ asset('images/BTTbanniere.png') }}"
            alt="Brussels Top Team - Dépasse tes limites"
            class="block h-auto w-full"
        >

        <!-- Bouton : Découvrir nos disciplines -->
        <a
            href="{{ url('/disciplines') }}"
            class="
                group
                absolute
                left-[4.6%]
                top-[75.1%]
                flex
                h-[8.1%]
                w-[20.1%]
                items-center
                justify-between
                bg-red-600
                px-[1.8%]
                font-black
                uppercase
                tracking-wide
                text-white
                transition-all
                duration-300
                hover:bg-white
                hover:text-black
            "
        >
            <span class="text-[clamp(0.35rem,1vw,1.05rem)]">
                Découvrir nos disciplines
            </span>

            <svg
                class="h-[35%] w-auto transition-transform duration-300 group-hover:translate-x-1"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M5 12h14"></path>
                <path d="m13 6 6 6-6 6"></path>
            </svg>
        </a>

        <!-- Bouton : Rejoindre BTT -->
        <a
            href="{{ url('/inscription') }}"
            class="
                group
                absolute
                left-[25.9%]
                top-[75.1%]
                flex
                h-[8.1%]
                w-[14.1%]
                items-center
                justify-between
                border-2
                border-red-600
                bg-black
                px-[1.8%]
                font-black
                uppercase
                tracking-wide
                text-white
                transition-all
                duration-300
                hover:bg-red-600
            "
        >
            <span class="text-[clamp(0.35rem,1vw,1.05rem)]">
                Rejoindre BTT
            </span>

            <svg
                class="h-[35%] w-auto transition-transform duration-300 group-hover:translate-x-1"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M5 12h14"></path>
                <path d="m13 6 6 6-6 6"></path>
            </svg>
        </a>

    </section>

@endsection