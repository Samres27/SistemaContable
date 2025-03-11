@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Editar Cobro</h3>
                    <a href="{{ route('cobros.cliente.detalle', $cobro->boleta->cliente_id) }}" class="btn btn-secondary">Volver</a>
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

                    <form method="POST" action="{{ route('cobros.update', $cobro->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Cliente</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $cobro->boleta->cliente->nombre }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Boleta</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $cobro->boleta->comprobante }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Total Boleta</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="S/ {{ number_format($cobro->boleta->total, 2) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Total Cobrado</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="S/ {{ number_format($cobro->boleta->cobros->where('id', '!=', $cobro->id)->sum('monto'), 2) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Saldo Pendiente + Este Cobro</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="S/ {{ number_format($cobro->boleta->total - $cobro->boleta->cobros->where('id', '!=', $cobro->id)->sum('monto'), 2) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha de Cobro</label>
                            <div class="col-md-6">
                                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ old('fecha', $cobro->fecha) }}" required>
                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="monto" class="col-md-4 col-form-label text-md-right">Monto Cobrado</label>
                            <div class="col-md-6">
                                <input id="monto" type="number" step="0.01" class="form-control @error('monto') is-invalid @enderror" name="monto" value="{{ old('monto', $cobro->monto) }}" required>
                                @error('monto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="metodo_pago" class="col-md-4 col-form-label text-md-right">Método de Pago</label>
                            <div class="col-md-6">
                                <select id="metodo_pago" class="form-control @error('metodo_pago') is-invalid @enderror" name="metodo_pago" required>
                                    <option value="">Seleccione</option>
                                    <option value="Efectivo" {{ old('metodo_pago', $cobro->metodo_pago) == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                    <option value="Transferencia" {{ old('metodo_pago', $cobro->metodo_pago) == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                    <option value="Depósito" {{ old('metodo_pago', $cobro->metodo_pago) == 'Depósito' ? 'selected' : '' }}>Depósito</option>
                                    <option value="Tarjeta" {{ old('metodo_pago', $cobro->metodo_pago) == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                    <option value="Otro" {{ old('metodo_pago', $cobro->metodo_pago) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('metodo_pago')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="comprobante" class="col-md-4 col-form-label text-md-right">Comprobante Nº</label>
                            <div class="col-md-6">
                                <input id="comprobante" type="text" class="form-control @error('comprobante') is-invalid @enderror" name="comprobante" value="{{ old('comprobante', $cobro->comprobante) }}">
                                @error('comprobante')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="observacion" class="col-md-4 col-form-label text-md-right">Observación</label>
                            <div class="col-md-6">
                                <textarea id="observacion" class="form-control @error('observacion') is-invalid @enderror" name="observacion">{{ old('observacion', $cobro->observacion) }}</textarea>
                                @error('observacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar Cobro
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection