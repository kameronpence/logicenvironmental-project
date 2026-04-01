<?php

namespace App\Mail;

use App\Models\ClientFile;
use App\Models\ClientPortal;
use App\Models\TeamMember;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientFileUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public ClientPortal $portal;
    public ?TeamMember $teamMember;
    public array $files;
    public ?string $description;
    public ?string $recipientName;

    /**
     * Create a new message instance.
     */
    public function __construct(ClientPortal $portal, ?TeamMember $teamMember, array $files, ?string $description = null, ?string $recipientName = null)
    {
        $this->portal = $portal;
        $this->teamMember = $teamMember;
        $this->files = $files;
        $this->description = $description;
        $this->recipientName = $recipientName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New File Upload from ' . $this->portal->client_name . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.client-file-uploaded',
            with: [
                'portal' => $this->portal,
                'teamMember' => $this->teamMember,
                'recipientName' => $this->recipientName ?? ($this->teamMember ? $this->teamMember->name : 'Team'),
                'files' => $this->files,
                'description' => $this->description,
                'adminUrl' => route('admin.client-portals.show', $this->portal),
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
