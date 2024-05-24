<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBooking extends Notification
{
    use Queueable;

   protected Booking $booking;
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail' ,'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('you have a new booking with booking number ' . $this->booking->booking_number)
                    ->line('Thank you for using our application!');
    }


    public function toArray($notifiable)
    {
        return [
            'company_id' => $this->booking->company_id,
        ];
    }
}
