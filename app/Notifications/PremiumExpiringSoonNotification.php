<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class PremiumExpiringSoonNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   

      public function __construct(public \DateTimeInterface $endsAt) {

      }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
  
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre badge Premium expire bientôt')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line('Votre badge Premium expirera dans 7 jours.')
            ->line('Date d’expiration : ' . optional($notifiable->premium_ends_at)->format('Y-m-d H:i'))
            ->action('Renouveler maintenant', url('/dashboard'))
            ->line('Merci d’utiliser Talentia.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
