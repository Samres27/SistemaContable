@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-10">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Clientes</h1>
        </div>
        <div class="col-md-2 text-right  mb-10">
            <a href="{{ route('envases.create') }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                Nuevo Envase
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
                <th>Peso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($envases as $envase)
            <tr>
                <td class="text-center">{{ $envase->nombre }}</td>
                <td class="text-center">{{$envase->peso}}</td>
                <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="btn-group">
                        <a href="{{ route('envases.show', $envase) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Ver
                        </a>
                        <a href="{{ route('envases.edit', $envase) }}" class="text-yellow-600 hover:text-yellow-900">
                            Editar
                        </a>
                        <form action="{{ route('envases.destroy', $envase) }}" method="POST" class="d-inline">
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

    {{ $envases->links() }}
</div>
@endsection