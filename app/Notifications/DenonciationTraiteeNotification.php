<?php

namespace App\Notifications;

use App\Models\Denonciation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DenonciationTraiteeNotification extends Notification
{
    use Queueable;

    protected $denonciation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Denonciation $denonciation)
    {
        $this->denonciation = $denonciation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Votre dénonciation a été traitée')
                    ->action('emails.denonciation_traitee', ['denonciation' => $this->denonciation])
                    ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
