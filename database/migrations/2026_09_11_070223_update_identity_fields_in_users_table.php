<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | MISE À JOUR DE L'IDENTITÉ DES UTILISATEURS BTT
    |--------------------------------------------------------------------------
    |
    | L'inscription Brussels Top Team doit identifier clairement
    | chaque adhérent.
    |
    | Nous allons donc :
    |
    | - renommer "name" en "nom" ;
    | - ajouter le champ "prenom" ;
    | - renommer "sexe" en "genre".
    |
    | Ces informations seront obligatoires lors de l'inscription.
    |
    */

    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | RENOMMAGE DU NOM
        |--------------------------------------------------------------------------
        |
        | Laravel crée par défaut une colonne appelée "name".
        | Pour BTT, nous utilisons le terme français "nom".
        |
        */
        Schema::table('users', function (Blueprint $table) {

            $table->renameColumn('name', 'nom');

        });


        /*
        |--------------------------------------------------------------------------
        | AJOUT DU PRÉNOM
        |--------------------------------------------------------------------------
        |
        | Le prénom est obligatoire afin d'identifier précisément
        | l'adhérent.
        |
        */
        Schema::table('users', function (Blueprint $table) {

            $table
                ->string('prenom')
                ->after('nom');

        });


        /*
        |--------------------------------------------------------------------------
        | RENOMMAGE SEXE → GENRE
        |--------------------------------------------------------------------------
        |
        | Le champ sert notamment à déterminer quels entraînements
        | seront visibles dans le calendrier de l'adhérent.
        |
        | Valeurs actuellement prévues :
        |
        | - homme
        | - femme
        |
        */
        Schema::table('users', function (Blueprint $table) {

            $table->renameColumn('sexe', 'genre');

        });
    }


    /*
    |--------------------------------------------------------------------------
    | ANNULATION DE LA MIGRATION
    |--------------------------------------------------------------------------
    |
    | Permet de revenir à la structure précédente en cas de rollback.
    |
    */

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | GENRE → SEXE
        |--------------------------------------------------------------------------
        */
        Schema::table('users', function (Blueprint $table) {

            $table->renameColumn('genre', 'sexe');

        });


        /*
        |--------------------------------------------------------------------------
        | SUPPRESSION DU PRÉNOM
        |--------------------------------------------------------------------------
        */
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('prenom');

        });


        /*
        |--------------------------------------------------------------------------
        | NOM → NAME
        |--------------------------------------------------------------------------
        */
        Schema::table('users', function (Blueprint $table) {

            $table->renameColumn('nom', 'name');

        });
    }
};