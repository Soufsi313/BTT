<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crée la table contenant les messages
     * appartenant à une conversation.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | IDENTIFIANT
            |--------------------------------------------------------------------------
            */
            $table->id();


            /*
            |--------------------------------------------------------------------------
            | CONVERSATION
            |--------------------------------------------------------------------------
            |
            | Chaque message appartient obligatoirement
            | à une conversation.
            |
            | Si une conversation est supprimée,
            | ses messages seront également supprimés.
            |
            */
            $table
                ->foreignId('conversation_id')
                ->constrained('conversations')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | UTILISATEUR AYANT ENVOYÉ LE MESSAGE
            |--------------------------------------------------------------------------
            |
            | Pour un adhérent ou un administrateur connecté,
            | nous enregistrons son user_id.
            |
            | Pour un visiteur non connecté, cette valeur reste NULL.
            |
            */
            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | TYPE D'EXPÉDITEUR
            |--------------------------------------------------------------------------
            |
            | visitor :
            | visiteur public non connecté.
            |
            | member :
            | adhérent connecté.
            |
            | admin :
            | administrateur ou Super Admin.
            |
            */
            $table->enum(
                'sender_type',
                [
                    'visitor',
                    'member',
                    'admin',
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | CONTENU DU MESSAGE
            |--------------------------------------------------------------------------
            */
            $table->text('body');


            /*
            |--------------------------------------------------------------------------
            | MESSAGE LU
            |--------------------------------------------------------------------------
            |
            | Cette colonne servira plus tard pour :
            |
            | - afficher les nouveaux messages dans l'administration ;
            | - afficher les réponses non lues côté adhérent.
            |
            */
            $table
                ->boolean('is_read')
                ->default(false);


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
        Schema::dropIfExists('messages');
    }
};