
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ================================================================
 * TABLE DES CONSENTEMENTS AUX COOKIES
 * ================================================================
 *
 * Cette table conserve l'état actuel des préférences d'un navigateur.
 *
 * Un consentement peut être :
 *
 * - anonyme, pour un visiteur non connecté ;
 * - associé à un utilisateur BTT, lorsque cela est applicable.
 *
 * Les catégories optionnelles sont désactivées par défaut.
 *
 * Les cookies strictement nécessaires ne sont pas représentés par
 * une case de consentement : ils restent indispensables au
 * fonctionnement et à la sécurité du site.
 *
 * ================================================================
 */
return new class extends Migration
{
    /**
     * Crée la table des consentements.
     */
    public function up(): void
    {
        Schema::create('cookie_consents', function (Blueprint $table) {

            /*
             * Identifiant interne de l'enregistrement.
             */
            $table->id();

            /*
             * Identifiant aléatoire du navigateur.
             *
             * Il permettra de retrouver le choix actuel sans stocker
             * directement l'adresse IP ou l'agent utilisateur.
             *
             * Sa valeur sera générée par le futur gestionnaire Laravel.
             */
            $table->uuid('visitor_token')->unique();

            /*
             * Utilisateur éventuellement associé au consentement.
             *
             * NULL pour un visiteur anonyme.
             *
             * Si le compte est définitivement supprimé, la référence
             * sera retirée sans supprimer automatiquement le choix.
             * La politique de conservation sera gérée séparément.
             */
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
             * État actuel des catégories optionnelles.
             *
             * Ces colonnes préparent les catégories envisagées.
             * Aucun outil optionnel ne devra être chargé simplement
             * parce que la colonne correspondante existe.
             */
            $table->boolean('analytics_allowed')->default(false);

            $table->boolean('external_media_allowed')->default(false);

            /*
             * Type de dernière décision explicite.
             *
             * accepted   : toutes les catégories proposées acceptées ;
             * rejected   : toutes les catégories optionnelles refusées ;
             * customized : préférences choisies individuellement.
             */
            $table->enum('decision', [
                'accepted',
                'rejected',
                'customized',
            ]);

            /*
             * Version du texte et des catégories présentés à
             * l'utilisateur lors de son choix.
             *
             * Cela permettra de demander un nouveau choix en cas de
             * modification substantielle des finalités.
             */
            $table->unsignedInteger('consent_version')->default(1);

            /*
             * Date de la dernière décision explicite.
             */
            $table->timestamp('decided_at');

            /*
             * Date d'expiration du choix enregistré.
             *
             * Le gestionnaire devra demander un nouveau choix
             * lorsqu'il sera expiré.
             */
            $table->timestamp('expires_at')->index();

            /*
             * Dates techniques de création et de modification.
             */
            $table->timestamps();

            /*
             * Index pour retrouver les consentements associés
             * à un utilisateur connecté.
             */
            $table->index('user_id');
        });
    }

    /**
     * Supprime la table en cas de rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
    }
};