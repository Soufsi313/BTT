<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | CRÉATION DE LA TABLE DES ENTRAÎNEMENTS
    |--------------------------------------------------------------------------
    |
    | Cette table contiendra les entraînements publiés par
    | l'administration Brussels Top Team.
    |
    | Les adhérents verront ensuite uniquement les cours correspondant
    | à leur catégorie : homme ou femme.
    |
    */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | IDENTIFIANT DU COURS
            |--------------------------------------------------------------------------
            */
            $table->id();


            /*
            |--------------------------------------------------------------------------
            | TITRE DU COURS
            |--------------------------------------------------------------------------
            |
            | Exemple :
            | "Boxe anglaise"
            | "HYROX"
            | "Futsal"
            |
            */
            $table->string('title', 150);


            /*
            |--------------------------------------------------------------------------
            | DISCIPLINE
            |--------------------------------------------------------------------------
            |
            | On utilise volontairement une chaîne de caractères plutôt qu'un
            | enum afin de pouvoir ajouter de nouvelles disciplines plus tard
            | sans devoir modifier la structure de la base de données.
            |
            */
            $table->string('discipline', 100);


            /*
            |--------------------------------------------------------------------------
            | DATE DE L'ENTRAÎNEMENT
            |--------------------------------------------------------------------------
            */
            $table->date('course_date');


            /*
            |--------------------------------------------------------------------------
            | HORAIRES
            |--------------------------------------------------------------------------
            */
            $table->time('start_time');

            $table->time('end_time');


            /*
            |--------------------------------------------------------------------------
            | PUBLIC CONCERNÉ
            |--------------------------------------------------------------------------
            |
            | homme :
            | cours visibles par les adhérents de catégorie homme.
            |
            | femme :
            | cours visibles par les adhérentes de catégorie femme.
            |
            */
            $table->enum('target_gender', [
                'homme',
                'femme',
            ]);


            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS COMPLÉMENTAIRES
            |--------------------------------------------------------------------------
            |
            | Champ facultatif.
            |
            | Exemple :
            | "Prévoir des gants"
            | "Séance annulée en cas de fermeture de la salle"
            |
            */
            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | ADMINISTRATEUR AYANT CRÉÉ LE COURS
            |--------------------------------------------------------------------------
            |
            | Ce champ servira plus tard dans l'espace administrateur.
            |
            | Il est nullable pour nous permettre de construire et tester
            | le calendrier avant la création complète de l'administration.
            |
            */
            $table
                ->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | ACTIVATION DU COURS
            |--------------------------------------------------------------------------
            |
            | Permettra plus tard à un administrateur de masquer un cours
            | sans forcément le supprimer.
            |
            */
            $table
                ->boolean('is_active')
                ->default(true);


            /*
            |--------------------------------------------------------------------------
            | DATES DE CRÉATION ET DE MODIFICATION
            |--------------------------------------------------------------------------
            */
            $table->timestamps();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION DE LA TABLE
    |--------------------------------------------------------------------------
    */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};