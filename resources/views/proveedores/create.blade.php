@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Nuevo Proveedor</h1>
    <form action="{{ route('proveedores.store') }}" method="POST" class="grid md:grid-cols-2 gap-6">
        @csrf
        
            <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Nombre *</label>
                    <input type="text" name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required 
                           value="{{ old('nombre') }}">
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Alias</label>
                    <input type="text" name="alias" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ old('alias') }}">
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Teléfono</label>
                    <input type="text" name="telefono" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ old('telefono') }}">
                </div>
            </div>
            <div class="space-y-4">
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Dirección</label>
                    <textarea name="direccion" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3">{{ old('direccion') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Tipo de Liquidación *</label>
                    <select name="tipo_liquidacion" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="fijo" {{ old('tipo_liquidacion') == 'fijo' ? 'selected' : '' }}>Fijo</option>
                        <option value="variable" {{ old('tipo_liquidacion') == 'variable' ? 'selected' : '' }}>Variable</option>
                        <option value="mixto" {{ old('tipo_liquidacion') == 'mixto' ? 'selected' : '' }}>Mixto</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">Guardar Proveedor</button>
            </div>
        
        
    </form>
</div>
@endsection