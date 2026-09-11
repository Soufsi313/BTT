<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | AJOUT DES CHAMPS BTT DANS LA TABLE USERS
    |--------------------------------------------------------------------------
    |
    | Cette migration ajoute les informations nécessaires
    | au fonctionnement des comptes Brussels Top Team.
    |
    | - role :
    |   Tous les nouveaux utilisateurs sont des adhérents par défaut.
    |
    | - sexe :
    |   Permettra notamment de filtrer le calendrier des entraînements
    |   entre les cours hommes et les cours femmes.
    |
    | - deleted_at :
    |   Permet d'utiliser le système de soft delete de Laravel.
    |
    */

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | RÔLE DE L'UTILISATEUR
            |--------------------------------------------------------------------------
            |
            | Valeurs prévues :
            | - adherent
            | - admin
            |
            | Un nouvel utilisateur reçoit automatiquement
            | le rôle "adherent".
            |
            */
            $table
                ->string('role')
                ->default('adherent')
                ->after('password');


            /*
            |--------------------------------------------------------------------------
            | SEXE / CATÉGORIE DU COMPTE
            |--------------------------------------------------------------------------
            |
            | Utilisé principalement pour le calendrier des entraînements :
            |
            | homme :
            | - boxe hommes
            | - HYROX
            | - futsal
            |
            | femme :
            | - cours destinés aux femmes
            |
            */
            $table
                ->enum('sexe', ['homme', 'femme'])
                ->after('role');


            /*
            |--------------------------------------------------------------------------
            | SOFT DELETE
            |--------------------------------------------------------------------------
            |
            | Lorsqu'un compte est désactivé, Laravel renseigne deleted_at
            | au lieu de supprimer immédiatement la ligne de la base.
            |
            */
            $table->softDeletes();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | ANNULATION DE LA MIGRATION
    |--------------------------------------------------------------------------
    |
    | Cette méthode permet de revenir en arrière avec :
    |
    | php artisan migrate:rollback
    |
    */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropSoftDeletes();

            $table->dropColumn([
                'role',
                'sexe',
            ]);
        });
    }
};