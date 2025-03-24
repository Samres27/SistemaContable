<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CheckAndMigrate extends Command
{
    protected $signature = 'check:migrate';
    protected $description = 'Verifica si las tablas existen y ejecuta migraciones y seeders si es necesario';

    public function handle()
    {
        $this->call('migrate');
             
        // Verificar si las migraciones ya han sido ejecutadas para evitar re-ejecutarlas
        if (DB::table('users')->count() === 0) {
            $this->info('Faltar Completar los usuarios');
            $this->call('db:seed', ['--class' => 'UserSeeder']);
            $this->info('Seeders ejecutados.');
        } else {
            $this->info('Las migraciones ya han sido ejecutadas. No es necesario volver a ejecutarlas.');
        }
    }
}


