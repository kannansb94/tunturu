<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalConfirmationNotification extends Notification
{
    use Queueable;

    protected $rental;

    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
        
        $contentTemplate = $emailSettings['email_rental_success_content'] ?? 'Your rental request #{rental_id} has been confirmed successfully! Please ensure you return the book before the due date.';
        $content = str_replace('{rental_id}', $this->rental->id, $contentTemplate);
        
        $footerText = $emailSettings['email_footer_text'] ?? 'This is an automated email. Please do not reply to this message.';
        
        $subjectTemplate = $emailSettings['email_rental_success_subject'] ?? 'Rental Confirmation - ' . config('app.name');
        $subject = str_replace('{rental_id}', $this->rental->id, $subjectTemplate);
        
        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($content)
            ->line('**Rental Details:**')
            ->line('Book: ' . $this->rental->book->title)
            ->line('Rental Date: ' . $this->rental->rental_date)
            ->line('Return By: ' . $this->rental->expected_return_date)
            ->line('Total Amount: ₹' . number_format($this->rental->total_amount, 2))
            ->action('View My Rentals', route('library.user')) // Redirect to main user library page where rentals are listed
            ->line('Happy Reading!');
            
        // Adding custom footer using Markdown line since MailMessage uses Markdown components for footer natively.
        $mailMessage->with(['footerText' => $footerText]);
        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Rental confirmed for ' . $this->rental->book->title,
            'link' => route('library.user'),
            'type' => 'rental_confirmation',
        ];
    }
}
