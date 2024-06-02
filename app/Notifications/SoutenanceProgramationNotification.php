<?php

namespace App\Notifications;

use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SoutenanceProgramationNotification extends Notification
{
    use Queueable;

    protected $soutenanceDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct($soutenanceDetails)
    {
        $this->soutenanceDetails = $soutenanceDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database',WhatsAppChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Programmation de Soutenance')
        ->line('La soutenance pour le mémoire a été programmée.')
        ->line('Date : ' . $this->soutenanceDetails['date_soutenance'])
        ->line('Heure : ' . $this->soutenanceDetails['heurs_soutenance'])
        ->line('Lieu : ' . $this->soutenanceDetails['id_site->site'])
        ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsApp(object $notifiable): array
    {
        return [
            'body' => 'La soutenance pour le mémoire a été programmée. ' .
                      'Date : ' . $this->soutenanceDetails['date_soutenance'] . ' ' .
                      'Heure : ' . $this->soutenanceDetails['heurs_soutenance'] . ' ' .
                      'Lieu : ' . $this->soutenanceDetails['id_site'] . ' ' .
                      'Voir les détails : ' . url('/soutenances/' . $this->soutenanceDetails['id_memoire'])
        ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'date_soutenance' => $this->soutenanceDetails['date_soutenance'],
            'heurs_soutenance' => $this->soutenanceDetails['heurs_soutenance'],
            'id_site' => $this->soutenanceDetails['id_site'],
            'id_memoire' => $this->soutenanceDetails['id_memoire'],
        ];
    }
}
