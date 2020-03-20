<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class userRegisterNotificator extends Notification
{
    use Queueable;

    /**
     * @var Details
     */
    public $details;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
       $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Generación de credenciales acceso a Labor Pro')
            ->line('Hola, tienes una invitación para ingresar el nuestro sistema')
            ->line($this->details['usuario'])
            ->line($this->details['password'])
            ->line('¡Recuerde cambiar si contraseña!')
            ->action('Iniciar sesión', url('/login'))
            ->line('Ignore este correo si usted no está participando del proceso de metrología');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
