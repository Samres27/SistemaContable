<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre', 
        'apellido', 
        'telefono',
        'localizacion', 
        'direccion', 
    ];

    
    public function getNombreCompletoAttribute()
    {
        return $this->apellido 
            ? "{$this->nombre} {$this->apellido}" 
            : $this->nombre;
    }

    public function ventas()
    {
        return $this->hasMany(Boleta::class, 'cliente_id');
    }

    public function ventasCount()
    {
        return $this->ventas()->count();
    }

    
}
