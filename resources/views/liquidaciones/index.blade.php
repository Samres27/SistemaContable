@extends('layouts.app')

@section('content')
<div class="container">
    <x-PageHeaderIndex 
        title="Liquidaciones" 
        buttonRoute="{{ route('liquidaciones.create') }}" 
        buttonText="Nueva Liquidación" 
    />
    
    <x-FlashAlert type="success" />
    
    <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th>Comprobante</th>
            <th>Proveedor</th>
            <th>Fecha</th>
            <th>Nro Pollos</th>
            <th>Peso Neto</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($liquidaciones as $liquidacion)
        <tr>
            <td class="text-center">{{ $liquidacion->comprobante }}</td>
            <td class="text-center">{{ $liquidacion->proveedor->nombre }}</td>
            <td class="text-center">{{ $liquidacion->fecha }}</td>
            <td class="text-center">{{ $liquidacion->nro_pollos }}</td>
            <td class="text-center">{{ number_format($liquidacion->peso_neto, 2) }} kg</td>
            <td class="text-center">{{ number_format($liquidacion->total_descuento, 2) }}</td>
            <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                <x-TableAccions route="liquidaciones" :object="$liquidacion" />
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection