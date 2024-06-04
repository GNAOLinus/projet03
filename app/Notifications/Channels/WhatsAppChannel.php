<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class WhatsAppChannel
{
    protected $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

   /* public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            throw new \Exception('Notification is missing toWhatsApp method.');
        }

        $message = $notification->toWhatsApp($notifiable);
        $recipient = $notifiable->routeNotificationFor('whatsapp');

        $this->twilio->messages->create("whatsapp:{$recipient}", [
            'from' => "whatsapp:" . config('services.twilio.whatsapp_from'),
            'body' => $message,
        ]);
    }*/
}
