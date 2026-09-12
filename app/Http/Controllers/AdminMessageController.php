<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Contracts\View\View;

class AdminMessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BOÎTE DE RÉCEPTION ADMINISTRATION
    |--------------------------------------------------------------------------
    |
    | Cette méthode récupère les conversations envoyées :
    |
    | - par les visiteurs du site ;
    | - par les adhérents connectés.
    |
    | Toutes les conversations sont visibles par les administrateurs.
    |
    | Nous affichons également le nombre de messages non lus provenant
    | d'un visiteur ou d'un adhérent.
    |
    */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DES CONVERSATIONS
        |--------------------------------------------------------------------------
        |
        | with('user')
        |
        | Permet de récupérer l'adhérent lié à la conversation lorsqu'il
        | s'agit d'un utilisateur connecté.
        |
        | Pour un visiteur, user_id est null.
        |
        |
        | withCount(...)
        |
        | Nous calculons le nombre de messages non lus envoyés par :
        |
        | - visitor
        | - member
        |
        | Les futurs messages envoyés par un administrateur ne doivent pas
        | être considérés comme des messages entrants non lus.
        |
        |
        | latest()
        |
        | Les conversations les plus récentes apparaissent en premier.
        |
        |
        | paginate(20)
        |
        | Nous limitons l'affichage à 20 conversations par page afin de
        | garder l'administration rapide même lorsque beaucoup de messages
        | seront enregistrés.
        |
        */
        $conversations = Conversation::query()
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
            ])
            ->latest()
            ->paginate(20);


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA BOÎTE DE RÉCEPTION
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.messages.index',
            [
                'conversations' => $conversations,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER UNE CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Cette méthode affiche l'intégralité d'une conversation :
    |
    | - premier message du visiteur ou de l'adhérent ;
    | - futures réponses de l'administration ;
    | - futurs messages supplémentaires.
    |
    */
    public function show(Conversation $conversation): View
    {
        /*
        |--------------------------------------------------------------------------
        | CHARGEMENT DES INFORMATIONS
        |--------------------------------------------------------------------------
        |
        | Nous récupérons :
        |
        | - l'utilisateur lié à la conversation s'il existe ;
        | - tous les messages ;
        | - l'utilisateur lié à chaque message lorsqu'il existe.
        |
        | Les messages sont classés du plus ancien au plus récent afin de
        | conserver l'ordre naturel d'une conversation.
        |
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
        |
        | Lorsqu'un administrateur ouvre la conversation, les messages
        | provenant d'un visiteur ou d'un adhérent passent à "lus".
        |
        | Pour le moment, is_read représente donc :
        |
        | "lu par l'administration"
        |
        | et non :
        |
        | "lu individuellement par chaque administrateur".
        |
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
        | AFFICHAGE DE LA CONVERSATION
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.messages.show',
            [
                'conversation' => $conversation,
            ]
        );
    }
}