<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'boleta_id',
        'nombre',
        'cantidad', 
        'precio', 
        'total',
    ];   

    public function boleta()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }

    public function calcularTotal()
    {
        return $this->cantidad * $this->precio;
    }
}
