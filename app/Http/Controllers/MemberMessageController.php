<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    | Un adhérent ne doit jamais pouvoir consulter les conversations
    | d'un autre utilisateur.
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
        | Nous récupérons uniquement les conversations de l'utilisateur.
        |
        | Nous calculons également le nombre de réponses non lues
        | envoyées par l'administration.
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
    | FORMULAIRE DE NOUVELLE CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Cette page permet à l'adhérent connecté de démarrer directement
    | une nouvelle conversation avec l'administration.
    |
    | Son identité et son adresse email seront automatiquement récupérées
    | depuis son compte.
    |
    */
    public function create(): View
    {
        return view('member.messages.create');
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UNE NOUVELLE CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Cette méthode :
    |
    | 1. valide le sujet et le message ;
    | 2. crée la conversation ;
    | 3. crée le premier message de l'adhérent ;
    | 4. redirige vers la conversation nouvellement créée.
    |
    */
    public function store(
        Request $request
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        |
        | Nous utilisons exactement les mêmes sujets que pour le système
        | de contact déjà existant.
        |
        */
        $validated = $request->validate(
            [
                'subject' => [
                    'required',
                    'string',
                    'in:abonnement,entrainements,compte,autre',
                ],

                'message' => [
                    'required',
                    'string',
                    'min:10',
                    'max:5000',
                ],
            ],
            [
                'subject.required' => 'Veuillez sélectionner le sujet de votre demande.',
                'subject.in' => 'Le sujet sélectionné n’est pas valide.',

                'message.required' => 'Veuillez écrire votre message.',
                'message.string' => 'Le message indiqué n’est pas valide.',
                'message.min' => 'Votre message doit contenir au moins 10 caractères.',
                'message.max' => 'Votre message ne peut pas dépasser 5000 caractères.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        |
        | Nous n'utilisons aucun nom ou email provenant du formulaire.
        |
        | Cela évite qu'un adhérent puisse envoyer une conversation
        | sous l'identité d'une autre personne.
        |
        */
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DE LA CONVERSATION ET DU PREMIER MESSAGE
        |--------------------------------------------------------------------------
        |
        | Nous utilisons une transaction :
        |
        | soit la conversation ET le message sont créés ;
        | soit aucune des deux opérations n'est conservée.
        |
        */
        $conversation = DB::transaction(
            function () use (
                $user,
                $validated
            ) {
                /*
                |--------------------------------------------------------------------------
                | CRÉATION DE LA CONVERSATION
                |--------------------------------------------------------------------------
                */
                $conversation = Conversation::create([
                    'user_id' => $user->id,

                    'name' => trim(
                        $user->prenom . ' ' . $user->nom
                    ),

                    'email' => $user->email,

                    'subject' => $validated['subject'],

                    'status' => 'open',
                ]);


                /*
                |--------------------------------------------------------------------------
                | PREMIER MESSAGE DE L'ADHÉRENT
                |--------------------------------------------------------------------------
                |
                | is_read = false signifie que l'administration n'a pas
                | encore consulté ce nouveau message.
                |
                */
                $conversation
                    ->messages()
                    ->create([
                        'user_id' => $user->id,
                        'sender_type' => 'member',
                        'body' => $validated['message'],
                        'is_read' => false,
                    ]);


                return $conversation;
            }
        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        |
        | Après l'envoi, l'adhérent arrive directement dans la conversation
        | qu'il vient de créer.
        |
        */
        return redirect()
            ->route(
                'member.messages.show',
                $conversation
            )
            ->with(
                'success',
                'Votre message a bien été envoyé à l’administration.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER UNE CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Cette méthode affiche l'historique complet d'une conversation.
    |
    | Avant toute chose, nous vérifions qu'elle appartient bien
    | à l'utilisateur connecté.
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
        */
        $this->ensureConversationBelongsToUser(
            $request,
            $conversation
        );


        /*
        |--------------------------------------------------------------------------
        | CHARGEMENT DE L'HISTORIQUE
        |--------------------------------------------------------------------------
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
        | Dès que l'adhérent ouvre la conversation, les messages admin
        | non lus deviennent lus.
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
    | Un adhérent peut répondre uniquement :
    |
    | - si la conversation lui appartient ;
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
        | is_read = false signifie que le message devra apparaître comme
        | nouveau dans la messagerie de l'administration.
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
        | La conversation remonte ainsi en tête des listes.
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
    | Cette méthode privée centralise le contrôle de sécurité.
    |
    | Même si un utilisateur modifie manuellement l'identifiant d'une
    | conversation dans son URL, il ne pourra pas consulter celle
    | appartenant à un autre adhérent.
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
        */
        abort_unless(
            (int) $conversation->user_id === (int) $user->id,
            403,
            'Vous n’êtes pas autorisé à consulter cette conversation.'
        );
    }
}