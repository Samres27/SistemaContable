@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-10">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Gestión de Cobros</h3>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('cobros.create') }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-plus"></i> Registrar Cobro
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Telefono</th>
                                    <th>Total Deuda</th>
                                    <th>Total Cobrado</th>
                                    <th>Saldo Pendiente</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($clientesConDeuda as $item)
                                <tr>
                                    <td class="text-center">{{ $item['cliente']->nombre }}</td>
                                    <td class="text-center">{{ $item['cliente']->telefono }}</td>
                                    <td class="text-center">S/ {{ number_format($item['total_deuda'], 2) }}</td>
                                    <td class="text-center">S/ {{ number_format($item['total_cobrado'], 2) }}</td>
                                    <td class="text-center" class="{{ $item['saldo_pendiente'] > 0 ? 'text-danger' : 'text-success' }}">
                                        S/ {{ number_format($item['saldo_pendiente'], 2) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('cobros.cliente_detalle', $item['cliente']->id) }}" class="btn btn-sm btn-primary">
                                            Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                                @if(count($clientesConDeuda) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">No hay registros</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection