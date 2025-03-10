<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'proveedor_id',
        'liquidacion_id',
        'monto',
        'metodo_pago',
        'referencia',
        'concepto',
        'fecha_pago',
        'estado',
        'comprobante',
        'saldo'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2'
    ];

    // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Relación con Liquidación
    public function liquidacion()
    {
        return $this->belongsTo(Liquidacion::class, 'liquidacion_id');
    }

    // Scope para filtrar pagos por proveedor
    public function scopeProveedor($query, $proveedorId)
    {
        return $query->where('proveedor_id', $proveedorId);
    }

    // Scope para filtrar por fecha
    public function scopeFechaBetween($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
    }

    // Accessor para formatear el monto
    public function getMontoFormateadoAttribute()
    {
        return '$ ' . number_format($this->monto, 2);
    }

    public function calcularSaldo()
    {
        return $this->liquidacion->total_descuento - $this->monto ;
    }
}