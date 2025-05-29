<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $name, $number, $url, $message)
    {
        $this->email = $email;
        $this->name = $name;
        $this->number = $number;
        $this->url = $url;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Novo Contato!');
        $this->to("contato@seguirplay.com", $this->name);

        return $this->markdown('mails.contactMail', [
            'name' => $this->name,
            'email' => $this->email,
            'number' => $this->number,
            'url' => $this->url,
            'message' => $this->message,
        ]);
    }
}