<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Email\EmailController;

class EnviarLembreteMonth extends Command
{
    protected $signature = 'enviar:lembretemonth';
    protected $description = 'Enviar lembretes mensais';

    public function handle()
    {
        $controller = new EmailController();
        $controller->lembreteMonth();

        $this->info('Lembretes mensais enviados com sucesso!');
    }
}

