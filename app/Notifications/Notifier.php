<?php
namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class Notifier extends Notification
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
        return ['database','broadcast','mail'];
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
                ->greeting($this->details['greeting'])
                ->line($this->details['body'])
                ->action($this->details['actionText'], $this->details['actionURL'])
                ->line($this->details['thanks']);
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array[]
     *//*
    public function toDatabase($notifiable)
    {
        return [
          'message'=> $this->details['msg'],
          'body'=> $this->details['body'],
          'sender'=> $this->details['sender'],
        ];
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    public function toArray($notifiable)
    {
        return [
          'message'=> $this->details['msg'],
          'body'=> $this->details['body'],
          'sender'=> $this->details['sender'],
          'admin'=> $notifiable
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage ([
          'notification'=> $notifiable->notifications()->first()
        ]);
    }


}
