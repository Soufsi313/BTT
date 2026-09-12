<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | AJOUT DU SOFT DELETE AUX COURS
    |--------------------------------------------------------------------------
    |
    | La colonne deleted_at permettra de supprimer logiquement un cours
    | sans réellement effacer sa ligne dans la base de données.
    |
    | Lorsque deleted_at est NULL :
    |     le cours est actif dans la base.
    |
    | Lorsque deleted_at contient une date :
    |     le cours est considéré comme supprimé.
    |
    */

    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            /*
            | Laravel crée automatiquement une colonne :
            |
            | deleted_at TIMESTAMP NULL
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
    | Cette méthode permet de retirer la colonne deleted_at
    | si nous annulons cette migration.
    |
    */

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            $table->dropSoftDeletes();
        });
    }
};