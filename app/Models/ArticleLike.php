<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * ================================================================
 * MODÈLE ARTICLE LIKE
 * ================================================================
 *
 * Ce modèle représente un like déposé par un utilisateur
 * sur un article du blog Brussels Top Team.
 *
 * Chaque like appartient :
 *
 * - à un article ;
 * - à un utilisateur.
 *
 * La table correspondante est :
 *
 * article_likes
 *
 * Un même utilisateur ne peut liker un même article
 * qu'une seule fois grâce à la contrainte UNIQUE
 * présente dans la migration.
 *
 * ================================================================
 */
class ArticleLike extends Model
{
    use HasFactory;


    /**
     * ============================================================
     * NOM DE LA TABLE
     * ============================================================
     *
     * Laravel pourrait deviner automatiquement "article_likes",
     * mais nous le précisons ici pour rendre le modèle plus clair.
     *
     * ============================================================
     */
    protected $table = 'article_likes';


    /**
     * ============================================================
     * CHAMPS MODIFIABLES
     * ============================================================
     *
     * Ces deux colonnes peuvent être utilisées avec create().
     *
     * Exemple :
     *
     * ArticleLike::create([
     *     'article_id' => 1,
     *     'user_id' => 5,
     * ]);
     *
     * ============================================================
     */
    protected $fillable = [
        'article_id',
        'user_id',
    ];


    /**
     * ============================================================
     * ARTICLE ASSOCIÉ
     * ============================================================
     *
     * Chaque like appartient à un seul article.
     *
     * Exemple :
     *
     * $like->article
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
     * UTILISATEUR ASSOCIÉ
     * ============================================================
     *
     * Chaque like appartient à un seul utilisateur.
     *
     * Exemple :
     *
     * $like->user
     *
     * ============================================================
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }
}