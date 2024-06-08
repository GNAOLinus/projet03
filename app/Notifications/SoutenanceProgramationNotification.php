<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SoutenanceProgramationNotification extends Notification
{
    use Queueable;

    protected $soutenanceDetails;

    /**
     * Crée une nouvelle instance de notification.
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
    return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Programmation de Soutenance')
        ->line('La soutenance pour le mémoire ' . $this->soutenanceDetails['titre'] . ' a été programmée.')
        ->line('Date : ' . $this->soutenanceDetails['date_soutenance'])
        ->line('Heure : ' . $this->soutenanceDetails['heurs_soutenance'])
        ->line('Lieu ESM : ' . $this->soutenanceDetails['site_nom'] . ' au ' . $this->soutenanceDetails['site_address'])
        ->line('Merci d\'utiliser notre application!');
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
            'site_nom' => $this->soutenanceDetails['site_nom'],
            'site_address' => $this->soutenanceDetails['site_address'],
            'titre' => $this->soutenanceDetails['titre'],
            'id_memoire' => $this->soutenanceDetails['id_memoire'],
            'message' => 'Votre êtes convoqué a une soutenance .',
        ];
    }
    

}
