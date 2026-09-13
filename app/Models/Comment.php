<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * ================================================================
 * MODÈLE COMMENTAIRE
 * ================================================================
 *
 * Ce modèle représente un commentaire publié sous un article
 * du blog Brussels Top Team.
 *
 * Un commentaire appartient :
 *
 * - à un article ;
 * - à un adhérent.
 *
 * Les commentaires utilisent SoftDeletes afin qu'une modération
 * ne supprime pas définitivement les données immédiatement.
 *
 * ================================================================
 */
class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
     * ============================================================
     * CHAMPS AUTORISÉS
     * ============================================================
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'body',
        'status',
    ];


    /**
     * ============================================================
     * ARTICLE ASSOCIÉ
     * ============================================================
     *
     * Chaque commentaire appartient à un seul article.
     *
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(
            Article::class
        );
    }


    /**
     * ============================================================
     * AUTEUR DU COMMENTAIRE
     * ============================================================
     *
     * Chaque commentaire est publié par un utilisateur connecté.
     *
     * user_id peut devenir NULL dans le futur si le compte est
     * supprimé définitivement de la base.
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }


    /**
     * ============================================================
     * COMMENTAIRE PUBLIÉ
     * ============================================================
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }


    /**
     * ============================================================
     * COMMENTAIRE MASQUÉ
     * ============================================================
     *
     * Un administrateur pourra plus tard masquer un commentaire
     * sans nécessairement le supprimer.
     *
     */
    public function isHidden(): bool
    {
        return $this->status === 'hidden';
    }
}