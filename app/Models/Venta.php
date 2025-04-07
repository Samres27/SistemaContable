<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'boleta_id',
        'nombre',
        'cantidad_bruto',
        'peso_envase',
        'cantidad_neto', 
        'precio', 
        'total',
    ];   

    public function boleta()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }

    public function calcularNeto()
    {
        return $this->cantidad_bruto - $this->peso_envase;
    }


    public function calcularTotal()
    {
        return $this->cantidad_neto * $this->precio;
    }
}
