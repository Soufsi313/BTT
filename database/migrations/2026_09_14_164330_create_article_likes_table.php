<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
|--------------------------------------------------------------------------
| MIGRATION : LIKES DES ARTICLES
|--------------------------------------------------------------------------
|
| Cette table enregistre les likes déposés par les membres
| sur les articles du blog Brussels Top Team.
|
| Un like appartient :
|
| - à un article ;
| - à un utilisateur.
|
| Un utilisateur ne peut liker un même article qu'une seule fois.
|
*/

return new class extends Migration
{
    /**
     * ============================================================
     * CRÉATION DE LA TABLE
     * ============================================================
     */
    public function up(): void
    {
        Schema::create('article_likes', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | IDENTIFIANT
            |--------------------------------------------------------------------------
            */

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | ARTICLE
            |--------------------------------------------------------------------------
            |
            | Si l'article est définitivement supprimé de la base,
            | ses likes sont également supprimés.
            |
            */

            $table
                ->foreignId('article_id')
                ->constrained('articles')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | UTILISATEUR
            |--------------------------------------------------------------------------
            |
            | Chaque like appartient obligatoirement à un utilisateur.
            |
            | Si le compte est définitivement supprimé,
            | ses likes sont également supprimés.
            |
            */

            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | DATES
            |--------------------------------------------------------------------------
            |
            | Laravel enregistrera automatiquement la date de création
            | du like ainsi que sa dernière modification.
            |
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | UN SEUL LIKE PAR MEMBRE ET PAR ARTICLE
            |--------------------------------------------------------------------------
            |
            | Cette contrainte empêche directement MySQL d'enregistrer
            | deux likes identiques pour le même membre et le même article.
            |
            */

            $table->unique([
                'article_id',
                'user_id',
            ]);


            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            |
            | Ces index faciliteront les recherches de likes
            | par article ou par utilisateur.
            |
            */

            $table->index([
                'article_id',
                'created_at',
            ]);

            $table->index([
                'user_id',
                'created_at',
            ]);
        });
    }


    /**
     * ============================================================
     * SUPPRESSION DE LA TABLE
     * ============================================================
     */
    public function down(): void
    {
        Schema::dropIfExists('article_likes');
    }
};