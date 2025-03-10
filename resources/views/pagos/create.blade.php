@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nuevo Pago</h1>
            
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pagos.store') }}" method="POST" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-6 mb-10">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="proveedor_id" class="block text-gray-700 font-medium mb-2">Proveedor <span class="text-danger">*</span></label>
                            <select name="proveedor_id" id="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Seleccionar proveedor</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                        {{ $proveedor->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('proveedor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="liquidacion_id" class="block text-gray-700 font-medium mb-2">Liquidación</label>
                            <select name="liquidacion_id" id="liquidacion_id" class="form-select @error('liquidacion_id') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" require>
                                <option value="">Sin liquidación</option>
                                <!-- Se cargará con AJAX -->
                            </select>
                            @error('liquidacion_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="monto" class="block text-gray-700 font-medium mb-2">Monto <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" name="monto" id="monto" class="form-control @error('monto') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('monto') }}" required>
                                @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="metodo_pago" class="block text-gray-700 font-medium mb-2">Método de Pago <span class="text-danger">*</span></label>
                            <select name="metodo_pago" id="metodo_pago" class="form-select @error('metodo_pago') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="Efectivo" {{ old('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                <option value="Transferencia" {{ old('metodo_pago') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="Cheque" {{ old('metodo_pago') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="Tarjeta" {{ old('metodo_pago') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                <option value="Otro" {{ old('metodo_pago') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('metodo_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_pago" class="block text-gray-700 font-medium mb-2">Fecha de Pago <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_pago" id="fecha_pago" class="form-control @error('fecha_pago') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('fecha_pago', date('Y-m-d')) }}" required>
                            @error('fecha_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="referencia" class="block text-gray-700 font-medium mb-2">Referencia (Opcional)</label>
                            <input type="text" name="referencia" id="referencia" class="form-control @error('referencia') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('referencia') }}" placeholder="Número de transferencia, cheque, etc.">
                            @error('referencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado" class="block text-gray-700 font-medium mb-2">Estado <span class="text-danger">*</span></label>
                            <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="concepto" class="block text-gray-700 font-medium mb-2">Concepto (Opcional)</label>
                            <textarea name="concepto" id="concepto" rows="3" class="form-control @error('concepto') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Detalles adicionales sobre el pago">{{ old('concepto') }}</textarea>
                            @error('concepto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comprobante" class="block text-gray-700 font-medium mb-2">Comprobante de Pago (Opcional)</label>
                            <input type="file" name="comprobante" id="comprobante" class="form-control @error('comprobante') is-invalid @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <small class="form-text text-muted">Formatos permitidos: PDF, JPG, JPEG, PNG (Máx. 2MB)</small>
                            @error('comprobante')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        
                        <button type="submit" class="w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-save"></i> Guardar Pago
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar liquidaciones cuando cambia el proveedor
        const proveedorSelect = document.getElementById('proveedor_id');
        const liquidacionSelect = document.getElementById('liquidacion_id');

        proveedorSelect.addEventListener('change', function() {
            const proveedorId = this.value;
            console.log("llamada al cambio");
            // Limpiar select de liquidaciones
            liquidacionSelect.innerHTML = '<option value="">Sin liquidación</option>';
            
            if (!proveedorId) return;

            // Cargar liquidaciones con AJAX
            fetch(`/pagos/get-liquidaciones-by-proveedor?proveedor_id=${proveedorId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(liquidacion => {
                        const option = document.createElement('option');
                        option.value = liquidacion.id;
                        option.textContent = liquidacion.texto;
                        liquidacionSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection



