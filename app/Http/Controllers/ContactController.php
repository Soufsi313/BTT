<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UNE NOUVELLE DEMANDE DE CONTACT
    |--------------------------------------------------------------------------
    |
    | Cette méthode pourra être utilisée :
    |
    | - par un visiteur non connecté ;
    | - par un adhérent connecté.
    |
    | Elle crée :
    |
    | 1. une conversation ;
    | 2. le premier message de cette conversation.
    |
    */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION DU FORMULAIRE
        |--------------------------------------------------------------------------
        |
        | Les quatre sujets autorisés correspondent aux catégories
        | définies pour le formulaire de contact BTT.
        |
        */
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],

                'subject' => [
                    'required',
                    Rule::in([
                        'abonnement',
                        'entrainements',
                        'compte',
                        'autre',
                    ]),
                ],

                'message' => [
                    'required',
                    'string',
                    'min:10',
                    'max:5000',
                ],
            ],
            [
                /*
                |--------------------------------------------------------------------------
                | MESSAGES DE VALIDATION EN FRANÇAIS
                |--------------------------------------------------------------------------
                */
                'name.required' => 'Veuillez indiquer votre nom.',
                'name.string' => 'Le nom indiqué n’est pas valide.',
                'name.max' => 'Le nom ne peut pas dépasser 150 caractères.',

                'email.required' => 'Veuillez indiquer votre adresse e-mail.',
                'email.email' => 'Veuillez indiquer une adresse e-mail valide.',
                'email.max' => 'L’adresse e-mail est trop longue.',

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
        | Si une personne est connectée, nous relions automatiquement
        | la conversation à son compte.
        |
        | Nous utilisons également son identité et son e-mail enregistrés
        | dans BTT plutôt que de faire confiance à des valeurs modifiées
        | manuellement dans le formulaire.
        |
        */
        $user = $request->user();

        if ($user) {
            $name = trim(
                $user->prenom . ' ' . $user->nom
            );

            $email = $user->email;

            $senderType = 'member';
        } else {
            /*
            |--------------------------------------------------------------------------
            | VISITEUR NON CONNECTÉ
            |--------------------------------------------------------------------------
            */
            $name = $validated['name'];
            $email = $validated['email'];
            $senderType = 'visitor';
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION BASE DE DONNÉES
        |--------------------------------------------------------------------------
        |
        | La conversation et son premier message doivent être créés
        | ensemble.
        |
        | Si une erreur se produit pendant la création du message,
        | Laravel annulera également la création de la conversation.
        |
        */
        DB::transaction(function () use (
            $user,
            $name,
            $email,
            $senderType,
            $validated
        ) {

            /*
            |--------------------------------------------------------------------------
            | CRÉATION DE LA CONVERSATION
            |--------------------------------------------------------------------------
            */
            $conversation = Conversation::create([
                'user_id' => $user?->id,

                'name' => $name,

                'email' => $email,

                'subject' => $validated['subject'],

                'status' => 'open',
            ]);


            /*
            |--------------------------------------------------------------------------
            | CRÉATION DU PREMIER MESSAGE
            |--------------------------------------------------------------------------
            |
            | Grâce à la relation définie dans Conversation.php,
            | Laravel renseigne automatiquement conversation_id.
            |
            */
            $conversation->messages()->create([
                'user_id' => $user?->id,

                'sender_type' => $senderType,

                'body' => $validated['message'],

                /*
                |--------------------------------------------------------------------------
                | MESSAGE NON LU
                |--------------------------------------------------------------------------
                |
                | Le message vient d'arriver dans l'administration.
                | Il doit donc être considéré comme non lu.
                |
                */
                'is_read' => false,
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | RETOUR VERS LE FORMULAIRE
        |--------------------------------------------------------------------------
        |
        | Pour le moment, nous affichons simplement une confirmation.
        |
        | L'e-mail automatique de confirmation sera ajouté plus tard,
        | lorsque la partie e-mail sera configurée.
        |
        */
        return back()->with(
            'success',
            'Votre message a bien été envoyé à l’administration Brussels Top Team.'
        );
    }
}