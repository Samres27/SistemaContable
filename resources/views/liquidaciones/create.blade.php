@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Liquidación</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto max-w-4xl bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Nueva Liquidación</h1>
        
        <form method="POST" action="{{ route('liquidaciones.store') }}" >
            @csrf
            <div class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Proveedor</label>
                    <select name="proveedor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Seleccionar Proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Fecha</label>
                    <input type="date" name="fecha" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Nro Pollos</label>
                    <input type="number" name="nro_pollos" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Peso Bruto</label>
                    <input type="number" name="peso_bruto" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Peso Tara</label>
                    <input type="number" name="peso_tara" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                </div>
            
                <div class="space-y-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Porcentaje Descuento</label>
                    <input type="number" name="porcentaje_descuento" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Peso Tiki/Buche</label>
                    <input type="number" name="peso_tiki_buche" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Modalidad de Cálculo</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="radio" class="mr-2" name="modalidad_calculo" value="opcion1" checked>
                            <span>Opción 1: Peso Neto * (1-Descuento) - Tiki/Buche</span>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" class="mr-2" name="modalidad_calculo" value="opcion2">
                            <span>Opción 2: (Peso Neto - Tiki/Buche) * (1-Descuento)</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2">Precio</label>
                    <input type="number" name="precio" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-center items-center ">
                    <button id="mostrarTablaBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                        Agregar descuento
                    </button>
                </div>
                
                </div>
            </div>
            
            <table  id="tabla" class="min-w-full divide-y divide-gray-200 mt-10 mb-10  hidden">
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
                <button type="submit" class="w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Guardar Liquidación
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
        const celdaNombre = document.createElement('td');
        celdaNombre.classList.add('text-center');
        celdaNombre.innerHTML = `<input type="text" name="items[${index}][nombre_item]" class="w-full text-center" placeholder="Nombre Item">`;

        const celdaCantidad = document.createElement('td');
        celdaCantidad.classList.add('text-center');
        celdaCantidad.innerHTML = `<input type="number" name="items[${index}][cantidad]" class="campo-jaula w-full text-center" value="0">`;

        const celdaPrecio = document.createElement('td');
        celdaPrecio.classList.add('text-center');
        celdaPrecio.innerHTML = `<input type="number" name="items[${index}][precio]" class="precio-jaula w-full text-center" value="0" step="0.01">`;

        const celdaResultado = document.createElement('td');
        celdaResultado.classList.add('text-center');
        celdaResultado.innerHTML = '<span class="resultado">0.00</span>';

        // Agregar las celdas a la nueva fila
        nuevaFila.appendChild(celdaNombre);
        nuevaFila.appendChild(celdaCantidad);
        nuevaFila.appendChild(celdaPrecio);
        nuevaFila.appendChild(celdaResultado);

        // Agregar la nueva fila al cuerpo de la tabla
        tbody.appendChild(nuevaFila);
        nuevaFila.querySelector('.campo-jaula').addEventListener('input', calcularResultado);
        nuevaFila.querySelector('.precio-jaula').addEventListener('input', calcularResultado);
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