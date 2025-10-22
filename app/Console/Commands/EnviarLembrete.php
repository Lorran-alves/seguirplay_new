<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Email\EmailController;

class EnviarLembrete extends Command
{
    protected $signature = 'enviar:lembrete';
    protected $description = 'Enviar lembretes de compras pendentes de ontem';

    public function handle()
    {
        $controller = new EmailController();
        $controller->lembrete();

        $this->info('Lembretes de ontem enviados com sucesso!');
    }
}

