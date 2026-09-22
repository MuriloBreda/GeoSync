<?php

namespace App\Notifications;

use App\Models\Remessa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EntregaProximaNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Remessa $remessa,
        private readonly float $distanciaMetros,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Sua entrega está próxima')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('A remessa #' . $this->remessa->codigo_rastreio . ' está a aproximadamente ' . round($this->distanciaMetros) . ' metros do destino.')
            ->line('Destino: ' . $this->remessa->destino)
            ->action('Acompanhar remessa', route('cliente.dashboard'))
            ->line('GeoSync - rastreamento da sua entrega.');
    }
}
