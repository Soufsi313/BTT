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
     * CHAMPS AUTORISÉS À L'ATTRIBUTION DE MASSE
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
     *
     * Laravel convertit automatiquement :
     *
     * - is_featured en booléen ;
     * - published_at en objet date/heure.
     *
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
     * RELATION : AUTEUR
     * ============================================================
     *
     * Chaque article appartient à un utilisateur.
     *
     * Exemple :
     *
     * $article->author
     *
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
     * RELATION : COMMENTAIRES
     * ============================================================
     *
     * Un article peut posséder plusieurs commentaires.
     *
     * Exemple :
     *
     * $article->comments
     *
     * Cette relation retourne tous les commentaires non supprimés,
     * quel que soit leur statut.
     *
     * Le filtrage "published" sera volontairement effectué dans
     * les contrôleurs selon le contexte :
     *
     * - côté public :
     *   uniquement les commentaires publiés ;
     *
     * - côté administration :
     *   commentaires publiés + masqués.
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