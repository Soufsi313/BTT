<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * ===============================================================
     * CRÉATION DE LA TABLE ARTICLES
     * ===============================================================
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {

            /**
             * -------------------------------------------------------
             * IDENTIFIANT
             * -------------------------------------------------------
             */
            $table->id();


            /**
             * -------------------------------------------------------
             * AUTEUR
             * -------------------------------------------------------
             *
             * L'article peut appartenir à un administrateur.
             *
             * nullable :
             * permet de conserver l'article même si le compte
             * de l'auteur est supprimé plus tard.
             *
             * nullOnDelete :
             * si l'utilisateur disparaît définitivement,
             * author_id devient simplement NULL.
             */
            $table
                ->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /**
             * -------------------------------------------------------
             * TITRE
             * -------------------------------------------------------
             *
             * Exemple :
             *
             * Brussels Top Team participe au tournoi de Bruxelles
             */
            $table->string('title', 255);


            /**
             * -------------------------------------------------------
             * SLUG
             * -------------------------------------------------------
             *
             * Le slug permettra d'obtenir une URL propre.
             *
             * Exemple :
             *
             * /blog/btt-participe-tournoi-bruxelles
             */
            $table
                ->string('slug', 255)
                ->unique();


            /**
             * -------------------------------------------------------
             * CATÉGORIE
             * -------------------------------------------------------
             *
             * Pour le moment nous utilisons une simple chaîne.
             *
             * Exemples futurs :
             *
             * Actualité
             * Futsal
             * Boxe
             * HYROX
             * Association
             * Événement
             */
            $table
                ->string('category', 100)
                ->default('Actualité');


            /**
             * -------------------------------------------------------
             * RÉSUMÉ
             * -------------------------------------------------------
             *
             * Court texte utilisé notamment dans la liste du blog.
             */
            $table
                ->text('excerpt')
                ->nullable();


            /**
             * -------------------------------------------------------
             * CONTENU COMPLET
             * -------------------------------------------------------
             *
             * longText nous laisse suffisamment de place pour écrire
             * des articles longs.
             *
             * Plus tard, ce contenu sera géré via un véritable éditeur
             * permettant d'insérer texte, titres et images.
             */
            $table->longText('content');


            /**
             * -------------------------------------------------------
             * BANNIÈRE PRINCIPALE
             * -------------------------------------------------------
             *
             * Nous stockerons ici le chemin du fichier.
             *
             * Exemple :
             *
             * articles/bannieres/tournoi-btt.jpg
             */
            $table
                ->string('banner_image', 500)
                ->nullable();


            /**
             * -------------------------------------------------------
             * STATUT DE PUBLICATION
             * -------------------------------------------------------
             *
             * draft     = brouillon
             * published = publié
             */
            $table
                ->enum(
                    'status',
                    [
                        'draft',
                        'published',
                    ]
                )
                ->default('draft');


            /**
             * -------------------------------------------------------
             * ARTICLE MIS EN AVANT
             * -------------------------------------------------------
             *
             * Permettra de faire ressortir certains articles
             * dans la future page Blog.
             */
            $table
                ->boolean('is_featured')
                ->default(false);


            /**
             * -------------------------------------------------------
             * DATE DE PUBLICATION
             * -------------------------------------------------------
             *
             * Peut rester vide tant que l'article est un brouillon.
             */
            $table
                ->timestamp('published_at')
                ->nullable();


            /**
             * -------------------------------------------------------
             * DATES LARAVEL
             * -------------------------------------------------------
             *
             * created_at
             * updated_at
             */
            $table->timestamps();


            /**
             * -------------------------------------------------------
             * SUPPRESSION RÉCUPÉRABLE
             * -------------------------------------------------------
             *
             * Comme pour nos adhérents et entraînements,
             * nous utilisons le Soft Delete.
             *
             * Un article supprimé pourra donc être restauré.
             */
            $table->softDeletes();


            /**
             * -------------------------------------------------------
             * INDEX
             * -------------------------------------------------------
             *
             * Optimise les futures recherches des articles publiés.
             */
            $table->index([
                'status',
                'published_at',
            ]);

            $table->index('category');

            $table->index('is_featured');
        });
    }


    /**
     * ===============================================================
     * SUPPRESSION DE LA TABLE
     * ===============================================================
     *
     * Utilisé lorsque Laravel annule cette migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};