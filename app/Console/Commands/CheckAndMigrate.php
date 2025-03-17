<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckAndMigrate extends Command
{
    protected $signature = 'check:migrate';
    protected $description = 'Verifica si las tablas existen y ejecuta migraciones y seeders si es necesario';

    public function handle()
    {
        // Lista de tablas que deberían existir
        $tablas = ['boletas', 'clientes','ventas','cobros','liquidaciones','descuentos','pagos','productos','proveedores']; 

        $faltanTablas = false;

        foreach ($tablas as $tabla) {
            if (!Schema::hasTable($tabla)) {
                $this->info("La tabla '$tabla' no existe. Ejecutando migraciones...");
                $faltanTablas = true;
                break; // Si una tabla falta, ya es suficiente para ejecutar las migraciones
            }
        }

        if ($faltanTablas) {
            $this->call('migrate');
            $this->info('Migraciones ejecutadas.');

            $this->call('db:seed', ['--class' => 'UserSeeder']);
            $this->info('Seeders ejecutados.');
        } else {
            $this->info('Todas las tablas existen. No se requieren migraciones ni seeders.');
        }
    }
}


