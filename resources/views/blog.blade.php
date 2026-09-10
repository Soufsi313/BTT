@extends('layouts.app')

@section('title', 'Blog - Brussels Top Team')

@section(
    'meta_description',
    'Le blog de Brussels Top Team est actuellement en construction.'
)

@section('content')

    <!-- =========================================================
         PAGE BLOG - EN CONSTRUCTION
         ========================================================= -->
    <section
        class="
            flex
            min-h-[65vh]
            items-center
            bg-black
            px-6
            py-20
            lg:px-8
        "
    >

        <div class="mx-auto w-full max-w-7xl">

            <div class="max-w-3xl">

                <!-- Nom de la rubrique -->
                <p
                    class="
                        text-sm
                        font-black
                        uppercase
                        tracking-[0.3em]
                        text-red-500
                    "
                >
                    Brussels Top Team
                </p>


                <!-- Titre -->
                <h1
                    class="
                        mt-4
                        text-5xl
                        font-black
                        uppercase
                        tracking-tight
                        text-white
                        sm:text-6xl
                        lg:text-7xl
                    "
                >
                    Blog
                </h1>


                <!-- Ligne graphique BTT -->
                <div class="my-8 h-1 w-20 bg-red-600"></div>


                <!-- Message temporaire -->
                <h2
                    class="
                        text-2xl
                        font-black
                        uppercase
                        text-zinc-300
                        sm:text-3xl
                    "
                >
                    Page en construction
                </h2>


                <p
                    class="
                        mt-5
                        max-w-2xl
                        text-lg
                        leading-8
                        text-zinc-500
                    "
                >
                    Cette section du site est actuellement en préparation.
                    Le blog Brussels Top Team sera disponible prochainement.
                </p>

            </div>

        </div>

    </section>

@endsection