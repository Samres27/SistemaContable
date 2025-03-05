<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
        public function up()
        {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('alias')->nullable();
                $table->string('telefono')->nullable();
                $table->text('direccion')->nullable();
                $table->enum('tipo_liquidacion', [
                    'fijo', 
                    'variable', 
                    'mixto'
                ])->default('fijo');
                $table->timestamps();
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('proveedores');
        }
    
};
