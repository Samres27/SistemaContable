

@extends('layouts.app')

@section('content')
<div class="container">
    <x-PageHeaderIndex 
        title="Pagos" 
        buttonRoute="{{ route('pagos.create') }}" 
        buttonText="Registrar Nuevo Pago" 
    />
    <x-FilterAccions  :proveedores="$proveedores" />
    <x-FlashAlert type="success" />
    
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
                <x-TableAccions route="liquidaciones" :object="$liquidacion" />
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
                    {{ $pagos->appends(request()->query())->links() }}
                </div>
</div>
@endsection