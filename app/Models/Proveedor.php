<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre', 
        'alias', 
        'telefono', 
        'direccion', 
        'tipo_liquidacion'
    ];

    // Relación con Liquidaciones
    public function liquidaciones()
    {
        return $this->hasMany(Liquidacion::class, 'proveedor_id');
    }

    // Método para obtener el nombre completo (con alias si existe)
    public function getNombreCompletoAttribute()
    {
        return $this->alias 
            ? "{$this->nombre} ({$this->alias})" 
            : $this->nombre;
    }

    // Método para obtener total de liquidaciones
    public function getTotalLiquidacionesAttribute()
    {
        return $this->liquidaciones()->count();
    }
    
    public function liquidacionesCount()
    {
        return $this->liquidaciones->count();
    }
}
