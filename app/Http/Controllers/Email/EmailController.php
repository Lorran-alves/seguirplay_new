<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Mail\LembreteMail;
use App\Mail\LembreteMailMonth;
use App\Mail\LembreteMailWeek;
use App\Models\CupomUnico;
use App\Models\EmailNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    
    public function lembrete(){
        
        // Obtém as datas de ontem
        $yesterdayStart = Carbon::yesterday()->startOfDay()->toDateTimeString();
        $yesterdayEnd = Carbon::yesterday()->endOfDay()->toDateTimeString();

        $emails = DB::table('purchases as p1')
            ->select('p1.email')
            ->whereBetween('p1.created_at', [$yesterdayStart, $yesterdayEnd])
            ->where('p1.status', '=', 'pending')
            ->whereNotExists(function ($query) use ($yesterdayStart, $yesterdayEnd) {
                $query->select(DB::raw(1))
                    ->from('purchases as p2')
                    ->whereRaw('p1.email = p2.email')
                    ->whereBetween('p2.created_at', [$yesterdayStart, $yesterdayEnd])
                    ->where(function ($innerQuery) {
                        $innerQuery->where('p2.status', '=', 'approved')
                                    ->orWhere('p2.status', '=', 'send');
                    });
            })
            ->groupBy('p1.email')
            ->get();

        //enviar email para as pessoas que não finalizaram a compra ontem
        foreach ($emails as $email) {

            if (filter_var($email->email, FILTER_VALIDATE_EMAIL)) {
                Mail::send(new LembreteMail($email->email));
            }
           
        }

    }

    public function lembreteWeek(){
        
        
        $emails = DB::table('email_notifications')
        ->select('*')
        ->where('accept_email', '=', 1)
        ->whereNull('send_1_week')
        ->where('last_purchase_date', '<=', now()->subWeek())
        ->get();
        
        // var_dump($emails);die;

        //enviar email para as pessoas que não finalizaram a compra ontem
        foreach ($emails as $email) {
            
            // $email->email = 'lorrangamer81@gmail.com';
            
            if (filter_var($email->email, FILTER_VALIDATE_EMAIL)) {
                Mail::send(new LembreteMailWeek($email->email));
            }

            $email_notification = EmailNotification::where('email', $email->email)->first();

            $email_notification->send_1_week = now();
            $email_notification->tot_emails_send = $email_notification->tot_emails_send + 1;
            $email_notification->save();
        }

    }

    public function lembreteMonth(){
        
        $emails = DB::table('email_notifications')
        ->select('*')
        ->where('accept_email', '=', 1)
        ->whereNull('send_3_month')
        ->where('last_purchase_date', '<=', now()->subMonths(3))
        ->get();

        foreach ($emails as $email) {
    
            $cupom = $this->gerarCupomUnico();

            if (filter_var($email->email, FILTER_VALIDATE_EMAIL)) {
                Mail::send(new LembreteMailMonth($email->email, $cupom));
            }
            
           
            $email_notification = EmailNotification::where('email', $email->email)->first();

            $email_notification->send_3_month = now();
            $email_notification->tot_emails_send = $email_notification->tot_emails_send + 1;
            $email_notification->save();
        }

    }


    public function gerarCupomUnico($length = 10):string
    {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cupom = '';
    
        for ($i = 0; $i < $length; $i++) {
            $cupom .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        //se o token existir chama a função novamente para gerar outro token
        if($this->cupomExists($cupom)){
            $this->gerarCupomUnico();
        }
        $this->salvarCupomUnico($cupom);
        return $cupom;

    }

    public function  salvarCupomUnico(string $cupom):void
    {
        $cupom_unico = new CupomUnico();
        $cupom_unico->nome = $cupom;
        $cupom_unico->desconto = 30;
        $cupom_unico->validade = 1;
        
        $cupom_unico->save();

    }


    public function cupomExists(string $token):bool
    {
        $cupom_unico = CupomUnico::where('nome', $token)->first();
       
        // Verifique se o cupom existe
        return $cupom_unico !== null;
    }

    public function cancelar($email){
        
        $email_notification = EmailNotification::where('email', $email)->first();

        $email_notification->accept_email = 0;
        $email_notification->save();

        return view('mails.cancelado');

    }

    
}

