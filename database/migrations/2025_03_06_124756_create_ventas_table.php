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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boleta_id');
            $table->string('nombre');
            $table->decimal('cantidad')->nullable();
            $table->decimal('precio')->nullable();
            $table->decimal('total')->nullable();
            $table->timestamps();
            $table->foreign('boleta_id')->references('id')->on('boletas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
