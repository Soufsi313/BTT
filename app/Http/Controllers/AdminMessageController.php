<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BOÎTE DE RÉCEPTION ADMINISTRATION
    |--------------------------------------------------------------------------
    |
    | Cette méthode affiche toutes les conversations reçues par BTT.
    |
    | Le tableau peut être trié directement en cliquant sur ses colonnes :
    |
    | - Expéditeur
    | - Sujet
    | - Type
    | - Statut
    | - Lecture
    | - Dernière activité
    |
    */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | COLONNE DE TRI
        |--------------------------------------------------------------------------
        |
        | Par défaut, les conversations sont classées selon leur dernière
        | activité.
        |
        */
        $sort = (string) $request->query(
            'sort',
            'updated_at'
        );


        /*
        |--------------------------------------------------------------------------
        | DIRECTION DU TRI
        |--------------------------------------------------------------------------
        |
        | desc = décroissant
        | asc  = croissant
        |
        | Pour les dates :
        |
        | desc = plus récent vers plus ancien
        | asc  = plus ancien vers plus récent
        |
        */
        $direction = strtolower(
            (string) $request->query(
                'direction',
                'desc'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | COLONNES AUTORISÉES
        |--------------------------------------------------------------------------
        |
        | Cette vérification empêche qu'une colonne arbitraire soit injectée
        | directement dans la requête SQL depuis l'URL.
        |
        */
        $allowedSorts = [
            'name',
            'subject',
            'type',
            'status',
            'read',
            'updated_at',
        ];


        /*
        |--------------------------------------------------------------------------
        | SÉCURISATION DU TRI
        |--------------------------------------------------------------------------
        */
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'updated_at';
        }


        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE PRINCIPALE
        |--------------------------------------------------------------------------
        |
        | Nous récupérons :
        |
        | - les conversations ;
        | - l'utilisateur associé lorsqu'il existe ;
        | - le nombre de messages entrants non lus.
        |
        | Seuls les messages de type "visitor" ou "member" sont considérés
        | comme nouveaux pour l'administration.
        |
        */
        $query = Conversation::query()
            ->with('user')
            ->withCount([
                'messages as unread_messages_count' => function ($query) {
                    $query
                        ->where('is_read', false)
                        ->whereIn(
                            'sender_type',
                            [
                                'visitor',
                                'member',
                            ]
                        );
                },
            ]);


        /*
        |--------------------------------------------------------------------------
        | TRI : EXPÉDITEUR
        |--------------------------------------------------------------------------
        */
        if ($sort === 'name') {
            $query->orderBy(
                'name',
                $direction
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI : SUJET
        |--------------------------------------------------------------------------
        */
        elseif ($sort === 'subject') {
            $query->orderBy(
                'subject',
                $direction
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI : TYPE
        |--------------------------------------------------------------------------
        |
        | user_id NULL     = Visiteur
        | user_id non NULL = Adhérent
        |
        */
        elseif ($sort === 'type') {
            $query->orderByRaw(
                "
                CASE
                    WHEN user_id IS NULL THEN 0
                    ELSE 1
                END {$direction}
                "
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI : STATUT
        |--------------------------------------------------------------------------
        */
        elseif ($sort === 'status') {
            $query->orderBy(
                'status',
                $direction
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI : LECTURE
        |--------------------------------------------------------------------------
        |
        | Nous utilisons ici le compteur calculé :
        |
        | unread_messages_count
        |
        | Une valeur supérieure à 0 signifie qu'il existe au moins un
        | nouveau message pour l'administration.
        |
        */
        elseif ($sort === 'read') {
            $query->orderBy(
                'unread_messages_count',
                $direction
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI : DERNIÈRE ACTIVITÉ
        |--------------------------------------------------------------------------
        */
        else {
            $query->orderBy(
                'updated_at',
                $direction
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRI SECONDAIRE
        |--------------------------------------------------------------------------
        |
        | Lorsque plusieurs lignes ont exactement la même valeur pour la
        | colonne principale, l'ID évite un ordre imprévisible.
        |
        */
        $query->orderBy(
            'id',
            'desc'
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | withQueryString() conserve le tri sélectionné lorsque l'on passe
        | à une autre page.
        |
        */
        $conversations = $query
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.messages.index',
            [
                'conversations' => $conversations,
                'sort' => $sort,
                'direction' => $direction,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER UNE CONVERSATION
    |--------------------------------------------------------------------------
    */
    public function show(
        Conversation $conversation
    ): View {
        /*
        |--------------------------------------------------------------------------
        | CHARGEMENT DE L'HISTORIQUE
        |--------------------------------------------------------------------------
        */
        $conversation->load([
            'user',

            'messages' => function ($query) {
                $query
                    ->with('user')
                    ->oldest();
            },
        ]);


        /*
        |--------------------------------------------------------------------------
        | MARQUER LES MESSAGES ENTRANTS COMME LUS
        |--------------------------------------------------------------------------
        */
        $conversation
            ->messages()
            ->whereIn(
                'sender_type',
                [
                    'visitor',
                    'member',
                ]
            )
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.messages.show',
            [
                'conversation' => $conversation,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RÉPONDRE À UNE CONVERSATION
    |--------------------------------------------------------------------------
    */
    public function reply(
        Request $request,
        Conversation $conversation
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | CONVERSATION FERMÉE
        |--------------------------------------------------------------------------
        */
        if ($conversation->isClosed()) {
            return back()->with(
                'error',
                'Cette conversation est fermée. Vous devez la rouvrir avant de pouvoir répondre.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate(
            [
                'reply' => [
                    'required',
                    'string',
                    'min:2',
                    'max:5000',
                ],
            ],
            [
                'reply.required' => 'Veuillez écrire une réponse.',
                'reply.string' => 'La réponse indiquée n’est pas valide.',
                'reply.min' => 'Votre réponse doit contenir au moins 2 caractères.',
                'reply.max' => 'Votre réponse ne peut pas dépasser 5000 caractères.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | ADMINISTRATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $admin = $request->user();


        /*
        |--------------------------------------------------------------------------
        | ENREGISTREMENT DE LA RÉPONSE
        |--------------------------------------------------------------------------
        */
        $conversation->messages()->create([
            'user_id' => $admin->id,
            'sender_type' => 'admin',
            'body' => $validated['reply'],
            'is_read' => false,
        ]);


        /*
        |--------------------------------------------------------------------------
        | ACTUALISATION DE LA CONVERSATION
        |--------------------------------------------------------------------------
        |
        | Une nouvelle réponse fait remonter la conversation dans le tri
        | par dernière activité.
        |
        */
        $conversation->touch();


        /*
        |--------------------------------------------------------------------------
        | CONFIRMATION
        |--------------------------------------------------------------------------
        */
        return back()->with(
            'success',
            'Votre réponse a bien été enregistrée.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FERMER UNE CONVERSATION
    |--------------------------------------------------------------------------
    */
    public function close(
        Conversation $conversation
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | DÉJÀ FERMÉE
        |--------------------------------------------------------------------------
        */
        if ($conversation->isClosed()) {
            return back()->with(
                'error',
                'Cette conversation est déjà fermée.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | MISE À JOUR
        |--------------------------------------------------------------------------
        */
        $conversation->update([
            'status' => 'closed',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CONFIRMATION
        |--------------------------------------------------------------------------
        */
        return back()->with(
            'success',
            'La conversation a bien été fermée.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ROUVRIR UNE CONVERSATION
    |--------------------------------------------------------------------------
    */
    public function reopen(
        Conversation $conversation
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | DÉJÀ OUVERTE
        |--------------------------------------------------------------------------
        */
        if ($conversation->isOpen()) {
            return back()->with(
                'error',
                'Cette conversation est déjà ouverte.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | MISE À JOUR
        |--------------------------------------------------------------------------
        */
        $conversation->update([
            'status' => 'open',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CONFIRMATION
        |--------------------------------------------------------------------------
        */
        return back()->with(
            'success',
            'La conversation a bien été rouverte.'
        );
    }
}