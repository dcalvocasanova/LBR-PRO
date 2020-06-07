<?php
namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Str;

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
        $body =$this->details['body'];
        $replaced = Str::replaceArray('<br>', ['','',], $body);
        return (new MailMessage)
          ->greeting($this->details['greeting'])
          ->line($this->details['title'])
          ->line(Str::replaceArray('<br>', ['      ','      ','    ', '   ','  '], $body))
          ->action($this->details['actionText'], $this->details['actionURL'])
          ->line($this->details['thanks']);
    }
}
