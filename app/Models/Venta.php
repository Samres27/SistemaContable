<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fecha',
        'nro_reci',
        'nombre',
        'peso',
        'precio',
        'monto',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'nro_reci' => 'integer', 
        'precio' => 'float',
        'peso' => 'float',
        'monto' => 'float',
    ];
}