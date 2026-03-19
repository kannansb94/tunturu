<?php

namespace App\Mail;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;
    public $statusType;
    public $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Rental $rental, string $statusType, string $newStatus)
    {
        $this->rental = $rental;
        $this->statusType = $statusType;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
        
        // Example: email_rental_payment_paid_subject
        $subjectKey = "email_rental_{$this->statusType}_{$this->newStatus}_subject";
        
        $subjectTemplate = $emailSettings[$subjectKey] ?? 'Rental Status Updated';

        $subject = str_replace(
            ['{rental_id}', '{status_type}', '{status}'], 
            [$this->rental->id, $this->statusType, lcfirst(str_replace('_', ' ', $this->newStatus))], 
            $subjectTemplate
        );

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rental_status_updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
