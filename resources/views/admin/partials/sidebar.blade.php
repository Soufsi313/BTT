{{--
|--------------------------------------------------------------------------
| BARRE LATÉRALE COMMUNE DE L'ADMINISTRATION BTT
|--------------------------------------------------------------------------
|
| Ce fichier contient désormais l'unique menu latéral utilisé par
| l'ensemble de l'administration Brussels Top Team.
|
| Il doit être inclus dans les différentes vues avec :
|
|     @include('admin.partials.sidebar')
|
| IMPORTANT :
|
| - le contenu du menu reste identique quelle que soit la page ;
| - seule la rubrique actuellement visitée passe en rouge ;
| - Produits reste visible mais désactivé pour le moment ;
| - Administrateurs et Statistiques des cookies sont réservés au Super Admin ;
| - le bouton "Retour au site" est conservé.
|
|--------------------------------------------------------------------------
--}}

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

    {{--
    |--------------------------------------------------------------------------
    | IDENTITÉ ADMIN
    |--------------------------------------------------------------------------
    --}}
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


    {{--
    |--------------------------------------------------------------------------
    | NAVIGATION ADMIN
    |--------------------------------------------------------------------------
    |
    | request()->routeIs() permet de savoir automatiquement quelle
    | rubrique est actuellement ouverte.
    |
    | Cela signifie que le menu ne change jamais de contenu.
    | Seule sa présentation visuelle change pour la rubrique active.
    |
    |--------------------------------------------------------------------------
    --}}
    <nav class="flex-1 px-4 py-6">

        <div class="space-y-1">


            {{--
            |--------------------------------------------------------------------------
            | TABLEAU DE BORD
            |--------------------------------------------------------------------------
            --}}
            <a
                href="{{ route('admin.dashboard') }}"
                @class([
                    'flex',
                    'items-center',
                    'rounded-md',
                    'px-4',
                    'py-3',
                    'text-sm',
                    'font-bold',
                    'transition',

                    'bg-red-600 text-white' =>
                        request()->routeIs('admin.dashboard'),

                    'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                        ! request()->routeIs('admin.dashboard'),
                ])
            >
                Tableau de bord
            </a>


            {{--
            |--------------------------------------------------------------------------
            | GESTION DES ADHÉRENTS
            |--------------------------------------------------------------------------
            --}}
            <a
                href="{{ route('admin.members.index') }}"
                @class([
                    'flex',
                    'items-center',
                    'rounded-md',
                    'px-4',
                    'py-3',
                    'text-sm',
                    'font-bold',
                    'transition',

                    'bg-red-600 text-white' =>
                        request()->routeIs('admin.members.*'),

                    'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                        ! request()->routeIs('admin.members.*'),
                ])
            >
                Adhérents
            </a>


            {{--
            |--------------------------------------------------------------------------
            | GESTION DU CALENDRIER
            |--------------------------------------------------------------------------
            --}}
            <a
                href="{{ route('admin.courses.index') }}"
                @class([
                    'flex',
                    'items-center',
                    'rounded-md',
                    'px-4',
                    'py-3',
                    'text-sm',
                    'font-bold',
                    'transition',

                    'bg-red-600 text-white' =>
                        request()->routeIs('admin.courses.*'),

                    'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                        ! request()->routeIs('admin.courses.*'),
                ])
            >
                Calendrier
            </a>


            {{--
            |--------------------------------------------------------------------------
            | ARTICLES DU BLOG
            |--------------------------------------------------------------------------
            |
            | La rubrique reste active pour toutes les routes qui commencent
            | par admin.articles.
            |
            | Cela comprend notamment :
            |
            | - la liste ;
            | - la création ;
            | - la modification ;
            | - la gestion des articles supprimés.
            |
            |--------------------------------------------------------------------------
            --}}
            <a
                href="{{ route('admin.articles.index') }}"
                @class([
                    'flex',
                    'items-center',
                    'rounded-md',
                    'px-4',
                    'py-3',
                    'text-sm',
                    'font-bold',
                    'transition',

                    'bg-red-600 text-white' =>
                        request()->routeIs('admin.articles.*'),

                    'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                        ! request()->routeIs('admin.articles.*'),
                ])
            >
                Articles
            </a>


            {{--
            |--------------------------------------------------------------------------
            | COMMENTAIRES DU BLOG
            |--------------------------------------------------------------------------
            |
            | Permet d'accéder à la modération générale des commentaires.
            |
            |--------------------------------------------------------------------------
            --}}
            <a
                href="{{ route('admin.comments.index') }}"
                @class([
                    'flex',
                    'items-center',
                    'rounded-md',
                    'px-4',
                    'py-3',
                    'text-sm',
                    'font-bold',
                    'transition',

                    'bg-red-600 text-white' =>
                        request()->routeIs('admin.comments.*'),

                    'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                        ! request()->routeIs('admin.comments.*'),
                ])
            >
                Commentaires
            </a>


            {{--
            |--------------------------------------------------------------------------
            | SIGNALEMENTS
            |--------------------------------------------------------------------------
            |
            | Cette rubrique contient les signalements envoyés par
            | les membres concernant les commentaires du blog.
            |
            |--------------------------------------------------------------------------
            --}}
            <a
                href="{{ route('admin.comment-reports.index') }}"
                @class([
                    'flex',
                    'items-center',
                    'rounded-md',
                    'px-4',
                    'py-3',
                    'text-sm',
                    'font-bold',
                    'transition',

                    'bg-red-600 text-white' =>
                        request()->routeIs('admin.comment-reports.*'),

                    'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                        ! request()->routeIs('admin.comment-reports.*'),
                ])
            >
                Signalements
            </a>


            {{--
            |--------------------------------------------------------------------------
            | PRODUITS
            |--------------------------------------------------------------------------
            |
            | La boutique BTT n'est pas encore développée.
            |
            | Nous conservons donc exactement le comportement actuel :
            | l'entrée est visible dans le menu mais elle n'est pas cliquable.
            |
            |--------------------------------------------------------------------------
            --}}
            <span
                class="
                    block
                    rounded-md
                    px-4
                    py-3
                    text-sm
                    font-bold
                    text-zinc-500
                "
            >
                Produits
            </span>


            {{--
            |--------------------------------------------------------------------------
            | MESSAGES
            |--------------------------------------------------------------------------
            |
            | La messagerie de l'administration est fonctionnelle.
            |
            |--------------------------------------------------------------------------
            --}}
            <a
                href="{{ route('admin.messages.index') }}"
                @class([
                    'flex',
                    'items-center',
                    'rounded-md',
                    'px-4',
                    'py-3',
                    'text-sm',
                    'font-bold',
                    'transition',

                    'bg-red-600 text-white' =>
                        request()->routeIs('admin.messages.*'),

                    'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                        ! request()->routeIs('admin.messages.*'),
                ])
            >
                Messages
            </a>


            {{--
            |--------------------------------------------------------------------------
            | ADMINISTRATEURS
            |--------------------------------------------------------------------------
            |
            | Cette entrée doit rester réservée aux Super Admins.
            |
            | Un administrateur classique ne verra donc jamais ce lien
            | dans sa navigation.
            |
            |--------------------------------------------------------------------------
            --}}
            @if (auth()->user()->isSuperAdmin())

                <a
                    href="{{ route('admin.administrators.index') }}"
                    @class([
                        'flex',
                        'items-center',
                        'rounded-md',
                        'px-4',
                        'py-3',
                        'text-sm',
                        'font-bold',
                        'transition',

                        'bg-red-600 text-white' =>
                            request()->routeIs('admin.administrators.*'),

                        'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                            ! request()->routeIs('admin.administrators.*'),
                    ])
                >
                    Administrateurs
                </a>

            @endif


            {{--
            |--------------------------------------------------------------------------
            | STATISTIQUES DES COOKIES - SUPER ADMIN UNIQUEMENT
            |--------------------------------------------------------------------------
            |
            | Le lien est masqué pour les administrateurs classiques.
            | L'accès direct à la route doit également être protégé côté serveur.
            |
            |--------------------------------------------------------------------------
            --}}
            @if (auth()->user()->isSuperAdmin())

                <a
                    href="{{ route('admin.cookies.index') }}"
                    @class([
                        'flex',
                        'items-center',
                        'rounded-md',
                        'px-4',
                        'py-3',
                        'text-sm',
                        'font-bold',
                        'transition',

                        'bg-red-600 text-white' =>
                            request()->routeIs('admin.cookies.*'),

                        'text-zinc-600 hover:bg-zinc-200 hover:text-red-600' =>
                            ! request()->routeIs('admin.cookies.*'),
                    ])
                >
                    Statistiques des cookies
                </a>

            @endif

        </div>

    </nav>


    {{--
    |--------------------------------------------------------------------------
    | RETOUR AU SITE
    |--------------------------------------------------------------------------
    |
    | Nous conservons le comportement qui existait déjà dans le dashboard :
    | le bouton retourne vers l'espace membre.
    |
    |--------------------------------------------------------------------------
    --}}
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