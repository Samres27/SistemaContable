@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Detalle del Pago #{{ $pago->id }}</h1>
            
        </div>
        <div class="col-md-4 text-end">
            <a class="w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300" href="{{ route('pagos.por-proveedor', $pago->proveedor_id) }}" class="btn btn-primary">
                <i class="fas fa-user"></i> Pagos del Proveedor
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="text-l font-bold mb-6 text-gray-800">Información del Pago</h5>
                </div>
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-6 mb-10">
                        <div class="col-md-6 items-center">
                            <div>
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Proveedor:</div>
                                    <div class=" px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                                        <a href="{{ route('proveedores.show', $pago->proveedor_id) }}">
                                            {{ $pago->proveedor->nombre_completo }}
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Monto:</div>
                                    <div class="px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> {{ $pago->monto_formateado }}</div>
                                </div>
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Fecha de Pago:</div>
                                    <div class="px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> {{ $pago->fecha_pago->format('d/m/Y') }}</div>
                                </div>
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Método de Pago:</div>
                                    <div class="px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> {{ $pago->metodo_pago }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Referencia:</div>
                                    <div class="px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> {{ $pago->referencia ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Estado:</div>
                                    <div class="px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                                        @if($pago->estado == 'completado')
                                            <span class="badge bg-success">Completado</span>
                                        @elseif($pago->estado == 'pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @else
                                            <span class="badge bg-danger">Cancelado</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Liquidación:</div>
                                    <div class="px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                                        @if($pago->liquidacion_id)
                                            <a href="{{ route('liquidaciones.show', $pago->liquidacion_id) }}">
                                                Liquidación #{{ $pago->liquidacion_id }}
                                            </a>
                                        @else
                                            <span class="text-muted">Sin liquidación asociada</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="block text-gray-700 font-medium mb-2">Fecha de Registro:</div>
                                    <div class="px-3 py-2  border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> {{ $pago->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($pago->concepto)
                        <div class="mt-3">
                            <h6>Concepto:</h6>
                            <div class="border p-3 bg-light rounded">
                                {{ $pago->concepto }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Comprobante de Pago</h5>
                </div>
                <div class="card-body text-center">
                    @if($pago->comprobante)
                        <div class="mb-3">
                            @php
                                $extension = pathinfo(storage_path('app/public/' . $pago->comprobante), PATHINFO_EXTENSION);
                            @endphp
                            
                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $pago->comprobante) }}" alt="Comprobante" class="img-fluid rounded">
                            @else
                                <div class="text-center p-4 bg-light rounded">
                                    <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                    <p>Documento PDF</p>
                                </div>
                            @endif
                        </div>
                        <a href="{{ asset('storage/' . $pago->comprobante) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-download"></i> Descargar Comprobante
                        </a>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                            <p>No se ha subido ningún comprobante para este pago.</p>
                        </div>
                    @endif
                </div>
            </div>

            

            
        </div>
    </div>
</div>
@endsection