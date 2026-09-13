<?php

namespace App\Mail;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


/**
 * ================================================================
 * EMAIL DE NOTIFICATION D'UNE RÉPONSE ADMINISTRATEUR
 * ================================================================
 *
 * Cet email est envoyé lorsqu'un membre de l'administration
 * Brussels Top Team répond à une conversation.
 *
 * Il contient :
 *
 * - le sujet de la conversation ;
 * - le contenu de la réponse ;
 * - un lien vers la conversation lorsque le destinataire
 *   possède un compte adhérent BTT.
 *
 * ================================================================
 */
class ConversationReplyMail extends Mailable
{
    use Queueable;
    use SerializesModels;


    /**
     * Conversation concernée par la réponse.
     */
    public Conversation $conversation;


    /**
     * Message envoyé par l'administration.
     */
    public Message $adminMessage;


    /**
     * ---------------------------------------------------------------
     * CONSTRUCTEUR
     * ---------------------------------------------------------------
     *
     * Laravel recevra ici la conversation et le nouveau message
     * envoyé par l'administration.
     */
    public function __construct(
        Conversation $conversation,
        Message $adminMessage
    ) {
        $this->conversation = $conversation;

        $this->adminMessage = $adminMessage;
    }


    /**
     * ---------------------------------------------------------------
     * OBJET DE L'EMAIL
     * ---------------------------------------------------------------
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle réponse de Brussels Top Team'
        );
    }


    /**
     * ---------------------------------------------------------------
     * CONTENU DE L'EMAIL
     * ---------------------------------------------------------------
     *
     * Le fichier Blade utilisé sera :
     *
     * resources/views/emails/conversation-reply.blade.php
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.conversation-reply'
        );
    }


    /**
     * ---------------------------------------------------------------
     * PIÈCES JOINTES
     * ---------------------------------------------------------------
     *
     * Aucun fichier n'est joint pour le moment.
     */
    public function attachments(): array
    {
        return [];
    }
}