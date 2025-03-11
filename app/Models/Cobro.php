<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table = 'cobros';

    protected $fillable = [
        'boleta_id',
        'fecha',
        'monto',
        'metodo_pago',
        'observacion',
        'comprobante',
    ];

    // Relación con Boleta
    public function boleta()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }

    // Obtener el cliente a través de la boleta
    public function cliente()
    {
        return $this->boleta->cliente;
    }
}