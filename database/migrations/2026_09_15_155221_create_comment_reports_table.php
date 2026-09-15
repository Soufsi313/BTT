<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
|--------------------------------------------------------------------------
| Migration : signalements des commentaires
|--------------------------------------------------------------------------
|
| Cette migration crée la table "comment_reports".
|
| Elle permettra aux membres connectés de signaler un commentaire
| qu'ils considèrent comme problématique.
|
| Un signalement contient :
|
| - le commentaire concerné ;
| - le membre ayant effectué le signalement ;
| - le motif choisi ;
| - une précision facultative ;
| - l'état de traitement du signalement.
|
| Une contrainte UNIQUE empêche également un même utilisateur
| de signaler plusieurs fois le même commentaire.
|
|--------------------------------------------------------------------------
*/

return new class extends Migration
{
    /**
     * Création de la table.
     */
    public function up(): void
    {
        Schema::create('comment_reports', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Identifiant
            |--------------------------------------------------------------------------
            */

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Commentaire signalé
            |--------------------------------------------------------------------------
            |
            | Si le commentaire est définitivement supprimé,
            | ses signalements seront également supprimés.
            |
            */

            $table
                ->foreignId('comment_id')
                ->constrained()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Utilisateur ayant effectué le signalement
            |--------------------------------------------------------------------------
            |
            | Si le compte utilisateur disparaît définitivement,
            | nous conservons le signalement mais son auteur devient NULL.
            |
            | Cela permet de conserver l'historique de modération.
            |
            */

            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Motif
            |--------------------------------------------------------------------------
            |
            | On stocke une valeur courte et stable.
            |
            | Exemples prévus pour l'interface :
            |
            | - insultes ;
            | - harcelement ;
            | - spam ;
            | - contenu_inapproprie ;
            | - autre.
            |
            */

            $table->string('reason', 50);


            /*
            |--------------------------------------------------------------------------
            | Précision facultative
            |--------------------------------------------------------------------------
            |
            | Le membre pourra expliquer brièvement son signalement.
            |
            */

            $table
                ->text('details')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Statut du signalement
            |--------------------------------------------------------------------------
            |
            | pending  = en attente de traitement
            | reviewed = examiné par un administrateur
            | rejected = signalement rejeté
            | resolved = problème traité
            |
            */

            $table
                ->string('status', 20)
                ->default('pending');


            /*
            |--------------------------------------------------------------------------
            | Date de traitement
            |--------------------------------------------------------------------------
            |
            | NULL tant qu'un administrateur n'a pas traité
            | le signalement.
            |
            */

            $table
                ->timestamp('reviewed_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Dates Laravel
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Protection contre les signalements multiples
            |--------------------------------------------------------------------------
            |
            | Un utilisateur ne peut signaler qu'une seule fois
            | un même commentaire.
            |
            */

            $table->unique([
                'comment_id',
                'user_id',
            ]);

        });
    }


    /**
     * Suppression de la table en cas de rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_reports');
    }
};