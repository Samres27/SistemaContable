@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Venta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto max-w-5xl bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Nueva Venta</h1>
        
        <form method="POST" action="{{ route('ventas.store') }}" >
            @csrf
            <div class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="space-y-4">
                    <div class="form-group">
                        <label class="block text-gray-700 font-medium mb-2">Cliente</label>
                        <select name="cliente_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Seleccionar Cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="block text-gray-700 font-medium mb-2">Fecha</label>
                        <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                
                </div>
                <div class="space-y-4 ">
                    <div class="flex justify-center items-center ">
                        <button id="mostrarTablaBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                            Agregar venta
                        </button>
                    </div>
                </div>
                
            </div>
            <script>
                const productos = @json($productos);
                const envases = @json($envases);
            </script>
            <table  id="tabla" class="min-w-full divide-y divide-gray-200 mt-10 mb-10  hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 border">Productos</th>
                        <th class="px-4 py-2 border">Producto</th>
                        <th class="px-4 py-2 border">Cantidad</th>
                        <th class="px-4 py-2 border">Envases</th>
                        <th class="px-4 py-2 border">Cant. Envases</th>
                        <th class="px-4 py-2 border">Cant. Neto</th>
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
    let tablaMostrada = false;  // Para controlar si la tabla ha sido mostrada o no
    let index = 0;
    // Función para calcular el resultado de la multiplicación en cada fila
    function calcularResultado() {
        const filas = document.querySelectorAll('#tabla-jaulas tr');
        filas.forEach(fila => {
            const campoJaula = parseFloat(fila.querySelector('.campo-cantidad-neto').value) || 0;
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


    function cambiarPeso(event) {
        const select = event.target;
        const fila = select.closest('tr'); // Encuentra la fila correspondiente
        const envaseId = select.value;  // Obtén el ID del producto seleccionado
        
        // Buscar el producto seleccionado en el array
        const envaseSeleccionado = envases.find(envase => envase.id == envaseId);
        if (envaseSeleccionado) {
            // Actualiza el campo de precio
            const precioCelda = fila.querySelector('.peso_e');
            console.log(envaseSeleccionado);
            precioCelda.value = parseFloat(envaseSeleccionado.peso).toFixed(2); // Asigna el precio con 2 decimales
        }
    }
    
    function calcularNeto() {
        const filas = document.querySelectorAll('#tabla-jaulas tr');
        filas.forEach(fila => {
            const cantidad = parseFloat(fila.querySelector('.cantidad-jaula').value) || 0;
            const cantidadEnv = parseFloat(fila.querySelector('.cantidad_e').value) || 0;
            const peso = parseFloat(fila.querySelector('.peso_e').value) || 0;
            const resultado = cantidad -(cantidadEnv * peso);

            const netoCelda = fila.querySelector('.campo-cantidad-neto');
            netoCelda.value = parseFloat(resultado).toFixed(2); 
            calcularResultado()
        });
    }

    

    // Función para agregar una nueva fila con campos
    function agregarFila() {
        const tbody = document.getElementById('tabla-jaulas');
        const nuevaFila = document.createElement('tr');

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
        celdaNombre.innerHTML = `<input type="text" name="ventas[${index}][nombre]" class="nombre_p w-full text-center" placeholder="Nombre">`;

        const celdaEnvase = document.createElement('td');
        celdaEnvase.classList.add("text-center");
        celdaEnvase.innerHTML = `<select  class="celda_envase w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                       <option>Seleccione</option>
                        @foreach($envases as $envase)
                            <option value="{{ $envase->id }}">{{ $envase->nombre }}</option>
                        @endforeach
                    </select>`;
        const celdaCantidadEnv = document.createElement('td');
        celdaCantidadEnv.classList.add('text-center');
        celdaCantidadEnv.innerHTML = `<input type="number" name="ventas[${index}][cantidad_envase]" class="cantidad_e w-full text-center" value="0" step="0.01">`;

        const celdaPesoEnv = document.createElement('td');
        celdaPesoEnv.classList.add('hidden');
        celdaPesoEnv.innerHTML = `<input type="number" name="ventas[${index}][peso_envase]" class="peso_e w-full text-center" value="0" step="0.01">`;


        const celdaCantidad = document.createElement('td');
        celdaCantidad.classList.add('text-center');
        celdaCantidad.innerHTML = `<input type="number" name="ventas[${index}][cantidad_bruto]" class="cantidad-jaula w-full text-center" value="0" step="0.01">`;

        const celdaPrecio = document.createElement('td');
        celdaPrecio.classList.add('text-center');
        celdaPrecio.innerHTML = `<input type="number" name="ventas[${index}][precio]" class="precio-jaula w-full text-center" value="0" step="0.01">`;

        const celdaCantidadNeto = document.createElement('td');
        celdaCantidadNeto.classList.add('text-center');
        celdaCantidadNeto.innerHTML = `<input type="number" name="ventas[${index}][cantidad_neto]" class="campo-cantidad-neto w-full text-center" value="0" step="0.01" >`;

        const celdaResultado = document.createElement('td');
        celdaResultado.classList.add('text-center');
        celdaResultado.innerHTML = '<span class="resultado">0.00</span>';

        // Agregar las celdas a la nueva fila
        nuevaFila.appendChild(celdaProducto);   
        nuevaFila.appendChild(celdaNombre);
        nuevaFila.appendChild(celdaPesoEnv);
        nuevaFila.appendChild(celdaCantidad);
        nuevaFila.appendChild(celdaEnvase);
        nuevaFila.appendChild(celdaCantidadEnv);
        nuevaFila.appendChild(celdaCantidadNeto);
        nuevaFila.appendChild(celdaPrecio);
        nuevaFila.appendChild(celdaResultado);

        // Agregar la nueva fila al cuerpo de la tabla
        tbody.appendChild(nuevaFila);
        nuevaFila.querySelector('.campo-cantidad-neto').addEventListener('input', calcularResultado);
        nuevaFila.querySelector('.precio-jaula').addEventListener('input', calcularResultado);
        const selectProducto1 = celdaProducto.querySelector('select');
        selectProducto1.addEventListener('change', cambiarPrecio);
        nuevaFila.querySelector('.cantidad_e').addEventListener('input', calcularNeto);
        nuevaFila.querySelector('.cantidad-jaula').addEventListener('input', calcularNeto);
        const selectProducto2 = celdaEnvase.querySelector('select');
        selectProducto2.addEventListener('change', cambiarPeso);
        index++;
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
</body>
</html>
@endsection