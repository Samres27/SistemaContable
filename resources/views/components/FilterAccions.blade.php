@props(['proveedores'=> null])

<div class="card mb-4">
    <div class="card-header">
        <h5 class="text-m font-bold mb-6 text-gray-800">Filtros</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pagos.index') }}" method="GET" class="row g-3">
            <div class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="col-md-4">
                    <x-fields.FieldInputSelect :object="$proveedores" :value="$liquidacion->proveedor_id ?? null" text_name="Proveedores" text_label="Selecciona Provedor" name="proveedor_id"/>
                    
                </div>
                <div class="col-md-3">
                    <x-filters.InputFecha id="fecha_inicio" label="Fecha Desde:" />
                </div>
                <div class="col-md-3">
                    <x-filters.InputFecha id="fecha_fin" label="Fecha Hasta:" />
                </div>
                <div class="col-md-2 d-flex align-items-end mt-7">
                    <div></div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>