<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationReçuNotification extends Notification
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
        $searchUrl = url('/recherche/etudiant?query=' . urlencode($this->sender->name));
        return (new MailMessage)
                    ->subject('Nouvelle invitation reçue ')
                    ->line('Vous avez reçu une invitation de ' . $this->sender->name . '.')
                    ->action('Voir les demandes d\'invitation pour être votre binôme', $searchUrl)
                    ->line('ESM Bénin le chemin vers l\'emploie !');
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
            'message' => 'Vous avez reçu une invitation de ' . $this->sender->name . '.',
        ];
    }
}
