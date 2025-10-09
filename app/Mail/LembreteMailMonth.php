<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LembreteMailMonth extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $cupom;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $cupom)
    {
        $this->email = $email;
        $this->cupom = $cupom;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject('Sua presença é valiosa! Não deixe de nos visitar novamente');
        $this->to($this->email, "Você");
        
        return $this->markdown('mails.lembreteMailMonth',[
            'dias' => 90,
            'cupom' => $this->cupom,
            'desconto' => 30,
            'email' => $this->email
            ]);
    }
}
