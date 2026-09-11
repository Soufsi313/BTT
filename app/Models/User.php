<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | CHAMPS AUTORISÉS À L'ENREGISTREMENT
    |--------------------------------------------------------------------------
    |
    | Ces champs pourront être renseignés lors de la création
    | ou de la modification d'un utilisateur.
    |
    */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'genre',
    ];


    /*
    |--------------------------------------------------------------------------
    | CHAMPS CACHÉS
    |--------------------------------------------------------------------------
    |
    | Ces informations ne doivent pas apparaître lorsque
    | l'utilisateur est transformé en tableau ou en JSON.
    |
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*
    |--------------------------------------------------------------------------
    | CONVERSIONS AUTOMATIQUES
    |--------------------------------------------------------------------------
    |
    | Laravel convertira automatiquement certaines valeurs
    | dans le bon type.
    |
    */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',

            /*
            |--------------------------------------------------------------------------
            | MOT DE PASSE
            |--------------------------------------------------------------------------
            |
            | Laravel hash automatiquement le mot de passe
            | grâce au cast "hashed".
            |
            */
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER SI L'UTILISATEUR EST ADMIN
    |--------------------------------------------------------------------------
    |
    | Exemple futur :
    |
    | if ($user->isAdmin()) {
    |     // accès à l'espace admin
    | }
    |
    */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER SI L'UTILISATEUR EST ADHÉRENT
    |--------------------------------------------------------------------------
    */
    public function isAdherent(): bool
    {
        return $this->role === 'adherent';
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER SI L'UTILISATEUR EST UN HOMME
    |--------------------------------------------------------------------------
    |
    | Sera notamment utilisé pour filtrer le calendrier.
    |
    */
    public function isHomme(): bool
    {
        return $this->genre === 'homme';
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER SI L'UTILISATEUR EST UNE FEMME
    |--------------------------------------------------------------------------
    |
    | Sera notamment utilisé pour filtrer le calendrier.
    |
    */
    public function isFemme(): bool
    {
        return $this->genre === 'femme';
    }
}