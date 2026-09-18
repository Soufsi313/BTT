<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * ================================================================
 * MODÈLE USER
 * ================================================================
 *
 * Ce modèle représente les utilisateurs de la plateforme BTT :
 *
 * - adhérents ;
 * - administrateurs ;
 * - super administrateurs.
 *
 * Il contient également les relations et méthodes permettant
 * de gérer :
 *
 * - les rôles ;
 * - le genre ;
 * - les likes ;
 * - les signalements de commentaires ;
 * - la vérification de l'adresse email.
 *
 * ================================================================
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use MustVerifyEmailTrait;
    use Notifiable;
    use SoftDeletes;


    /**
     * ============================================================
     * CHAMPS AUTORISÉS
     * ============================================================
     */
    protected $fillable = [
        'nom',
        'prenom',
        'pseudo',
        'genre',
        'email',
        'password',
    ];


    /**
     * ============================================================
     * CHAMPS MASQUÉS
     * ============================================================
     *
     * Ces informations ne doivent jamais être exposées lors
     * d'une conversion du modèle en tableau ou en JSON.
     *
     * ============================================================
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * ============================================================
     * CONVERSIONS AUTOMATIQUES
     * ============================================================
     *
     * email_verified_at :
     * Laravel convertit automatiquement cette colonne en date.
     *
     * password :
     * Laravel hache automatiquement le mot de passe avant
     * son enregistrement dans la base de données.
     *
     * ============================================================
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * ============================================================
     * ENVOYER L'EMAIL DE VÉRIFICATION BTT
     * ============================================================
     *
     * Laravel appelle automatiquement cette méthode lorsqu'une
     * vérification d'adresse email doit être envoyée.
     *
     * Par défaut, Laravel utilise sa propre notification générique.
     *
     * Nous la remplaçons ici par :
     *
     * App\Notifications\VerifyEmailNotification
     *
     * Cela nous permet d'utiliser notre template personnalisé BTT
     * tout en conservant le système sécurisé de vérification fourni
     * par Laravel.
     *
     * Le lien reste :
     *
     * - temporaire ;
     * - signé ;
     * - associé à l'utilisateur ;
     * - associé à son adresse email.
     *
     * ============================================================
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(
            new VerifyEmailNotification()
        );
    }


    /**
     * ============================================================
     * LIKES DES ARTICLES
     * ============================================================
     *
     * Retourne tous les likes placés par cet utilisateur
     * sur les articles du blog.
     *
     * Exemple :
     *
     * $user->articleLikes
     *
     * ============================================================
     */
    public function articleLikes(): HasMany
    {
        return $this->hasMany(
            ArticleLike::class
        );
    }


    /**
     * ============================================================
     * SIGNALEMENTS DE COMMENTAIRES
     * ============================================================
     *
     * Retourne tous les signalements de commentaires effectués
     * par cet utilisateur.
     *
     * Exemple :
     *
     * $user->commentReports
     *
     * ============================================================
     */
    public function commentReports(): HasMany
    {
        return $this->hasMany(
            CommentReport::class
        );
    }


    /**
     * ============================================================
     * SUPER ADMINISTRATEUR
     * ============================================================
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }


    /**
     * ============================================================
     * ADMINISTRATEUR
     * ============================================================
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    /**
     * ============================================================
     * ACCÈS À L'ADMINISTRATION
     * ============================================================
     *
     * Les administrateurs et super administrateurs peuvent
     * accéder au back-office BTT.
     *
     * ============================================================
     */
    public function canAccessAdmin(): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }


    /**
     * ============================================================
     * ADHÉRENT
     * ============================================================
     */
    public function isAdherent(): bool
    {
        return $this->role === 'adherent';
    }


    /**
     * ============================================================
     * GENRE : HOMME
     * ============================================================
     */
    public function isHomme(): bool
    {
        return $this->genre === 'homme';
    }


    /**
     * ============================================================
     * GENRE : FEMME
     * ============================================================
     */
    public function isFemme(): bool
    {
        return $this->genre === 'femme';
    }


    /**
     * ============================================================
     * AUTORISATION DE GESTION SELON LE GENRE
     * ============================================================
     *
     * Le Super Admin peut gérer tout le monde.
     *
     * Un administrateur classique ne peut gérer que les utilisateurs
     * correspondant à son propre genre.
     *
     * ============================================================
     */
    public function canManageGender(string $gender): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->isAdmin()
            && $this->genre === $gender;
    }


    /**
     * ============================================================
     * GESTION DES RÔLES
     * ============================================================
     *
     * Seul le Super Admin peut promouvoir ou rétrograder
     * les administrateurs.
     *
     * ============================================================
     */
    public function canManageRoles(): bool
    {
        return $this->isSuperAdmin();
    }
}