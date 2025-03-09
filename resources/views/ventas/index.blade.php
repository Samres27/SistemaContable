@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-10">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Ventas</h1>
        </div>
        <div class="col-md-2 text-right  mb-10">
            <a href="{{ route('ventas.create') }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                Nueva Venta
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
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($boletas as $boleta)
            <tr >
                <td class="text-center">{{ $boleta->comprobante }}</td>
                <td class="text-center">{{ $boleta->cliente->nombre }}</td>
                <td class="text-center">{{ $boleta->fecha }}</td>
                <td class="text-center">{{ number_format($boleta->total, 2) }}</td>
                <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                    
                        <a href="{{ route('ventas.show', $boleta) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Ver
                        </a>
                        <a href="{{ route('ventas.edit', $boleta) }}" class="text-yellow-600 hover:text-yellow-900">
                            Editar
                        </a>
                        <form action="{{ route('ventas.destroy', $boleta) }}" method="POST" class="d-inline">
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