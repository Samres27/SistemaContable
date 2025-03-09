@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Proveedor: {{ $producto->nombre }}</h1>
    <form action="{{ route('productos.update', $producto) }}" method="POST" class="grid md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')
        
            <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Nombre *</label>
                    <input type="text" name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required 
                           value="{{ old('nombre', $producto->nombre) }}">
                </div>
                
            </div>
            <div class="space-y-4">
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Precio</label>
                    <input type="number" step="0.01" name="precio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $producto->precio }}" required>
                    </input>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">Actualizar Proveedor</button>
            </div>
        
        
    </form>
</div>
@endsection