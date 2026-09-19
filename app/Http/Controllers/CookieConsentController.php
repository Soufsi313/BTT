<?php

namespace App\Http\Controllers;

use App\Models\CookieConsent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Contrôleur des préférences de cookies du site Brussels Top Team.
 *
 * Il permet aux visiteurs anonymes et aux membres connectés :
 * - d'accepter tous les cookies optionnels ;
 * - de refuser tous les cookies optionnels ;
 * - de personnaliser leurs préférences ;
 * - de modifier leur choix ultérieurement.
 *
 * Les cookies strictement nécessaires ne sont pas désactivables.
 */
class CookieConsentController extends Controller
{
    /**
     * Version actuelle du consentement.
     *
     * Cette valeur devra être augmentée si les finalités des cookies
     * changent et qu'un nouveau consentement devient nécessaire.
     */
    private const CONSENT_VERSION = 1;

    /**
     * Durée de validité du choix, en mois.
     */
    private const CONSENT_DURATION_MONTHS = 6;

    /**
     * Nom du cookie technique identifiant le navigateur.
     */
    private const VISITOR_COOKIE_NAME = 'btt_cookie_visitor';

    /**
     * Enregistre ou met à jour les préférences du visiteur.
     *
     * Données attendues :
     *
     * decision : accepted, rejected ou customized
     *
     * Pour customized :
     * analytics_allowed : booléen
     * external_media_allowed : booléen
     */
    public function store(Request $request): JsonResponse
    {
        /*
         * Validation des données reçues.
         *
         * Les deux préférences sont obligatoires uniquement lorsque
         * le visiteur choisit de personnaliser son consentement.
         */
        $validated = $request->validate([
            'decision' => [
                'required',
                Rule::in([
                    'accepted',
                    'rejected',
                    'customized',
                ]),
            ],

            'analytics_allowed' => [
                'required_if:decision,customized',
                'boolean',
            ],

            'external_media_allowed' => [
                'required_if:decision,customized',
                'boolean',
            ],
        ]);

        /*
         * Détermination des préférences selon la décision.
         *
         * Les valeurs éventuellement envoyées avec accepted ou
         * rejected sont ignorées pour éviter les incohérences.
         */
        $decision = $validated['decision'];

        if ($decision === 'accepted') {
            $analyticsAllowed = true;
            $externalMediaAllowed = true;
        } elseif ($decision === 'rejected') {
            $analyticsAllowed = false;
            $externalMediaAllowed = false;
        } else {
            $analyticsAllowed = (bool) $validated['analytics_allowed'];
            $externalMediaAllowed = (bool) $validated['external_media_allowed'];
        }

        /*
         * Recherche du jeton déjà présent dans le navigateur.
         *
         * Un jeton absent ou mal formé est remplacé par un nouvel UUID.
         */
        $visitorToken = $request->cookie(self::VISITOR_COOKIE_NAME);

        if (
            ! is_string($visitorToken)
            || ! Str::isUuid($visitorToken)
        ) {
            $visitorToken = (string) Str::uuid();
        }

        /*
         * Dates de décision et d'expiration.
         */
        $decidedAt = now();

        $expiresAt = $decidedAt
            ->copy()
            ->addMonthsNoOverflow(self::CONSENT_DURATION_MONTHS);

        /*
         * Enregistrement du choix actuel du navigateur.
         *
         * updateOrCreate évite de créer un nouvel enregistrement
         * chaque fois que le visiteur modifie ses préférences.
         *
         * L'utilisateur connecté est associé au consentement.
         * Pour un visiteur anonyme, user_id reste NULL.
         */
        $consent = CookieConsent::updateOrCreate(
            [
                'visitor_token' => $visitorToken,
            ],
            [
                'user_id' => $request->user()?->id,
                'analytics_allowed' => $analyticsAllowed,
                'external_media_allowed' => $externalMediaAllowed,
                'decision' => $decision,
                'consent_version' => self::CONSENT_VERSION,
                'decided_at' => $decidedAt,
                'expires_at' => $expiresAt,
            ]
        );

        /*
         * Le cookie technique ne contient aucune préférence.
         *
         * Il contient uniquement l'identifiant aléatoire permettant
         * de retrouver le choix enregistré en base de données.
         *
         * HttpOnly empêche sa lecture par JavaScript.
         * Secure dépend de la configuration de la session Laravel.
         */
        $cookie = cookie(
            self::VISITOR_COOKIE_NAME,
            $visitorToken,
            self::CONSENT_DURATION_MONTHS * 30 * 24 * 60,
            '/',
            null,
            (bool) config('session.secure'),
            true,
            false,
            'lax'
        );

        /*
         * Réponse JSON destinée au futur bandeau de consentement.
         *
         * Le navigateur pourra fermer le bandeau après succès
         * et adapter les fonctionnalités optionnelles autorisées.
         */
        return response()
            ->json([
                'success' => true,
                'message' => 'Vos préférences de cookies ont été enregistrées.',
                'consent' => [
                    'necessary_allowed' => true,
                    'analytics_allowed' => $consent->analytics_allowed,
                    'external_media_allowed' => $consent->external_media_allowed,
                    'decision' => $consent->decision,
                    'consent_version' => $consent->consent_version,
                    'expires_at' => $consent->expires_at->toIso8601String(),
                ],
            ])
            ->withCookie($cookie);
    }

    /**
     * Retourne les préférences actuelles du navigateur.
     *
     * Si aucun choix valide n'existe, les cookies optionnels
     * sont considérés comme refusés par défaut.
     *
     * Le bandeau devra alors demander un choix au visiteur.
     */
    public function show(Request $request): JsonResponse
    {
        /*
         * Lecture du jeton technique.
         */
        $visitorToken = $request->cookie(self::VISITOR_COOKIE_NAME);

        /*
         * Aucun jeton valide : aucun consentement retrouvé.
         */
        if (
            ! is_string($visitorToken)
            || ! Str::isUuid($visitorToken)
        ) {
            return $this->noConsentResponse();
        }

        /*
         * Recherche du consentement enregistré.
         */
        $consent = CookieConsent::query()
            ->where('visitor_token', $visitorToken)
            ->first();

        /*
         * Le consentement est absent, expiré ou lié à une
         * ancienne version des préférences.
         */
        if (
            $consent === null
            || ! $consent->isValidForVersion(self::CONSENT_VERSION)
        ) {
            return $this->noConsentResponse();
        }

        /*
         * Retour des préférences encore valides.
         */
        return response()->json([
            'has_consent' => true,
            'consent' => [
                'necessary_allowed' => true,
                'analytics_allowed' => $consent->analytics_allowed,
                'external_media_allowed' => $consent->external_media_allowed,
                'decision' => $consent->decision,
                'consent_version' => $consent->consent_version,
                'expires_at' => $consent->expires_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * Réponse utilisée lorsqu'aucun consentement valide n'existe.
     *
     * Les catégories optionnelles sont désactivées par défaut.
     */
    private function noConsentResponse(): JsonResponse
    {
        return response()->json([
            'has_consent' => false,
            'consent' => [
                'necessary_allowed' => true,
                'analytics_allowed' => false,
                'external_media_allowed' => false,
                'decision' => null,
                'consent_version' => self::CONSENT_VERSION,
                'expires_at' => null,
            ],
        ]);
    }
}