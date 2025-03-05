<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    protected $table = 'liquidaciones';

    protected $fillable = [
        'proveedor_id', 
        'fecha', 
        'comprobante', 
        'nro_pollos', 
        'peso_bruto', 
        'peso_tara', 
        'peso_neto', 
        'porcentaje_descuento', 
        'peso_tiki_buche', 
        'modalidad_calculo', 
        'peso_neto_pagar', 
        'promedio_peso', 
        'precio', 
        'total_sin_descuento',
        'total_descuento'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function descuentos()
    {
        return $this->hasMany(Descuento::class, 'liquidacion_id');
    }

    // Método para calcular peso neto
    public function calcularPesoNeto()
    {
        return $this->peso_bruto - $this->peso_tara;
    }

    // Método para calcular peso neto a pagar
    public function calcularPesoNetoPagar()
    {
        $pesoNeto = $this->calcularPesoNeto();

        if ($this->modalidad_calculo == 'opcion1') {
            return $pesoNeto * (1 - ($this->porcentaje_descuento / 100)) - $this->peso_tiki_buche;
        } else {
            return ($pesoNeto - $this->peso_tiki_buche) * (1 - ($this->porcentaje_descuento / 100));
        }
    }

    // Método para calcular promedio de peso
    public function calcularPromedioPeso()
    {
        return $this->calcularPesoNeto() / $this->nro_pollos;
    }

    // Método para calcular total
    public function calcularTotal()
    {
        return $this->calcularPesoNetoPagar() * $this->precio;
    }

    public function calcularTotalDescuento()
    {
        $descuentos = $this->descuentos;
        $totalDescuentos = $descuentos->sum('total');

        return $this->calcularTotal()- $totalDescuentos;
    }
}
