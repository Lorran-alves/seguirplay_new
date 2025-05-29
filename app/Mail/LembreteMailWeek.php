<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LembreteMailWeek extends Mailable
{
    use Queueable, SerializesModels;

    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject('Deixe-nos surpreendê-lo com algo especial!');
        $this->to($this->email, "Você");
        
        return $this->markdown('mails.lembreteMailMonth',[
            'dias' => 7,
            'cupom' => 'SEGUIRPLAY10',
            'desconto' => 10,
            'email' => $this->email
            ]);
    }
}
