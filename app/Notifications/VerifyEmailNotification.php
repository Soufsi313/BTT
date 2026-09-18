<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;


/**
 * ================================================================
 * NOTIFICATION DE VÉRIFICATION EMAIL BTT
 * ================================================================
 *
 * Cette notification remplace l'email de vérification générique
 * fourni par Laravel.
 *
 * Elle permet :
 *
 * - de générer le lien sécurisé de vérification ;
 * - de transmettre ce lien à notre template BTT personnalisé ;
 * - d'afficher les informations du nouvel adhérent ;
 * - de conserver le système natif de signature de Laravel.
 *
 * Le template utilisé est :
 *
 * resources/views/emails/auth/verify-email.blade.php
 *
 * ================================================================
 */
class VerifyEmailNotification extends VerifyEmail
{
    /**
     * ============================================================
     * CONSTRUIRE L'EMAIL
     * ============================================================
     *
     * Laravel appelle automatiquement cette méthode lorsque :
     *
     * $user->sendEmailVerificationNotification()
     *
     * est exécuté.
     *
     * ============================================================
     */
    public function toMail($notifiable): MailMessage
    {
        /*
        |--------------------------------------------------------------------------
        | GÉNÉRATION DU LIEN DE VÉRIFICATION
        |--------------------------------------------------------------------------
        |
        | Nous générons ici le lien temporaire et signé qui permettra
        | à Laravel de vérifier l'adresse email de l'utilisateur.
        |
        */

        $verificationUrl = $this->verificationUrl(
            $notifiable
        );


        /*
        |--------------------------------------------------------------------------
        | EMAIL PERSONNALISÉ BRUSSELS TOP TEAM
        |--------------------------------------------------------------------------
        |
        | Au lieu d'utiliser le template générique de Laravel,
        | nous utilisons notre propre vue Blade BTT.
        |
        | Nous transmettons :
        |
        | - $user
        | - $verificationUrl
        |
        | au template.
        |
        */

        return (new MailMessage)
            ->subject(
                'Vérifiez votre adresse email - Brussels Top Team'
            )
            ->view(
                'emails.auth.verify-email',
                [
                    'user' => $notifiable,

                    'verificationUrl' => $verificationUrl,
                ]
            );
    }


    /**
     * ============================================================
     * GÉNÉRER L'URL DE VÉRIFICATION
     * ============================================================
     *
     * Cette méthode reprend le mécanisme sécurisé utilisé par
     * Laravel pour ses emails de vérification.
     *
     * Le lien généré contient :
     *
     * - l'identifiant de l'utilisateur ;
     * - le hash de son adresse email ;
     * - une date d'expiration ;
     * - une signature cryptographique.
     *
     * Exemple :
     *
     * /email/verification/25/xxxxxxxx
     *     ?expires=...
     *     &signature=...
     *
     * ============================================================
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(

            /*
            |--------------------------------------------------------------------------
            | NOM DE LA ROUTE
            |--------------------------------------------------------------------------
            |
            | Cette route existe maintenant dans routes/web.php.
            |
            */

            'verification.verify',


            /*
            |--------------------------------------------------------------------------
            | DURÉE DE VALIDITÉ DU LIEN
            |--------------------------------------------------------------------------
            |
            | Laravel utilise la configuration :
            |
            | auth.verification.expire
            |
            | Si aucune durée spécifique n'est définie dans le projet,
            | nous utilisons 60 minutes.
            |
            */

            Carbon::now()->addMinutes(
                Config::get(
                    'auth.verification.expire',
                    60
                )
            ),


            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS SIGNÉES
            |--------------------------------------------------------------------------
            |
            | L'identifiant et l'adresse email sont liés à la signature.
            |
            | Une modification manuelle de ces informations rendrait
            | donc le lien invalide.
            |
            */

            [
                'id' => $notifiable->getKey(),

                'hash' => sha1(
                    $notifiable->getEmailForVerification()
                ),
            ]
        );
    }
}