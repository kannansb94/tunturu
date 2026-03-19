<?php

namespace App\Mail;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalReturnedThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;

    /**
     * Create a new message instance.
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
        $subjectTemplate = $emailSettings['email_rental_returned_subject'] ?? 'Thank You for Returning - ' . config('app.name');
        $subject = str_replace('{rental_id}', $this->rental->id, $subjectTemplate);

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
            view: 'emails.rental_returned_thank_you',
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
