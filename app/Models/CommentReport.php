<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * ================================================================
 * MODÈLE COMMENT REPORT
 * ================================================================
 *
 * Ce modèle représente un signalement effectué par un membre
 * concernant un commentaire publié sur le blog BTT.
 *
 * Un signalement contient notamment :
 *
 * - le commentaire concerné ;
 * - le membre ayant effectué le signalement ;
 * - le motif du signalement ;
 * - des précisions facultatives ;
 * - le statut du traitement ;
 * - la date éventuelle de traitement.
 *
 * ================================================================
 */
class CommentReport extends Model
{
    use HasFactory;


    /**
     * ============================================================
     * CHAMPS AUTORISÉS À L'ASSIGNATION
     * ============================================================
     *
     * Ces champs peuvent être renseignés avec CommentReport::create().
     *
     * ============================================================
     */
    protected $fillable = [
        'comment_id',
        'user_id',
        'reason',
        'details',
        'status',
        'reviewed_at',
    ];


    /**
     * ============================================================
     * CONVERSION AUTOMATIQUE DES TYPES
     * ============================================================
     *
     * Laravel convertira automatiquement reviewed_at
     * en objet de date Carbon lorsqu'une valeur existe.
     *
     * ============================================================
     */
    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }


    /**
     * ============================================================
     * COMMENTAIRE SIGNALÉ
     * ============================================================
     *
     * Chaque signalement appartient à un commentaire.
     *
     * Exemple :
     *
     * $report->comment
     *
     * ============================================================
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }


    /**
     * ============================================================
     * MEMBRE AYANT EFFECTUÉ LE SIGNALEMENT
     * ============================================================
     *
     * Chaque signalement appartient normalement à un utilisateur.
     *
     * user_id peut néanmoins devenir NULL si le compte est
     * définitivement supprimé de la base de données.
     *
     * Le signalement reste ainsi conservé pour l'historique
     * de modération.
     *
     * ============================================================
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * ============================================================
     * SIGNALEMENT EN ATTENTE
     * ============================================================
     *
     * Permet de savoir rapidement si le signalement doit encore
     * être examiné par l'administration.
     *
     * ============================================================
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }


    /**
     * ============================================================
     * SIGNALEMENT TRAITÉ
     * ============================================================
     *
     * Un signalement "resolved" signifie que l'administration
     * a considéré le problème comme traité.
     *
     * ============================================================
     */
    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }


    /**
     * ============================================================
     * SIGNALEMENT REJETÉ
     * ============================================================
     *
     * Un signalement "rejected" signifie que l'administration
     * a examiné le signalement mais ne l'a pas retenu.
     *
     * ============================================================
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}