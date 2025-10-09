<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $name;
    private $category;
    private $plan;
    private $purchase;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $name, $plan, $category,$purchase = '')
    {
        $this->email = $email;
        $this->name = $name;
        $this->category = $category;
        $this->plan = $plan;
        $this->purchase = $purchase;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // var_dump($this->purchase);die;
        $this->subject('Pagamento realizado com sucesso!');
        $this->to($this->email, $this->name);
      

        return $this->markdown('mails.paymentMail', ['category' => $this->category,'servico' => $this->plan->title,'purchase' => $this->purchase]);
    }
}
