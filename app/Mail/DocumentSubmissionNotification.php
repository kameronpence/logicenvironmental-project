<?php

namespace App\Mail;

use App\Models\DocumentSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentSubmissionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public DocumentSubmission $submission;

    public function __construct(DocumentSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function envelope(): Envelope
    {
        $subject = 'New Document Submission from ' . $this->submission->name;
        if ($this->submission->reference) {
            $subject .= ' (Ref: ' . $this->submission->reference . ')';
        }

        return new Envelope(
            subject: $subject,
            replyTo: [$this->submission->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-submission',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
