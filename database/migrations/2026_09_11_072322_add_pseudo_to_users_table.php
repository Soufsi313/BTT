<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | AJOUT DU PSEUDO AUX COMPTES BTT
    |--------------------------------------------------------------------------
    |
    | Le pseudo représente le nom public de l'utilisateur.
    |
    | Il sera notamment affiché :
    |
    | - dans le header lorsque l'utilisateur est connecté ;
    | - dans l'espace adhérent ;
    | - plus tard dans les commentaires du blog.
    |
    | Le pseudo est obligatoire et unique.
    |
    */

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table
                ->string('pseudo', 50)
                ->unique()
                ->after('prenom');

        });
    }


    /*
    |--------------------------------------------------------------------------
    | ANNULATION DE LA MIGRATION
    |--------------------------------------------------------------------------
    */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('pseudo');

        });
    }
};