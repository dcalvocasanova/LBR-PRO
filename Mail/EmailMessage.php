<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    //Importante declarar las variables
    public $name;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $message)
    {
        //
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
   {
   return $this->from("noreply@cloudtest.dx.am")
          ->view('email')
          ->subject('Asunto del mensaje')
          ->with([
                  'nameEmail' => $this->name,
                  'messageEmail' => $this->message,
                ]);
    }
}
