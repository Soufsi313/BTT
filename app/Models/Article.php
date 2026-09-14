<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * ================================================================
 * MODÈLE ARTICLE
 * ================================================================
 *
 * Représente un article du blog Brussels Top Team.
 *
 * Un article :
 *
 * - appartient à un auteur ;
 * - possède un titre et un slug ;
 * - appartient à une catégorie ;
 * - peut être un brouillon ou être publié ;
 * - peut être mis en avant ;
 * - peut posséder une bannière ;
 * - peut contenir du contenu HTML généré par Quill ;
 * - peut recevoir plusieurs commentaires ;
 * - peut recevoir plusieurs likes ;
 * - utilise la suppression logique.
 *
 * ================================================================
 */
class Article extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
     * ============================================================
     * CHAMPS AUTORISÉS À L'ENREGISTREMENT
     * ============================================================
     */
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'banner_image',
        'status',
        'is_featured',
        'published_at',
    ];


    /**
     * ============================================================
     * CONVERSIONS AUTOMATIQUES
     * ============================================================
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }


    /**
     * ============================================================
     * AUTEUR DE L'ARTICLE
     * ============================================================
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'author_id'
        );
    }


    /**
     * ============================================================
     * COMMENTAIRES DE L'ARTICLE
     * ============================================================
     *
     * Un article peut recevoir plusieurs commentaires.
     *
     * ============================================================
     */
    public function comments(): HasMany
    {
        return $this->hasMany(
            Comment::class
        );
    }


    /**
     * ============================================================
     * LIKES DE L'ARTICLE
     * ============================================================
     *
     * Un article peut recevoir plusieurs likes.
     *
     * Chaque like correspond à une ligne dans la table :
     *
     * article_likes
     *
     * Exemples :
     *
     * $article->likes
     *
     * récupère les likes.
     *
     * $article->likes()->count()
     *
     * permet de compter les likes.
     *
     * Cette relation est également utilisée par :
     *
     * withCount('likes')
     *
     * dans BlogController.
     *
     * ============================================================
     */
    public function likes(): HasMany
    {
        return $this->hasMany(
            ArticleLike::class
        );
    }


    /**
     * ============================================================
     * ARTICLE PUBLIÉ ?
     * ============================================================
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }


    /**
     * ============================================================
     * ARTICLE EN BROUILLON ?
     * ============================================================
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }


    /**
     * ============================================================
     * ARTICLE MIS EN AVANT ?
     * ============================================================
     */
    public function isFeatured(): bool
    {
        return $this->is_featured;
    }
}