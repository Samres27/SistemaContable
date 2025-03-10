@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Historial de Pagos</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('pagos.create') }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                <i class="fas fa-plus"></i> Registrar Nuevo Pago
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="text-m font-bold mb-6 text-gray-800">Filtros</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pagos.index') }}" method="GET" class="row g-3">
                <div class="grid md:grid-cols-2 gap-6 mb-10">
                    <div class="col-md-4">
                        <label for="proveedor_id" class="block text-gray-700 font-medium mb-2">Proveedor :</label>
                        <select name="proveedor_id" id="proveedor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos los proveedores</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ request('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_inicio" class="block text-gray-700 font-medium mb-2" >Fecha Desde:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin" class="block text-gray-700 font-medium mb-2">Fecha Hasta:</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('fecha_fin') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabla de pagos -->
    <div class="card">
        <div class="card-body">
            @if($pagos->count() > 0)
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>ID</th>
                                <th>Proveedor</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th>Referencia</th>
                                <th>Estado</th>
                                <th>Liquidación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pagos as $pago)
                                <tr>
                                    <td class="text-center">{{ $pago->id }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pagos.por-proveedor', $pago->proveedor_id) }}">
                                            {{ $pago->proveedor->nombre_completo }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $pago->monto_formateado }}</td>
                                    <td class="text-center">{{ $pago->metodo_pago }}</td>
                                    <td class="text-center">{{ $pago->referencia ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @if($pago->estado == 'completado')
                                            <span class="badge bg-success">Completado</span>
                                        @elseif($pago->estado == 'pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @else
                                            <span class="badge bg-danger">Cancelado</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($pago->liquidacion_id)
                                            <a href="{{ route('liquidaciones.show', $pago->liquidacion_id) }}">
                                                #{{ $pago->liquidacion_id }}
                                            </a>
                                        @else
                                            <span class="text-muted">Sin liquidación</span>
                                        @endif
                                    </td>
                                    <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pagos.show', $pago) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Ver">
                                                Ver
                                            </a>
                                            <a href="{{ route('pagos.edit', $pago) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                                Editar
                                            </a>
                                            <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>

                                        
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $pagos->appends(request()->query())->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No se encontraron pagos con los filtros seleccionados.
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    // Mostrar el modal
    function showModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    // Cerrar el modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>

@endsection