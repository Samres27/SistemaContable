@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nuevo Cobro</h3>
                    <a href="{{ $boleta ? route('cobros.cliente.detalle', $cliente->id) : route('cobros.index') }}" class="btn btn-secondary">Volver</a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('cobros.store') }}" class="grid md:grid-cols-2 gap-6 mb-10">
                        @csrf

                        @if($boleta)
                        <!-- Si viene una boleta específica -->
                        <input type="hidden" name="boleta_id" value="{{ $boleta->id }}">
                        
                        <div class="form-group row mb-3">
                            <label class="block text-gray-700 font-medium mb-2">Cliente</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $cliente->nombre }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="block text-gray-700 font-medium mb-2">Boleta</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $boleta->comprobante }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="block text-gray-700 font-medium mb-2">Total Boleta</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="S/ {{ number_format($boleta->total, 2) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="block text-gray-700 font-medium mb-2">Total Cobrado</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="S/ {{ number_format($boleta->cobros->sum('monto'), 2) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="block text-gray-700 font-medium mb-2">Saldo Pendiente</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="S/ {{ number_format($boleta->total - $boleta->cobros->sum('monto'), 2) }}" readonly>
                            </div>
                        </div>
                        @else
                        <!-- Si no viene una boleta específica, mostrar selector de cliente y boletas -->
                        <div>
                            <div class="form-group row mb-3">
                                <label for="cliente_id" class="block text-gray-700 font-medium mb-2">Cliente</label>
                                <div class="col-md-6">
                                    <select id="cliente_id" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="cargarBoletas(this.value)">
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="boleta_id" class="block text-gray-700 font-medium mb-2">Boleta</label>
                                <div class="col-md-6">
                                    <select id="boleta_id" name="boleta_id" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <option value="">Seleccione una boleta</option>
                                    </select>
                                </div>
                            </div>

                            <div id="detalles-boleta"></div>
                            @endif

                            <div class="form-group row mb-3">
                                <label for="fecha" class="block text-gray-700 font-medium mb-2">Fecha de Cobro</label>
                                <div class="col-md-6">
                                    <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                    @error('fecha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="monto" class="block text-gray-700 font-medium mb-2">Monto Cobrado</label>
                                <div class="col-md-6">
                                    <input id="monto" type="number" step="0.01" class="form-control @error('monto') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="monto" value="{{ old('monto') }}" required>
                                    @error('monto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            
                        </div>
                        <div>
                            <div class="form-group row mb-3">
                                <label for="metodo_pago" class="block text-gray-700 font-medium mb-2">Método de Pago</label>
                                <div class="col-md-6">
                                    <select id="metodo_pago" class="form-control @error('metodo_pago') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="metodo_pago" required>
                                        <option value="">Seleccione</option>
                                        <option value="Efectivo" {{ old('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                        <option value="Transferencia" {{ old('metodo_pago') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                        <option value="Depósito" {{ old('metodo_pago') == 'Depósito' ? 'selected' : '' }}>Depósito</option>
                                        <option value="Tarjeta" {{ old('metodo_pago') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                        <option value="Otro" {{ old('metodo_pago') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('metodo_pago')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="comprobante" class="block text-gray-700 font-medium mb-2">Comprobante Nº</label>
                                <div class="col-md-6">
                                    <input id="comprobante" type="text" class="form-control @error('comprobante') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="comprobante" value="{{ old('comprobante') }}">
                                    @error('comprobante')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="observacion" class="block text-gray-700 font-medium mb-2">Observación</label>
                                <div class="col-md-6">
                                    <textarea id="observacion" class="form-control @error('observacion') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="observacion">{{ old('observacion') }}</textarea>
                                    @error('observacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                                    Registrar Cobro
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$boleta)
<script>
    function cargarBoletas(clienteId) {
        if (!clienteId) {
            return;
        }
        
        fetch(`cliente/${clienteId}/boletas`)
            .then(response => response.json())
            .then(data => {
                const selectBoleta = document.getElementById('boleta_id');
                selectBoleta.innerHTML = '<option value="">Seleccione una boleta</option>';
                
                data.forEach(boleta => {
                    if (!boleta.cancelado){
                        selectBoleta.innerHTML += `<option value="${boleta.id}">${boleta.texto}</option>`;
                    }
                });
            });
    }
    
    
</script>
@endif
@endsection