<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TRAITS UTILISÉS
    |--------------------------------------------------------------------------
    |
    | HasFactory :
    | permet notamment l'utilisation des factories Laravel.
    |
    | SoftDeletes :
    | permet de supprimer un cours sans supprimer physiquement
    | sa ligne dans la base de données.
    |
    */

    use HasFactory, SoftDeletes;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS MODIFIABLES
    |--------------------------------------------------------------------------
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
    | CONVERSIONS AUTOMATIQUES
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'course_date' => 'date',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | ADMINISTRATEUR AYANT CRÉÉ LE COURS
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LE COURS EST-IL TERMINÉ ?
    |--------------------------------------------------------------------------
    |
    | Un cours est considéré comme terminé lorsque son heure de fin
    | est dépassée.
    |
    | Exemple :
    |
    | cours du 13/09
    | début : 19:30
    | fin   : 21:00
    |
    | Jusqu'à 21:00 :
    | le cours peut être Actif ou Inactif.
    |
    | Après 21:00 :
    | le cours devient automatiquement Terminé.
    |
    | Nous utilisons explicitement le fuseau horaire de Bruxelles.
    |
    */

    public function hasEnded(): bool
    {
        /*
        | Construction de la date et de l'heure de fin.
        */
        $endDateTime = Carbon::parse(
            $this->course_date->format('Y-m-d')
            . ' '
            . $this->end_time,
            'Europe/Brussels'
        );


        /*
        | Comparaison avec l'heure actuelle à Bruxelles.
        */
        return $endDateTime->lessThanOrEqualTo(
            Carbon::now('Europe/Brussels')
        );
    }
}