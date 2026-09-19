<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MODÈLE COOKIE CONSENT
 *
 * Représente les préférences actuelles d'un navigateur concernant
 * les cookies optionnels du site Brussels Top Team.
 *
 * Un consentement peut appartenir :
 * - à un visiteur anonyme ;
 * - à un utilisateur connecté.
 *
 * Les cookies strictement nécessaires ne sont pas désactivables.
 */
class CookieConsent extends Model
{
    /**
     * TABLE ASSOCIÉE
     *
     * Nom de la table utilisée pour enregistrer les consentements.
     */
    protected $table = 'cookie_consents';

    /**
     * CHAMPS AUTORISÉS À L'ENREGISTREMENT
     *
     * Liste des attributs pouvant être renseignés lors de la
     * création ou de la mise à jour d'un consentement.
     */
    protected $fillable = [
        'visitor_token',
        'user_id',
        'analytics_allowed',
        'external_media_allowed',
        'decision',
        'consent_version',
        'decided_at',
        'expires_at',
    ];

    /**
     * CONVERSIONS AUTOMATIQUES
     *
     * Les préférences sont converties en booléens.
     * La version du consentement est convertie en entier.
     * Les dates sont converties en objets Carbon par Laravel.
     */
    protected function casts(): array
    {
        return [
            'analytics_allowed' => 'boolean',
            'external_media_allowed' => 'boolean',
            'consent_version' => 'integer',
            'decided_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    /**
     * RELATION AVEC L'UTILISATEUR
     *
     * Un consentement peut être associé à un utilisateur BTT.
     *
     * Cette relation peut être NULL pour les visiteurs anonymes
     * ou lorsque l'association au compte a été supprimée.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * VÉRIFIER SI LE CONSENTEMENT EST EXPIRÉ
     *
     * Un consentement sans date d'expiration est considéré
     * comme invalide.
     */
    public function isExpired(): bool
    {
        if ($this->expires_at === null) {
            return true;
        }

        return $this->expires_at->isPast();
    }

    /**
     * VÉRIFIER SI LE CONSENTEMENT EST ENCORE VALIDE
     *
     * Le choix doit :
     * - ne pas être expiré ;
     * - correspondre à la version actuelle des préférences.
     *
     * La version actuelle sera centralisée dans le futur
     * gestionnaire de consentement.
     */
    public function isValidForVersion(int $version): bool
    {
        return ! $this->isExpired()
            && $this->consent_version === $version;
    }
}