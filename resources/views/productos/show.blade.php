@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Detalles del Producto</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Información General</h4>
                    <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                    <p><strong>Precio:</strong> {{ $producto->precio ?? 'N/A' }}</p>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
@endsection