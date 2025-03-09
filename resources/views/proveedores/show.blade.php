@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Detalles del Proveedor</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Información General</h4>
                    <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
                    <p><strong>Alias:</strong> {{ $proveedor->alias ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $proveedor->telefono ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Detalles Adicionales</h4>
                    <p><strong>Dirección:</strong> {{ $proveedor->direccion ?? 'N/A' }}</p>
                    <p><strong>Tipo de Liquidación:</strong> 
                        @switch($proveedor->tipo_liquidacion)
                            @case('fijo')
                                <span class="badge bg-primary">Fijo</span>
                                @break
                            @case('variable')
                                <span class="badge bg-success">Variable</span>
                                @break
                            @case('mixto')
                                <span class="badge bg-warning">Mixto</span>
                                @break
                        @endswitch
                    </p>
                </div>
            </div>
            <div class="space-y-4">
                <h4 class="text-xl font-bold mb-6 text-gray-800" class="mt-4">Liquidaciones</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>Comprobante</th>
                            <th>Fecha</th>
                            <th>Nro Pollos</th>
                            <th>Peso Neto</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($liquidaciones as $liquidacion)
                        <tr>
                            <td class="text-center">{{ $liquidacion->comprobante }}</td>
                            <td class="text-center">{{ $liquidacion->fecha }}</td>
                            <td class="text-center">{{ $liquidacion->nro_pollos }}</td>
                            <td class="text-center">{{ number_format($liquidacion->peso_neto, 2) }} kg</td>
                            <td class="text-center">{{ number_format($liquidacion->total_descuento, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection