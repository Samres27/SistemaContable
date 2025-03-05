<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        Schema::create('liquidaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedor_id');
            $table->date('fecha');
            $table->string('comprobante')->unique()->nullable();
            $table->integer('nro_pollos');
            $table->decimal('peso_bruto', 10, 2);
            $table->decimal('peso_tara', 10, 2);
            $table->decimal('peso_neto', 10, 2);
            $table->decimal('porcentaje_descuento', 5, 2);
            $table->decimal('peso_tiki_buche', 10, 2);
            $table->enum('modalidad_calculo', ['opcion1', 'opcion2'])->default('opcion1');
            $table->decimal('peso_neto_pagar', 10, 2);
            $table->decimal('promedio_peso', 10, 2);
            $table->decimal('precio', 10, 2);
            $table->decimal('total_sin_descuento', 10, 2);
            $table->decimal('total_descuento', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('proveedor_id')->references('id')->on('proveedores');
        });
    }

    public function down()
    {
        Schema::dropIfExists('liquidaciones');
    }
};
