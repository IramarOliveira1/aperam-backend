<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AperamMail extends Mailable
{
    use Queueable, SerializesModels;

    private $token;
    private $name;

    /**
     * Create a new message instance.
     *
     * @return votoken
     */
    public function __construct($token, $name)
    {
        $this->token = $token;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.aperamMail', [
            'token' => $this->token,
            'name' => $this->name
        ])->subject('Notificação Resete de Senha');
    }
}
