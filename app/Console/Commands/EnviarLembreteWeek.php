<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Email\EmailController;

class EnviarLembreteWeek extends Command
{
    protected $signature = 'enviar:lembreteweek';
    protected $description = 'Enviar lembretes semanais';

    public function handle()
    {
        $controller = new EmailController();
        $controller->lembreteWeek();

        $this->info('Lembretes semanais enviados com sucesso!');
    }
}

