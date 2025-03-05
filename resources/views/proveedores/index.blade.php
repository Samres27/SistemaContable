@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-10">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Proveedores</h1>
        </div>
        <div class="col-md-2 text-right  mb-10">
            <a href="{{ route('proveedores.create') }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                Nuevo Proveedor
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th>Nombre</th>
                <th>Alias</th>
                <th>Teléfono</th>
                <th>Tipo Liquidación</th>
                <th>Liquidaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($proveedores as $proveedor)
            <tr>
                <td class="text-center">{{ $proveedor->nombre }}</td>
                <td class="text-center">{{ $proveedor->alias ?? 'N/A' }}</td>
                <td class="text-center">{{ $proveedor->telefono ?? 'N/A' }}</td>
                <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
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
                </td>
                <td class="text-center">{{ $proveedor->liquidaciones_count }}</td>
                <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="btn-group">
                        <a href="{{ route('proveedores.show', $proveedor) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Ver
                        </a>
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-yellow-600 hover:text-yellow-900">
                            Editar
                        </a>
                        <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $proveedores->links() }}
</div>
@endsection