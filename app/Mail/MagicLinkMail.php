<?php

namespace App\Mail;

use App\Models\MagicLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public MagicLink $magicLink;

    /**
     * Create a new message instance.
     */
    public function __construct(MagicLink $magicLink)
    {
        $this->magicLink = $magicLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Secure Access Link - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.magic-link',
            with: [
                'magicLink' => $this->magicLink,
                'portal' => $this->magicLink->portal,
                'url' => $this->magicLink->getUrl(),
                'expiresAt' => $this->magicLink->expires_at,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
