<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS MODIFIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'conversation_id',
        'user_id',
        'sender_type',
        'body',
        'is_read',
    ];


    /*
    |--------------------------------------------------------------------------
    | CONVERSIONS AUTOMATIQUES
    |--------------------------------------------------------------------------
    */
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | CONVERSATION
    |--------------------------------------------------------------------------
    |
    | Chaque message appartient à une seule conversation.
    |
    */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }


    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR AYANT ENVOYÉ LE MESSAGE
    |--------------------------------------------------------------------------
    |
    | Pour un visiteur non connecté, user_id reste NULL.
    |
    | Pour un adhérent ou un administrateur connecté,
    | cette relation permettra de retrouver son compte.
    |
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | MESSAGE ENVOYÉ PAR UN VISITEUR ?
    |--------------------------------------------------------------------------
    */
    public function isFromVisitor(): bool
    {
        return $this->sender_type === 'visitor';
    }


    /*
    |--------------------------------------------------------------------------
    | MESSAGE ENVOYÉ PAR UN ADHÉRENT ?
    |--------------------------------------------------------------------------
    */
    public function isFromMember(): bool
    {
        return $this->sender_type === 'member';
    }


    /*
    |--------------------------------------------------------------------------
    | MESSAGE ENVOYÉ PAR UN ADMINISTRATEUR ?
    |--------------------------------------------------------------------------
    */
    public function isFromAdmin(): bool
    {
        return $this->sender_type === 'admin';
    }
}