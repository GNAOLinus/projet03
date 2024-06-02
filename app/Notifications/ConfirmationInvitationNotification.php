<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmationInvitationNotification extends Notification
{
    use Queueable;

    protected $sender;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\User  $sender
     */
    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Invitation confirmée')
        ->line('Votre invitation a été confirmée par ' . $this->sender->name . '.')
        ->action('Vous pouviez déposer votre mémoire', url('/memoire'))
        ->line('Félicitations pour la formation de votre binôme!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message' => 'Votre invitation a été confirmée par ' . $this->sender->name . '.',
        ];
    }
}
