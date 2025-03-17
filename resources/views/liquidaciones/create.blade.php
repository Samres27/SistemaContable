@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl bg-white shadow-md rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Nueva Liquidación</h1>
    
    
        <form action="{{ route('liquidaciones.store') }}" method="POST">
        @csrf
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <div class="space-y-4">
                <x-fields.FieldInputSelect :object="$proveedores" :value="$liquidacion->proveedor_id ?? null" text_name="Proveedor" text_label="Selecciona Proveedor" name="proveedor_id"/>
                <x-fields.FieldInputFecha :value="$liquidacion->fecha ?? date('Y-m-d')" name="fecha"/>
                <x-fields.FieldInputNumber :value="$liquidacion->nro_pollos ?? ''" text="Nro Pollos" name="nro_pollos" />
                <x-fields.FieldInputNumber :value="$liquidacion->peso_bruto ?? ''" text="Peso Bruto" name="peso_bruto"/>
                <x-fields.FieldInputNumber :value="$liquidacion->peso_tara ?? ''"  text="Peso Tara" name="peso_tara"/>
            </div>
            <div class="space-y-4">
                <x-fields.FieldInputNumber :value="$liquidacion->porcentaje_descuento ?? ''" text="Porcentaje Descuento" name="porcentaje_descuento"/>
                <x-fields.FieldInputNumber :value="$liquidacion->peso_tiki_buche ?? ''" text="Peso Tiki/Buche" name="peso_tiki_buche" />
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Modalidad de Cálculo</label>
                    <div>
                        <input type="radio" name="modalidad_calculo" value="opcion1" checked> 
                        Opción 1: Peso Neto * (1-Descuento) - Tiki/Buche
                    </div>
                    <div>
                        <input type="radio" name="modalidad_calculo" value="opcion2"> 
                        Opción 2: (Peso Neto - Tiki/Buche) * (1-Descuento)
                    </div>
                </div>
                <x-fields.FieldInputNumber :value="$liquidacion->precio ?? ''" text="Precio" name="precio"/>
                <div class="flex justify-center items-center">
                    <button id="mostrarTablaBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                        Agregar descuento
                    </button>
                </div>
            </div>
        </div>
        
        <table id="tabla" class="min-w-full divide-y divide-gray-200 mt-10 mb-10  hidden">
            <h4 class="text-xl font-bold mb-6 text-gray-800">Para borrar ponga multiplicacion 0 en resultado</h4>
            
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 border">Nombre Item</th>
                    <th class="px-4 py-2 border">Cantidad</th>
                    <th class="px-4 py-2 border">Precio x Item</th>
                    <th class="px-4 py-2 border">Resultado</th>
                </tr>
            </thead>
            <tbody id="tabla-jaulas" class="bg-white divide-y divide-gray-200">
            </tbody>
        </table>

        <script>
            // Inicializar variables
            let descuentos =0;
            let tablaMostrada = false;
            let indexGuardado = 0; 
            {{$editing=false}}
            @if($editing)
                const descuentos = @json($descuentos);
                
                descuentos.forEach((descuento, index) => {
                    if (descuento.total !== 0) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="hidden">
                                <input type="text" name="items[${index}][id]" class="w-full text-center" value="${descuento.id}" readonly>
                            </td>
                            <td class="text-center">
                                <input type="text" name="items[${index}][nombre_item]" class="w-full text-center" value="${descuento.nombre_item}" >
                            </td>
                            <td class="text-center">
                                <input type="number" name="items[${index}][cantidad]" class="campo-jaula w-full text-center" value="${descuento.cantidad} step="0.01"" >
                            </td>
                            <td class="text-center">
                                <input type="number" name="items[${index}][precio]" class="precio-jaula w-full text-center" value="${descuento.precio}"  step="0.01">
                            </td>
                            <td class="text-center">
                                <span class="resultado">${descuento.total}</span>
                            </td>
                        `;
                        document.getElementById('tabla-jaulas').appendChild(row);
                        
                        const cantidadInput = row.querySelector(`input[name="items[${index}][cantidad]"]`);
                        const precioInput = row.querySelector(`input[name="items[${index}][precio]"]`);
                        
                        cantidadInput.addEventListener('input', calcularResultado);
                        precioInput.addEventListener('input', calcularResultado);
                    }
                });
            @endif
            
            // Función para calcular el resultado
            function calcularResultado() {
                const filas = document.querySelectorAll('#tabla-jaulas tr');
                filas.forEach(fila => {
                    const campoJaula = parseFloat(fila.querySelector('.campo-jaula').value) || 0;
                    const precio = parseFloat(fila.querySelector('.precio-jaula').value) || 0;
                    const resultado = campoJaula * precio;
                    fila.querySelector('.resultado').textContent = resultado.toFixed(2);
                });
            }

            // Función para agregar una nueva fila
            function agregarFila() {
                const tbody = document.getElementById('tabla-jaulas');
                const nuevaFila = document.createElement('tr');
                
                // Preparar contenido según si estamos editando o creando
                let celdaId = '';
                if ({{ $editing ? 'true' : 'false' }}) {
                    celdaId = `
                        <td class="hidden">
                            <input type="text" name="items[${indexGuardado}][id]" class="w-full text-center" value="-1">
                        </td>
                    `;
                }
                
                nuevaFila.innerHTML = `
                    ${celdaId}
                    <td class="text-center">
                        <input type="text" name="items[${indexGuardado}][nombre_item]" class="w-full text-center" placeholder="Nombre Item">
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${indexGuardado}][cantidad]" class="campo-jaula w-full text-center" value="0" step="0.01">
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${indexGuardado}][precio]" class="precio-jaula w-full text-center" value="0" step="0.01">
                    </td>
                    <td class="text-center">
                        <span class="resultado">0.00</span>
                    </td>
                `;

                tbody.appendChild(nuevaFila);
                nuevaFila.querySelector('.campo-jaula').addEventListener('input', calcularResultado);
                nuevaFila.querySelector('.precio-jaula').addEventListener('input', calcularResultado);
                indexGuardado++;
            }

            // Evento para mostrar tabla y agregar filas
            document.getElementById('mostrarTablaBtn').addEventListener('click', function(event) {
                event.preventDefault();
                
                const tabla = document.getElementById('tabla');
                
                if (!tablaMostrada) {
                    tabla.classList.remove('hidden');
                    tablaMostrada = true;
                }
                
                agregarFila();
            });
        </script>
                
        <div class="flex justify-center items-center">
            <button type="submit" class="w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
            Guardar Liquidación
            </button>
        </div>
    </form>
</div>


@endsection

