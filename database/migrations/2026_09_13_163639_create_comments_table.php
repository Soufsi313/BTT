<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * ============================================================
     * CRÉATION DE LA TABLE COMMENTS
     * ============================================================
     */
    public function up(): void
    {
        Schema::create(
            'comments',
            function (Blueprint $table) {

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
                | Le commentaire appartient obligatoirement à un article.
                |
                | Si l'article était un jour supprimé définitivement,
                | ses commentaires seraient également supprimés.
                |
                */

                $table
                    ->foreignId('article_id')
                    ->constrained()
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | AUTEUR
                |--------------------------------------------------------------------------
                |
                | Seul un utilisateur connecté pourra publier.
                |
                | On autorise toutefois NULL afin de conserver le commentaire
                | si le compte utilisateur était un jour supprimé définitivement.
                |
                */

                $table
                    ->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | CONTENU DU COMMENTAIRE
                |--------------------------------------------------------------------------
                */

                $table->text('body');


                /*
                |--------------------------------------------------------------------------
                | STATUT DE MODÉRATION
                |--------------------------------------------------------------------------
                |
                | published :
                | commentaire visible publiquement.
                |
                | hidden :
                | commentaire masqué par l'administration.
                |
                */

                $table
                    ->enum(
                        'status',
                        [
                            'published',
                            'hidden',
                        ]
                    )
                    ->default('published');


                /*
                |--------------------------------------------------------------------------
                | DATES
                |--------------------------------------------------------------------------
                */

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | SUPPRESSION LOGIQUE
                |--------------------------------------------------------------------------
                |
                | Permet à l'administration de supprimer un commentaire
                | sans l'effacer immédiatement de la base.
                |
                */

                $table->softDeletes();


                /*
                |--------------------------------------------------------------------------
                | INDEX
                |--------------------------------------------------------------------------
                |
                | Ces index faciliteront l'affichage des commentaires
                | d'un article et la future modération.
                |
                */

                $table->index([
                    'article_id',
                    'status',
                    'created_at',
                ]);

                $table->index([
                    'user_id',
                    'created_at',
                ]);
            }
        );
    }


    /**
     * ============================================================
     * ANNULATION DE LA MIGRATION
     * ============================================================
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'comments'
        );
    }
};