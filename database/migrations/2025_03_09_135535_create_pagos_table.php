<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->foreignId('liquidacion_id')->nullable()->constrained('liquidaciones')->onDelete('set null');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago'); // Efectivo, Transferencia, Cheque, etc.
            $table->string('referencia')->nullable(); // Número de transacción, cheque, etc.
            $table->text('concepto')->nullable();
            $table->date('fecha_pago');
            $table->string('estado')->default('completado'); // completado, pendiente, cancelado
            $table->string('comprobante')->nullable(); // Ruta al archivo de comprobante
            $table->decimal('saldo', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
