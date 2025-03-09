@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Venta - {{ $boleta->comprobante }}</h1>
    <form action="{{ route('ventas.update', $boleta) }}" method="POST" >
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Cliente</label>
                    <select name="cliente_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" 
                                {{ $cliente->id == $boleta->cliente_id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Fecha</label>
                    <input type="date" name="fecha" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           value="{{ $boleta->fecha }}" required>
                </div>
                
            </div>
            
                
                <div class="flex justify-center items-center ">
                    <button id="mostrarTablaBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                        Agregar venta
                    </button>
                </div>
            
        </div>
        <script>
            const ventas = @json($ventas);
            const productos = @json($productos);
        </script>
        
        <table   class="min-w-full divide-y divide-gray-200 mt-10 mb-10 ">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 border">Productos</th>
                        <th class="px-4 py-2 border">Producto</th>
                        <th class="px-4 py-2 border">Cantidad</th>
                        <th class="px-4 py-2 border">Precio</th>
                        <th class="px-4 py-2 border">Resultado</th>
                    </tr>
                </thead>
                <tbody id="tabla-jaulas" class="bg-white divide-y divide-gray-200">
                   
                    
                </tbody>
            </table>
            <div class="flex justify-center items-center ">
                <button type="submit" class="w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Guardar Venta   
                </button>
            </div>
        </form>
    </div>
<script>
    let indexGuardado = null;
    const tbody = document.getElementById('tabla-jaulas');
    let hayDescuentosConMonto = false;
    
    ventas.forEach((venta, index) => {
        
            if (venta.total !== 0) {
                hayDescuentosConMonto = true;
                indexGuardado = index+1;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="hidden">
                        <input type="text" name="ventas[${index}][id]" class="w-full text-center" value="${venta.id}" readonly>
                    </td>
                    <td class="text-center">
                    <select  class="celda_producto w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                       <option>Seleccione</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                    </td>
                    <td class="text-center">
                        <input type="text" name="ventas[${index}][nombre]" class="nombre_p w-full text-center" value="${venta.nombre}" >
                    </td>
                    <td class="text-center">
                        <input type="number" name="ventas[${index}][cantidad]" class="campo-jaula w-full text-center" value="${venta.cantidad}" >
                    </td>
                    <td class="text-center">
                        <input type="number" name="ventas[${index}][precio]" class="precio-jaula w-full text-center" value="${venta.precio}"  step="0.01">
                    </td>
                    <td class="text-center">
                        <span class="resultado">${venta.total}</span>
                    </td>
                `;
                tbody.appendChild(row);
                const cantidadInput = row.querySelector(`input[name="ventas[${index}][cantidad]"]`);
                const precioInput = row.querySelector(`input[name="ventas[${index}][precio]"]`);

                // Listener para el cambio de cantidad o precio
                cantidadInput.addEventListener('input', calcularResultado);
                precioInput.addEventListener('input', calcularResultado);
            }
    });

    

    document.addEventListener('DOMContentLoaded', function() {
        const mensajeNoProveedores = document.getElementById('mensaje-no-proveedores');
        const selectProveedores = document.getElementById('proveedor_id');
        if(ventas.length > 0){tabla.classList.remove('hidden');}
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
    function cambiarPrecio(event) {
        const select = event.target;
        const fila = select.closest('tr'); // Encuentra la fila correspondiente
        const productoId = select.value;  // Obtén el ID del producto seleccionado


        // Buscar el producto seleccionado en el array
        const productoSeleccionado = productos.find(producto => producto.id == productoId);
        if (productoSeleccionado) {
            // Actualiza el campo de precio
            const precioCelda = fila.querySelector('.precio-jaula');
            precioCelda.value = parseFloat(productoSeleccionado.precio).toFixed(2); // Asigna el precio con 2 decimales

            const nombreCelda = fila.querySelector('.nombre_p');
            nombreCelda.value = productoSeleccionado.nombre; // Asigna el precio con 2 decimales
        }
    }
    // Función para agregar una nueva fila con campos
    function agregarFila() {
        //const tbody = document.getElementById('tabla-jaulas');
        const nuevaFila = document.createElement('tr');

        const celdaId = document.createElement('td');
        celdaId.classList.add('hidden');
        celdaId.innerHTML = `<input type="text" name="ventas[${indexGuardado}][id]" class=" w-full text-center hidden" placeholder="Nombre" value=-1>`;

        
        const celdaProducto = document.createElement('td');
        celdaProducto.classList.add('text-center');
        celdaProducto.innerHTML = `<select  class="celda_producto w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                       <option>Seleccione</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>`;

        // Crear las celdas para la nueva fila
        const celdaNombre = document.createElement('td');
        celdaNombre.classList.add('text-center');
        celdaNombre.innerHTML = `<input type="text" name="ventas[${indexGuardado}][nombre]" class="nombre_p w-full text-center" placeholder="Nombre">`;

        const celdaCantidad = document.createElement('td');
        celdaCantidad.classList.add('text-center');
        celdaCantidad.innerHTML = `<input type="number" name="ventas[${indexGuardado}][cantidad]" class="campo-jaula w-full text-center" value="0">`;

        const celdaPrecio = document.createElement('td');
        celdaPrecio.classList.add('text-center');
        celdaPrecio.innerHTML = `<input type="number" name="ventas[${indexGuardado}][precio]" class="precio-jaula w-full text-center" value="0" step="0.01">`;

        const celdaResultado = document.createElement('td');
        celdaResultado.classList.add('text-center');
        celdaResultado.innerHTML = '<span class="resultado">0.00</span>';

        // Agregar las celdas a la nueva fila
        nuevaFila.appendChild(celdaId);
        nuevaFila.appendChild(celdaProducto);
        nuevaFila.appendChild(celdaNombre);
        nuevaFila.appendChild(celdaCantidad);
        nuevaFila.appendChild(celdaPrecio);
        nuevaFila.appendChild(celdaResultado);

        // Agregar la nueva fila al cuerpo de la tabla
        tbody.appendChild(nuevaFila);
        nuevaFila.querySelector('.campo-jaula').addEventListener('input', calcularResultado);
        nuevaFila.querySelector('.precio-jaula').addEventListener('input', calcularResultado);
        const select = celdaProducto.querySelector('select');
        select.addEventListener('change', cambiarPrecio);
        index++;
    }

    // Función para mostrar la tabla y agregar la primera fila
    document.getElementById('mostrarTablaBtn').addEventListener('click', function(event) {
        event.preventDefault();  // Evitar el envío del formulario

        const tabla = document.getElementById('tabla');
        
        agregarFila();        
    });
</script>
@endsection