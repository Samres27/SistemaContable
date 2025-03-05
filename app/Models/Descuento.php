<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuentos';

    protected $fillable = [
        'liquidacion_id',
        'nombre_item', 
        'cantidad', 
        'precio', 
        'total',
    ];

    public function liquidacion()
    {
        return $this->belongsTo(liquidacion::class, 'liquidacion_id');
    }

    public function calcularTotal()
    {
        return $this->cantidad * $this->precio;
    }
}
