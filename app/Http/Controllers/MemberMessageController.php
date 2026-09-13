<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MemberMessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES CONVERSATIONS DE L'ADHÉRENT
    |--------------------------------------------------------------------------
    |
    | Cette méthode affiche uniquement les conversations appartenant
    | à l'utilisateur actuellement connecté.
    |
    | C'est très important pour la sécurité :
    |
    | un adhérent ne doit jamais pouvoir consulter les conversations
    | d'un autre adhérent.
    |
    */
    public function index(
        Request $request
    ): View {
        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DES CONVERSATIONS
        |--------------------------------------------------------------------------
        |
        | Nous filtrons obligatoirement avec :
        |
        | user_id = utilisateur connecté
        |
        | Nous calculons également le nombre de réponses non lues envoyées
        | par l'administration.
        |
        | Contrairement à la boîte admin :
        |
        | - les messages "member" ne sont pas considérés comme nouveaux ;
        | - seuls les messages "admin" peuvent être nouveaux pour l'adhérent.
        |
        */
        $conversations = Conversation::query()
            ->where(
                'user_id',
                $user->id
            )
            ->withCount([
                'messages as unread_admin_messages_count' => function ($query) {
                    $query
                        ->where('sender_type', 'admin')
                        ->where('is_read', false);
                },
            ])
            ->latest('updated_at')
            ->paginate(20);


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE
        |--------------------------------------------------------------------------
        */
        return view(
            'member.messages.index',
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
    | Cette méthode affiche l'historique complet d'une conversation.
    |
    | Avant toute chose, nous vérifions que la conversation appartient
    | réellement à l'utilisateur connecté.
    |
    */
    public function show(
        Request $request,
        Conversation $conversation
    ): View {
        /*
        |--------------------------------------------------------------------------
        | SÉCURITÉ : PROPRIÉTAIRE DE LA CONVERSATION
        |--------------------------------------------------------------------------
        |
        | Même si quelqu'un modifie manuellement l'identifiant dans l'URL,
        | il ne pourra pas ouvrir la conversation d'un autre adhérent.
        |
        | Exemple interdit :
        |
        | /membre/messages/5
        |
        | si la conversation 5 appartient à un autre utilisateur.
        |
        */
        $this->ensureConversationBelongsToUser(
            $request,
            $conversation
        );


        /*
        |--------------------------------------------------------------------------
        | CHARGEMENT DE L'HISTORIQUE
        |--------------------------------------------------------------------------
        |
        | Nous récupérons tous les messages de la conversation dans
        | l'ordre chronologique.
        |
        */
        $conversation->load([
            'messages' => function ($query) {
                $query
                    ->with('user')
                    ->oldest();
            },
        ]);


        /*
        |--------------------------------------------------------------------------
        | MARQUER LES RÉPONSES ADMIN COMME LUES
        |--------------------------------------------------------------------------
        |
        | Lorsqu'un adhérent ouvre une conversation, toutes les réponses
        | non lues de l'administration passent à :
        |
        | is_read = true
        |
        | Les propres messages de l'adhérent ne sont pas concernés.
        |
        */
        $conversation
            ->messages()
            ->where('sender_type', 'admin')
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
            'member.messages.show',
            [
                'conversation' => $conversation,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RÉPONDRE À UNE CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Un adhérent peut répondre à une conversation existante uniquement :
    |
    | - si elle lui appartient ;
    | - si elle est encore ouverte.
    |
    */
    public function reply(
        Request $request,
        Conversation $conversation
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | SÉCURITÉ : PROPRIÉTAIRE
        |--------------------------------------------------------------------------
        */
        $this->ensureConversationBelongsToUser(
            $request,
            $conversation
        );


        /*
        |--------------------------------------------------------------------------
        | CONVERSATION FERMÉE
        |--------------------------------------------------------------------------
        |
        | Une conversation fermée reste consultable mais l'adhérent ne peut
        | plus y ajouter de nouveau message.
        |
        */
        if ($conversation->isClosed()) {
            return back()->with(
                'error',
                'Cette conversation est fermée. Vous ne pouvez plus y répondre.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION DU MESSAGE
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
                'reply.required' => 'Veuillez écrire votre message.',
                'reply.string' => 'Le message indiqué n’est pas valide.',
                'reply.min' => 'Votre message doit contenir au moins 2 caractères.',
                'reply.max' => 'Votre message ne peut pas dépasser 5000 caractères.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | ENREGISTREMENT DU MESSAGE
        |--------------------------------------------------------------------------
        |
        | sender_type = member
        |
        | permet de savoir que le message a été envoyé depuis l'espace
        | privé d'un adhérent.
        |
        | is_read = false
        |
        | signifie que l'administration ne l'a pas encore lu.
        |
        */
        $conversation
            ->messages()
            ->create([
                'user_id' => $user->id,
                'sender_type' => 'member',
                'body' => $validated['reply'],
                'is_read' => false,
            ]);


        /*
        |--------------------------------------------------------------------------
        | ACTUALISATION DE LA CONVERSATION
        |--------------------------------------------------------------------------
        |
        | Cela met à jour updated_at.
        |
        | La conversation remontera ainsi dans la boîte de réception admin
        | et dans la liste de l'adhérent.
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
            'Votre message a bien été envoyé à l’administration.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER LE PROPRIÉTAIRE D'UNE CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Cette méthode privée centralise notre contrôle de sécurité.
    |
    | Une conversation peut être ouverte depuis l'espace adhérent seulement
    | lorsque son user_id correspond exactement à l'utilisateur connecté.
    |
    */
    private function ensureConversationBelongsToUser(
        Request $request,
        Conversation $conversation
    ): void {
        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | REFUS D'ACCÈS
        |--------------------------------------------------------------------------
        |
        | abort_unless() arrête immédiatement la requête avec une erreur 403
        | si la condition n'est pas respectée.
        |
        | Nous convertissons les IDs en entiers pour effectuer une
        | comparaison stricte et prévisible.
        |
        */
        abort_unless(
            (int) $conversation->user_id === (int) $user->id,
            403,
            'Vous n’êtes pas autorisé à consulter cette conversation.'
        );
    }
}