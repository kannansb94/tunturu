<?php

namespace App\Mail;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SaleStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;
    public $statusType;
    public $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Sale $sale, string $statusType, string $newStatus)
    {
        $this->sale = $sale;
        $this->statusType = $statusType;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
        
        // Example: email_sale_payment_completed_subject
        $subjectKey = "email_sale_{$this->statusType}_{$this->newStatus}_subject";
        
        $subjectTemplate = $emailSettings[$subjectKey] ?? 'Order Status Updated';
        
        $subject = str_replace(
            ['{order_id}', '{status_type}', '{status}'], 
            [$this->sale->id, $this->statusType, lcfirst(str_replace('_', ' ', $this->newStatus))], 
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
            view: 'emails.sale_status_updated',
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
