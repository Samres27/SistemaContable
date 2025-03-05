@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-10">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Liquidaciones</h1>
        </div>
        <div class="col-md-2 text-right  mb-10">
            <a href="{{ route('liquidaciones.create') }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                Nueva Liquidación
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table  class="min-w-full divide-y divide-gray-200">
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
            <tr >
                <td class="text-center">{{ $liquidacion->comprobante }}</td>
                <td class="text-center">{{ $liquidacion->proveedor->nombre }}</td>
                <td class="text-center">{{ $liquidacion->fecha }}</td>
                <td class="text-center">{{ $liquidacion->nro_pollos }}</td>
                <td class="text-center">{{ number_format($liquidacion->peso_neto, 2) }} kg</td>
                <td class="text-center">{{ number_format($liquidacion->total_descuento, 2) }}</td>
                <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                    
                        <a href="{{ route('liquidaciones.show', $liquidacion) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Ver
                        </a>
                        <a href="{{ route('liquidaciones.edit', $liquidacion) }}" class="text-yellow-600 hover:text-yellow-900">
                            Editar
                        </a>
                        <form action="{{ route('liquidaciones.destroy', $liquidacion) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">
                                Eliminar
                            </button>
                        </form>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    
</div>
@endsection