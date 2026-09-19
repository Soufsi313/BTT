<?php

namespace App\Http\Controllers;

use App\Models\CookieConsent;
use Illuminate\Contracts\View\View;

/**
 * =============================================================
 * STATISTIQUES DES COOKIES - ADMINISTRATION BTT
 * =============================================================
 *
 * Affiche les statistiques des préférences de cookies enregistrées.
 *
 * Les données présentées correspondent aux choix actuellement
 * conservés dans la table cookie_consents.
 *
 * Ce contrôleur ne modifie aucun consentement et ne retourne
 * aucune information permettant d'identifier un visiteur.
 *
 * L'accès à cette page est exclusivement réservé au Super Admin.
 *
 * Les middlewares "auth" et "admin" sont déjà appliqués
 * à la route dans routes/web.php.
 */
class AdminCookieConsentController extends Controller
{
    /**
     * Affiche la page des statistiques des cookies.
     */
    public function index(): View
    {
        /*
         * =========================================================
         * CONTRÔLE D'ACCÈS : SUPER ADMIN UNIQUEMENT
         * =========================================================
         *
         * Masquer le lien dans le menu ne suffit pas à protéger
         * les données : un administrateur pourrait saisir l'URL.
         *
         * On vérifie donc les droits avant toute requête
         * sur les consentements.
         *
         * Un administrateur classique reçoit une réponse HTTP 403.
         */
        abort_unless(
            auth()->user()->isSuperAdmin(),
            403,
            'Cette page est réservée au Super Admin.'
        );

        /*
         * =========================================================
         * TOTAL DES CONSENTEMENTS ENREGISTRÉS
         * =========================================================
         *
         * Chaque ligne correspond au choix actuel d'un navigateur.
         */
        $totalConsents = CookieConsent::query()->count();

        /*
         * =========================================================
         * RÉPARTITION PAR TYPE DE DÉCISION
         * =========================================================
         */
        $acceptedCount = CookieConsent::query()
            ->where('decision', 'accepted')
            ->count();

        $rejectedCount = CookieConsent::query()
            ->where('decision', 'rejected')
            ->count();

        $customizedCount = CookieConsent::query()
            ->where('decision', 'customized')
            ->count();

        /*
         * =========================================================
         * AUTORISATIONS PAR CATÉGORIE
         * =========================================================
         *
         * Une personnalisation peut autoriser une catégorie
         * et refuser l'autre.
         *
         * Ces compteurs utilisent donc les préférences réelles,
         * indépendamment du type de décision.
         */
        $analyticsAllowedCount = CookieConsent::query()
            ->where('analytics_allowed', true)
            ->count();

        $externalMediaAllowedCount = CookieConsent::query()
            ->where('external_media_allowed', true)
            ->count();

        /*
         * =========================================================
         * CONSENTEMENTS ENCORE VALIDES
         * =========================================================
         *
         * On exclut les choix expirés et ceux enregistrés avec
         * une ancienne version du consentement.
         *
         * La version actuelle est 1, comme dans le contrôleur
         * public CookieConsentController.
         */
        $validConsentsCount = CookieConsent::query()
            ->where('consent_version', 1)
            ->where('expires_at', '>', now())
            ->count();

        /*
         * =========================================================
         * CALCUL DES POURCENTAGES
         * =========================================================
         *
         * Une division par zéro est évitée lorsqu'aucun choix
         * n'a encore été enregistré.
         */
        $percentage = static function (int $count) use ($totalConsents): float {
            if ($totalConsents === 0) {
                return 0.0;
            }

            return round(($count / $totalConsents) * 100, 1);
        };

        $acceptedPercentage = $percentage($acceptedCount);
        $rejectedPercentage = $percentage($rejectedCount);
        $customizedPercentage = $percentage($customizedCount);
        $analyticsAllowedPercentage = $percentage($analyticsAllowedCount);
        $externalMediaAllowedPercentage = $percentage($externalMediaAllowedCount);
        $validConsentsPercentage = $percentage($validConsentsCount);

        /*
         * =========================================================
         * TRANSMISSION DES DONNÉES À LA VUE ADMIN
         * =========================================================
         */
        return view('admin.cookies.index', compact(
            'totalConsents',
            'acceptedCount',
            'rejectedCount',
            'customizedCount',
            'analyticsAllowedCount',
            'externalMediaAllowedCount',
            'validConsentsCount',
            'acceptedPercentage',
            'rejectedPercentage',
            'customizedPercentage',
            'analyticsAllowedPercentage',
            'externalMediaAllowedPercentage',
            'validConsentsPercentage'
        ));
    }
}