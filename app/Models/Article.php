<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * ================================================================
 * MODÈLE ARTICLE
 * ================================================================
 *
 * Représente un article publié sur le blog Brussels Top Team.
 *
 * Un article pourra contenir :
 *
 * - un titre ;
 * - une URL propre grâce au slug ;
 * - une catégorie ;
 * - un résumé ;
 * - un contenu complet ;
 * - une bannière principale ;
 * - un auteur ;
 * - un statut brouillon / publié ;
 * - une date de publication ;
 * - une mise en avant éventuelle.
 *
 * Les likes, commentaires et images intégrées au contenu seront
 * gérés plus tard avec leurs propres tables.
 *
 * ================================================================
 */
class Article extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
     * ---------------------------------------------------------------
     * CHAMPS MODIFIABLES
     * ---------------------------------------------------------------
     *
     * Ces champs pourront être remplis avec Article::create()
     * ou avec la méthode update().
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
     * ---------------------------------------------------------------
     * CONVERSIONS AUTOMATIQUES
     * ---------------------------------------------------------------
     *
     * Laravel transformera automatiquement :
     *
     * - is_featured en vrai booléen ;
     * - published_at en objet de date Carbon.
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }


    /**
     * ---------------------------------------------------------------
     * AUTEUR DE L'ARTICLE
     * ---------------------------------------------------------------
     *
     * Un article appartient à un utilisateur.
     *
     * En pratique, cet utilisateur sera normalement un administrateur
     * ou le Super Admin ayant créé l'article.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'author_id'
        );
    }


    /**
     * ---------------------------------------------------------------
     * ARTICLE PUBLIÉ ?
     * ---------------------------------------------------------------
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }


    /**
     * ---------------------------------------------------------------
     * ARTICLE EN BROUILLON ?
     * ---------------------------------------------------------------
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }


    /**
     * ---------------------------------------------------------------
     * ARTICLE MIS EN AVANT ?
     * ---------------------------------------------------------------
     *
     * Ce champ nous servira plus tard pour afficher certains articles
     * en priorité sur la page Blog.
     */
    public function isFeatured(): bool
    {
        return $this->is_featured;
    }
}