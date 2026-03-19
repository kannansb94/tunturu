<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRentalNotification extends Notification
{
    use Queueable;

    protected $rental;

    /**
     * Create a new notification instance.
     */
    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Rental Request')
            ->line('A new rental request has been placed by ' . $this->rental->user->name)
            ->line('Book: ' . $this->rental->book->title)
            ->line('Amount: ₹' . number_format($this->rental->total_amount, 2))
            ->line('Rental Date: ' . $this->rental->rental_date)
            ->action('View Rental', route('library.admin.rentals.show', ['panel_role' => $notifiable->role, 'rental' => $this->rental->id]))
            ->line('Please process this request.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New rental request from ' . $this->rental->user->name,
            'link' => route('library.admin.rentals.show', ['panel_role' => $notifiable->role, 'rental' => $this->rental->id]), // Assuming show route exists, or index
            'type' => 'rental',
        ];
    }
}
