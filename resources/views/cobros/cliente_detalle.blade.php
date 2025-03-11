@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="text-xl font-bold mb-6 text-gray-800">Detalle del Cliente: {{ $cliente->nombre }}</h5>
                    
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="block text-gray-700 font-medium mb-2">Total Deuda</h6>
                                    <h3 class="text-danger">{{ number_format($totalDeuda, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="block text-gray-700 font-medium mb-2">Total Cobrado</h6>
                                    <h3 class="text-success">{{ number_format($totalCobrado, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="block text-gray-700 font-medium mb-2">Saldo Pendiente</h6>
                                    <h3 class="{{ $saldoPendiente > 0 ? 'text-warning' : 'text-success' }}">
                                        {{ number_format($saldoPendiente, 0, ',', '.') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="text-xl font-bold mb-6 text-gray-800">Información del Cliente</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                                            <p><strong>RUT/ID:</strong> {{ $cliente->rut ?? $cliente->id }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'No registrado' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="text-l font-bold mb-6 text-gray-800">Historial de Boletas y Cobros</h6>
                        </div>
                        <div class="card-body">
                            @if($boletas->count() > 0)
                                <div class="table-responsive">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th>Nº Boleta</th>
                                                <th>Fecha</th>
                                                <th>Total</th>
                                                <th>Cobrado</th>
                                                <th>Pendiente</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($boletas as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item['boleta']->id }}</td>
                                                    <td class="text-center">{{ $item['boleta']->created_at->format('d/m/Y') }}</td>
                                                    <td class="text-center">{{ number_format($item['total'], 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ number_format($item['cobrado'], 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ number_format($item['pendiente'], 0, ',', '.') }}</td>
                                                    <td class="text-center">
                                                        @if($item['pendiente'] <= 0)
                                                            <span class="badge bg-success">Pagado</span>
                                                        @elseif($item['cobrado'] > 0)
                                                            <span class="badge bg-warning">Parcial</span>
                                                        @else
                                                            <span class="badge bg-danger">Pendiente</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('ventas.show', $item['boleta']->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                            <i class="fa fa-eye"></i> Ver
                                                        </a>
                                                        @if($item['pendiente'] > 0)
                                                            <a href="{{ route('cobros.create', ['venta_id' => $item['boleta']->id]) }}" class="text-yellow-600 hover:text-yellow-900">
                                                                <i class="fa fa-money-bill"></i> Registrar Pago
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($item['boleta']->cobros->count() > 0)
                                                    <tr>
                                                        <td colspan="7" class="bg-light">
                                                            <div class="ps-4">
                                                                <h6 class="text-l font-bold mb-6 text-gray-800">Historial de pagos:</h6>
                                                                <ul class="list-group">
                                                                    @foreach($item['boleta']->cobros as $cobro)
                                                                    <li class="list-group-item flex justify-between items-center">
                                                                        <div class="mb-3"> <!-- Espaciado en la parte inferior -->
                                                                            <span class="font-bold">{{ $cobro->created_at->format('d/m/Y') }}</span>
                                                                            - {{ $cobro->metodo_pago ?? 'Método no especificado' }}
                                                                            @if($cobro->observacion)
                                                                                <br><small class="text-muted text-gray-500">{{ $cobro->observacion }}</small>
                                                                            @endif
                                                                        </div>
                                                                        <span class="badge bg-success rounded-full bg-green-500 text-white px-4 py-1 text-sm">
                                                                            {{ number_format($cobro->monto, 0, ',', '.') }}
                                                                        </span>
                                                                    </li>

                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Este cliente no tiene ventas registradas.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection