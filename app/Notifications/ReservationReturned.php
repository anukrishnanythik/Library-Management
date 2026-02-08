<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationReturned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->onQueue('notifications');
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Book Returned Successfully')
            ->line('Your book has been returned.')
            ->line('Book ID: ' . $this->reservation->book_id)
            ->line('Fine Amount: ₹' . $this->reservation->fine_amount)
            ->line('Returned on: ' . $this->reservation->returned_at->format('d M Y'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'book_title' => $this->reservation->book->title,
            'returned_at' => $this->reservation->returned_at,
            'fine_amount' => $this->reservation->fine_amount,
            'message' => "Your book '{$this->reservation->book->title}' has been returned. Fine: ₹{$this->reservation->fine_amount}",
        ];
    }
}
