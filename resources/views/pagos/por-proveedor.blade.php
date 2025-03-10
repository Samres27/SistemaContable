@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Pagos del Proveedor: {{ $proveedor->nombre_completo }}</h1>
            
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('pagos.create') }}?proveedor_id={{ $proveedor->id }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                <i class="fas fa-plus"></i> Nuevo Pago
            </a>
            <a href="{{ route('proveedores.show', $proveedor->id) }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                <i class="fas fa-user"></i> Ver Proveedor
            </a>
        </div>
    </div>

    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-6 mb-10">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-0">Total Pagado</h6>
                                    <h3 class="mb-0">${{ number_format($totalPagado, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-receipt fa-3x text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-0">Total de Pagos</h6>
                                    <h3 class="mb-0">{{ $pagos->total() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-calendar-alt fa-3x text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-0">Último Pago</h6>
                                    <h3 class="mb-0">
                                        @if($pagos->count() > 0)
                                            {{ $pagos->first()->fecha_pago->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-receipt fa-3x text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-0">En deuda</h6>
                                    <h3 class="mb-0">${{ number_format($totalDeuda, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filtros</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pagos.por-proveedor', $proveedor->id) }}" method="GET" class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="col-md-4">
                    <label for="fecha_inicio" class="block text-gray-700 font-medium mb-2">Fecha Desde</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="block text-gray-700 font-medium mb-2">Fecha Hasta</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-2">
                    <label for="estado" class="block text-gray-700 font-medium mb-2">Estado</label>
                    <select name="estado" id="estado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
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
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th>Liquidación</th>
                                <th>Referencia</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pagos as $pago)
                                <tr>
                                    <td class="text-center">{{ $pago->id }}</td>
                                    <td class="text-center">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $pago->monto_formateado }}</td>
                                    <td class="text-center">{{ $pago->metodo_pago }}</td>
                                    <td class="text-center">
                                        @if($pago->liquidacion_id)
                                            <a href="{{ route('liquidaciones.show', $pago->liquidacion_id) }}">
                                                #{{ $pago->liquidacion_id }}
                                            </a>
                                        @else
                                            <span class="text-muted">Sin liquidación</span>
                                        @endif
                                    </td>
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
                    <i class="fas fa-info-circle me-2"></i>
                    No se encontraron pagos para este proveedor con los filtros seleccionados.
                </div>
            @endif
        </div>
    </div>

    <!-- Gráfico de pagos por mes -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>Resumen de pagos por mes</h5>
        </div>
        <div class="card-body">
            <canvas id="pagosChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos para el gráfico - Esto debería ser proporcionado por el controlador
        // Pero por ahora lo haremos estático
        const ctx = document.getElementById('pagosChart').getContext('2d');
        const pagosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($pagos->take(6)->map(function($pago) { return $pago->fecha_pago->format('M Y'); })) !!},
                datasets: [{
                    label: 'Monto de pago',
                    data: {!! json_encode($pagos->take(6)->map(function($pago) { return $pago->monto; })) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection