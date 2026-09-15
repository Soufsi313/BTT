<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * ================================================================
 * MODÈLE COMMENT
 * ================================================================
 *
 * Ce modèle représente un commentaire publié par un adhérent
 * sur un article du blog Brussels Top Team.
 *
 * Un commentaire :
 *
 * - appartient à un article ;
 * - appartient à un utilisateur ;
 * - peut recevoir plusieurs signalements ;
 * - peut être publié ou masqué ;
 * - utilise le Soft Delete afin de pouvoir être restauré
 *   depuis l'administration.
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
     *
     * Ces champs peuvent être renseignés avec Comment::create().
     *
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
     * ARTICLE ASSOCIÉ AU COMMENTAIRE
     * ============================================================
     *
     * Chaque commentaire appartient à un seul article.
     *
     * Exemple :
     *
     * $comment->article
     *
     * ============================================================
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(
            Article::class
        );
    }


    /**
     * ============================================================
     * UTILISATEUR AYANT PUBLIÉ LE COMMENTAIRE
     * ============================================================
     *
     * Cette relation permet notamment d'afficher le pseudo
     * du membre ayant publié le commentaire.
     *
     * Exemple :
     *
     * $comment->user
     *
     * ============================================================
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }


    /**
     * ============================================================
     * SIGNALEMENTS DU COMMENTAIRE
     * ============================================================
     *
     * Un commentaire peut recevoir plusieurs signalements provenant
     * de différents membres.
     *
     * La contrainte UNIQUE présente dans la base de données empêche
     * cependant un même utilisateur de signaler plusieurs fois
     * le même commentaire.
     *
     * Exemple :
     *
     * $comment->reports
     *
     * ============================================================
     */
    public function reports(): HasMany
    {
        return $this->hasMany(
            CommentReport::class
        );
    }


    /**
     * ============================================================
     * COMMENTAIRE PUBLIÉ
     * ============================================================
     *
     * Retourne true lorsque le commentaire est visible publiquement.
     *
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
     * Retourne true lorsque le commentaire a été masqué
     * par l'administration.
     *
     * ============================================================
     */
    public function isHidden(): bool
    {
        return $this->status === 'hidden';
    }
}