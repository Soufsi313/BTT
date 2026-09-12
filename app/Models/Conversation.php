<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS MODIFIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR LIÉ À LA CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Cette relation est utilisée lorsqu'un adhérent connecté
    | démarre une conversation.
    |
    | Pour un visiteur non connecté, user_id reste NULL.
    |
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | MESSAGES DE LA CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Une conversation peut contenir plusieurs messages.
    |
    */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    /*
    |--------------------------------------------------------------------------
    | CONVERSATION OUVERTE ?
    |--------------------------------------------------------------------------
    */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }


    /*
    |--------------------------------------------------------------------------
    | CONVERSATION FERMÉE ?
    |--------------------------------------------------------------------------
    */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }
}