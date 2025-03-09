@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Liquidación - {{ $liquidacion->comprobante }}</h1>
    <form action="{{ route('liquidaciones.update', $liquidacion) }}" method="POST" >
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Proveedor</label>
                    <select name="proveedor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" 
                                {{ $proveedor->id == $liquidacion->proveedor_id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Fecha</label>
                    <input type="date" name="fecha" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $liquidacion->fecha }}" required>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Nro Pollos</label>
                    <input type="number" name="nro_pollos" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $liquidacion->nro_pollos }}" required>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Peso Bruto</label>
                    <input type="number" step="0.01" name="peso_bruto" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $liquidacion->peso_bruto }}" required>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Peso Tara</label>
                    <input type="number" step="0.01" name="peso_tara" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $liquidacion->peso_tara }}" required>
                </div>
            </div>
            <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Porcentaje Descuento</label>
                    <input type="number" step="0.01" name="porcentaje_descuento" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $liquidacion->porcentaje_descuento }}" required>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Peso Tiki/Buche</label>
                    <input type="number" step="0.01" name="peso_tiki_buche" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $liquidacion->peso_tiki_buche }}" required>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Modalidad de Cálculo</label>
                    <div>
                        <input type="radio" name="modalidad_calculo" value="opcion1" 
                               {{ $liquidacion->modalidad_calculo == 'opcion1' ? 'checked' : '' }}> 
                        Opción 1: Peso Neto * (1-Descuento) - Tiki/Buche
                    </div>
                    <div>
                        <input type="radio" name="modalidad_calculo" value="opcion2"
                               {{ $liquidacion->modalidad_calculo == 'opcion2' ? 'checked' : '' }}> 
                        Opción 2: (Peso Neto - Tiki/Buche) * (1-Descuento)
                    </div>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Precio</label>
                    <input type="number" step="0.01" name="precio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $liquidacion->precio }}" required>
                    </input>
                </div>
                <div class="flex justify-center items-center ">
                    <button id="mostrarTablaBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                        Agregar descuento
                    </button>
                </div>
            </div>
        </div>
        <script>
            const descuentos = @json($descuentos);
        </script>
        
            <table  id="tabla" class="min-w-full divide-y divide-gray-200 mt-10 mb-10  hidden">
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
          
        <div class="flex justify-center items-center ">
            <button type="submit" class="w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">Actualizar Liquidación</button>
        </div>
    </form>
</div>
<script>
    let indexGuardado = null;
    const tabla = document.getElementById('tabla');
    const tbody = tabla.querySelector('tbody');
    let hayDescuentosConMonto = false;
    
    descuentos.forEach((descuento, index) => {
        
            if (descuento.total !== 0) {
                hayDescuentosConMonto = true;
                indexGuardado = index+1;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="hidden">
                        <input type="text" name="items[${index}][id]" class="w-full text-center" value="${descuento.id}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" name="items[${index}][nombre_item]" class="w-full text-center" value="${descuento.nombre_item}" >
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][cantidad]" class="campo-jaula w-full text-center" value="${descuento.cantidad}" >
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][precio]" class="precio-jaula w-full text-center" value="${descuento.precio}"  step="0.01">
                    </td>
                    <td class="text-center">
                        <span class="resultado">${descuento.total}</span>
                    </td>
                `;
                tbody.appendChild(row);
                const cantidadInput = row.querySelector(`input[name="items[${index}][cantidad]"]`);
                const precioInput = row.querySelector(`input[name="items[${index}][precio]"]`);

                // Listener para el cambio de cantidad o precio
                cantidadInput.addEventListener('input', calcularResultado);
                precioInput.addEventListener('input', calcularResultado);
            }
    });

    

    document.addEventListener('DOMContentLoaded', function() {
        const mensajeNoProveedores = document.getElementById('mensaje-no-proveedores');
        const selectProveedores = document.getElementById('proveedor_id');
        if(descuentos.length > 0){tabla.classList.remove('hidden');}
        if (mensajeNoProveedores) {
            // No hay proveedores, oculta el select (si existe)
            if (selectProveedores) {
                selectProveedores.style.display = 'none';
            }
        } else if (!selectProveedores || selectProveedores.options.length === 0) {
            // El select está vacío o no existe, muestra el mensaje
            const mensaje = document.createElement('p');
            mensaje.textContent = 'No hay proveedores disponibles.';
            document.body.appendChild(mensaje);
        }
    });

    let tablaMostrada = false;  // Para controlar si la tabla ha sido mostrada o no
    let index = 0;
    // Función para calcular el resultado de la multiplicación en cada fila
    function calcularResultado() {
        const filas = document.querySelectorAll('#tabla-jaulas tr');
        filas.forEach(fila => {
            const campoJaula = parseFloat(fila.querySelector('.campo-jaula').value) || 0;
            const precio = parseFloat(fila.querySelector('.precio-jaula').value) || 0;
            const resultado = campoJaula * precio;
            fila.querySelector('.resultado').textContent = resultado.toFixed(2);
        });
    }

    // Función para agregar una nueva fila con campos
    function agregarFila() {
        const tbody = document.getElementById('tabla-jaulas');
        const nuevaFila = document.createElement('tr');

        // Crear las celdas para la nueva fila
        const celdaId = document.createElement('td');
        celdaId.classList.add('hidden');
        celdaId.innerHTML = `<input type="text" name="items[${indexGuardado}][id]" class="w-full text-center" placeholder="Nombre Item" value=-1>`;

        const celdaNombre = document.createElement('td');
        celdaNombre.classList.add('text-center');
        celdaNombre.innerHTML = `<input type="text" name="items[${indexGuardado}][nombre_item]" class="w-full text-center" placeholder="Nombre Item">`;

        const celdaCantidad = document.createElement('td');
        celdaCantidad.classList.add('text-center');
        celdaCantidad.innerHTML = `<input type="number" name="items[${indexGuardado}][cantidad]" class="campo-jaula w-full text-center" value="0">`;

        const celdaPrecio = document.createElement('td');
        celdaPrecio.classList.add('text-center');
        celdaPrecio.innerHTML = `<input type="number" name="items[${indexGuardado}][precio]" class="precio-jaula w-full text-center" value="0" step="0.01">`;

        const celdaResultado = document.createElement('td');
        celdaResultado.classList.add('text-center');
        celdaResultado.innerHTML = '<span class="resultado">0.00</span>';

        // Agregar las celdas a la nueva fila
        nuevaFila.appendChild(celdaId);
        nuevaFila.appendChild(celdaNombre);
        nuevaFila.appendChild(celdaCantidad);
        nuevaFila.appendChild(celdaPrecio);
        nuevaFila.appendChild(celdaResultado);

        // Agregar la nueva fila al cuerpo de la tabla
        tbody.appendChild(nuevaFila);
        nuevaFila.querySelector('.campo-jaula').addEventListener('input', calcularResultado);
        nuevaFila.querySelector('.precio-jaula').addEventListener('input', calcularResultado);
        indexGuardado++;
    }

    // Función para mostrar la tabla y agregar la primera fila
    document.getElementById('mostrarTablaBtn').addEventListener('click', function(event) {
        event.preventDefault();  // Evitar el envío del formulario

        const tabla = document.getElementById('tabla');
        
        // Muestra la tabla la primera vez
        if (!tablaMostrada) {
            tabla.classList.remove('hidden'); // Elimina la clase 'hidden' para mostrar la tabla
            tablaMostrada = true;
        }
        agregarFila();
     
    });
</script>
@endsection