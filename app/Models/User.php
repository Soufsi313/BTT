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
    | Ces informations peuvent être enregistrées depuis
    | les formulaires prévus par l'application.
    |
    | Le rôle n'est volontairement pas présent.
    | Un utilisateur ne peut donc jamais choisir lui-même
    | de devenir administrateur.
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

            /*
            |--------------------------------------------------------------------------
            | HASHAGE AUTOMATIQUE DU MOT DE PASSE
            |--------------------------------------------------------------------------
            */
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER SI L'UTILISATEUR EST ADMIN
    |--------------------------------------------------------------------------
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
    */
    public function isHomme(): bool
    {
        return $this->genre === 'homme';
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFIER SI L'UTILISATEUR EST UNE FEMME
    |--------------------------------------------------------------------------
    */
    public function isFemme(): bool
    {
        return $this->genre === 'femme';
    }
}