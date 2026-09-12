<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crée la table contenant les conversations
     * entre les visiteurs / adhérents et l'administration.
     */
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | IDENTIFIANT
            |--------------------------------------------------------------------------
            */
            $table->id();


            /*
            |--------------------------------------------------------------------------
            | ADHÉRENT CONNECTÉ
            |--------------------------------------------------------------------------
            |
            | Si la conversation est créée par un adhérent connecté,
            | son identifiant sera enregistré ici.
            |
            | Pour un visiteur non connecté, cette valeur restera NULL.
            |
            */
            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | IDENTITÉ DU CONTACT
            |--------------------------------------------------------------------------
            |
            | Ces informations sont nécessaires pour les visiteurs.
            |
            | Pour un adhérent connecté, nous pourrons également les
            | enregistrer afin de garder un historique cohérent.
            |
            */
            $table->string('name', 150);

            $table->string('email', 255);


            /*
            |--------------------------------------------------------------------------
            | SUJET DE LA CONVERSATION
            |--------------------------------------------------------------------------
            |
            | Exemple :
            |
            | - Abonnements / Affiliation
            | - Nos entraînements
            | - Inscription / Compte
            | - Autre demande
            |
            */
            $table->string('subject', 100);


            /*
            |--------------------------------------------------------------------------
            | STATUT
            |--------------------------------------------------------------------------
            |
            | open :
            | conversation encore en cours.
            |
            | closed :
            | conversation terminée.
            |
            */
            $table
                ->enum(
                    'status',
                    [
                        'open',
                        'closed',
                    ]
                )
                ->default('open');


            /*
            |--------------------------------------------------------------------------
            | DATES AUTOMATIQUES
            |--------------------------------------------------------------------------
            */
            $table->timestamps();
        });
    }


    /**
     * Supprime la table si la migration est annulée.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};