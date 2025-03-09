<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    protected $table = 'boletas';

    protected $fillable = [
        'cliente_id',
        'comprobante',
        'fecha',
        'total',
    ];   

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'boleta_id');
    }

    public function calcularTotalVenta()
    {
        return $this->ventas->sum('total');
    }
}
