<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * ================================================================
 * MODÈLE UTILISATEUR
 * ================================================================
 *
 * Ce modèle représente un utilisateur de la plateforme BTT.
 *
 * Un utilisateur peut notamment :
 *
 * - être adhérent ;
 * - être administrateur ;
 * - être Super Admin ;
 * - appartenir à une catégorie homme ou femme ;
 * - publier des likes sur les articles du blog ;
 * - être supprimé logiquement grâce à SoftDeletes.
 *
 * ================================================================
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS MODIFIABLES
    |--------------------------------------------------------------------------
    |
    | Le rôle est volontairement absent.
    |
    | Cela empêche qu'un utilisateur puisse tenter de devenir lui-même
    | administrateur en envoyant une valeur "role" depuis un formulaire.
    |
    */
    protected $fillable = [
        'nom',
        'prenom',
        'pseudo',
        'genre',
        'email',
        'password',
    ];


    /*
    |--------------------------------------------------------------------------
    | CHAMPS CACHÉS
    |--------------------------------------------------------------------------
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*
    |--------------------------------------------------------------------------
    | CONVERSIONS AUTOMATIQUES
    |--------------------------------------------------------------------------
    */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | LIKES DES ARTICLES
    |--------------------------------------------------------------------------
    |
    | Un utilisateur peut aimer plusieurs articles.
    |
    | Chaque élément de cette relation correspond à une ligne
    | de la table article_likes.
    |
    | Exemple :
    |
    | $user->articleLikes
    |
    | permet de récupérer tous les likes déposés par l'utilisateur.
    |
    | On pourra également utiliser :
    |
    | $user->articleLikes()->count()
    |
    | pour connaître le nombre total d'articles aimés par ce membre.
    |
    */
    public function articleLikes(): HasMany
    {
        return $this->hasMany(
            ArticleLike::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    |
    | Le Super Admin possède les droits les plus élevés de la plateforme.
    |
    */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }


    /*
    |--------------------------------------------------------------------------
    | ADMINISTRATEUR
    |--------------------------------------------------------------------------
    |
    | Cette méthode retourne true uniquement pour un administrateur normal.
    |
    | Le Super Admin est volontairement distingué afin que nous puissions
    | appliquer des règles différentes entre les deux niveaux.
    |
    */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    /*
    |--------------------------------------------------------------------------
    | ACCÈS À L'ADMINISTRATION
    |--------------------------------------------------------------------------
    |
    | Un Admin OU un Super Admin peut entrer dans l'espace administration.
    |
    */
    public function canAccessAdmin(): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }


    /*
    |--------------------------------------------------------------------------
    | ADHÉRENT
    |--------------------------------------------------------------------------
    */
    public function isAdherent(): bool
    {
        return $this->role === 'adherent';
    }


    /*
    |--------------------------------------------------------------------------
    | CATÉGORIE HOMME
    |--------------------------------------------------------------------------
    */
    public function isHomme(): bool
    {
        return $this->genre === 'homme';
    }


    /*
    |--------------------------------------------------------------------------
    | CATÉGORIE FEMME
    |--------------------------------------------------------------------------
    */
    public function isFemme(): bool
    {
        return $this->genre === 'femme';
    }


    /*
    |--------------------------------------------------------------------------
    | GESTION D'UNE CATÉGORIE
    |--------------------------------------------------------------------------
    |
    | Le Super Admin peut gérer toutes les catégories.
    |
    | Un Admin normal peut uniquement gérer les contenus correspondant
    | à sa propre catégorie.
    |
    | Exemple :
    |
    | Admin homme + contenu homme = autorisé.
    | Admin homme + contenu femme = refusé.
    | Super Admin + contenu femme = autorisé.
    |
    */
    public function canManageGender(string $gender): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->isAdmin()
            && $this->genre === $gender;
    }


    /*
    |--------------------------------------------------------------------------
    | GESTION DES RÔLES
    |--------------------------------------------------------------------------
    |
    | Seul le Super Admin peut nommer ou rétrograder un administrateur.
    |
    */
    public function canManageRoles(): bool
    {
        return $this->isSuperAdmin();
    }
}