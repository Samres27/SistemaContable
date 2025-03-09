@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Detalles del Cliente</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Información General</h4>
                    <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                    <p><strong>Apellido:</strong> {{ $cliente->apellido ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Detalles Adicionales</h4>
                    <p><strong>Dirección:</strong> {{ $cliente->direccion ?? 'N/A' }}</p>
                    <p><strong>Localizacion:</strong>{{ $cliente->localizacion ?? 'N/A' }} </p>
                </div>
            </div>
            <div class="space-y-4">
                <h4 class="text-xl font-bold mb-6 text-gray-800" class="mt-4">Ventas</h4>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>Comprobante</th>
                            <th>Fecha</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ventas as $venta)
                        <tr>
                            <td class="text-center">{{ $venta->comprobante }}</td>
                            <td class="text-center">{{ $venta->fecha }}</td>
                            <td class="text-center">{{ number_format($venta->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection