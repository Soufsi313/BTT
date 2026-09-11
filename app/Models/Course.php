<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS MODIFIABLES
    |--------------------------------------------------------------------------
    |
    | Ces champs pourront plus tard être remplis depuis le formulaire
    | de création/modification des entraînements dans l'administration.
    |
    */
    protected $fillable = [
        'title',
        'discipline',
        'course_date',
        'start_time',
        'end_time',
        'target_gender',
        'description',
        'created_by',
        'is_active',
    ];


    /*
    |--------------------------------------------------------------------------
    | CONVERSION AUTOMATIQUE DES DONNÉES
    |--------------------------------------------------------------------------
    */
    protected function casts(): array
    {
        return [
            'course_date' => 'date',
            'is_active' => 'boolean',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | ADMINISTRATEUR AYANT CRÉÉ LE COURS
    |--------------------------------------------------------------------------
    |
    | Cette relation nous permettra plus tard de savoir quel administrateur
    | a publié un entraînement.
    |
    */
    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}