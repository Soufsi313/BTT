<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


/**
 * ================================================================
 * NOTIFICATION DE CONFIRMATION D'INSCRIPTION BTT
 * ================================================================
 *
 * Cette notification est envoyée après la vérification réussie
 * de l'adresse email d'un nouvel adhérent.
 *
 * Elle confirme que :
 *
 * - l'adresse email a bien été vérifiée ;
 * - l'inscription BTT est finalisée ;
 * - le membre peut désormais accéder à son espace.
 *
 * ================================================================
 */
class RegistrationConfirmedNotification extends Notification
{
    /**
     * ============================================================
     * CANAUX DE NOTIFICATION
     * ============================================================
     *
     * Pour le moment, cette notification est uniquement envoyée
     * par email.
     *
     * ============================================================
     */
    public function via(object $notifiable): array
    {
        return [
            'mail',
        ];
    }


    /**
     * ============================================================
     * CONSTRUIRE L'EMAIL
     * ============================================================
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(
                'Bienvenue chez Brussels Top Team - Inscription confirmée'
            )
            ->view(
                'emails.auth.registration-confirmed',
                [
                    'user' => $notifiable,
                ]
            );
    }
}