<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmationNotification extends Notification
{
    use Queueable;

    protected $sale;

    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
        
        $contentTemplate = $emailSettings['email_sale_success_content'] ?? 'Thank you for your order! Your payment for the order #{order_id} has been received and your books will be dispatched shortly.';
        $content = str_replace('{order_id}', $this->sale->id, $contentTemplate);
        
        $footerText = $emailSettings['email_footer_text'] ?? 'This is an automated email. Please do not reply to this message.';
        
        $subjectTemplate = $emailSettings['email_sale_success_subject'] ?? 'Order Confirmation - ' . config('app.name');
        $subject = str_replace('{order_id}', $this->sale->id, $subjectTemplate);

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($content)
            ->line('**Order Details:**')
            ->line('Book: ' . $this->sale->book->title)
            ->line('Quantity: ' . $this->sale->quantity)
            ->line('Total Amount: ₹' . number_format($this->sale->total_amount, 2))
            ->line('Payment Method: ' . ucfirst($this->sale->payment_method))
            ->action('View My Orders', route('library.user.orders'))
            ->line('Thank you for shopping with us!');
            
        // Adding custom footer using Markdown line since MailMessage uses Markdown components for footer natively.
        $mailMessage->with(['footerText' => $footerText]);
        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Order placed successfully for ' . $this->sale->book->title,
            'link' => route('library.user.orders'),
            'type' => 'order_confirmation',
        ];
    }
}
