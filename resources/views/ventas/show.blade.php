@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Detalles de Venta</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Información General</h4>
                    <p><strong>Comprobante:</strong> {{ $boleta->comprobante }}</p>
                    <p><strong>Proveedor:</strong> {{ $boleta->cliente->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $boleta->fecha }}</p>
                </div>
            </div>

            
        </div>
        <script>
            const ventas = @json($ventas);
        </script>
        <table  id="tabla" class="min-w-full divide-y divide-gray-200 mt-10 mb-10  ">
            
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 border">Nombre</th>
                        <th class="px-4 py-2 border">Cantidad_bruto</th>
                        <th class="px-4 py-2 border">Cantidad_neto</th>
                        <th class="px-4 py-2 border">Precio</th>
                        <th class="px-4 py-2 border">Total</th>
                    </tr>
                </thead>
                <tbody id="tabla-jaulas" class="bg-white divide-y divide-gray-200">
          
                    
                </tbody>
            </table>
            <div class="flex justify-end p-4">
            <div class=" rounded-lg">
                <span ><strong>Total a Pagar:</strong></span>
                <span id="total-pagar" class="ml-2 text-xl">{{ number_format($boleta->total, 2) }}</span>
            </div>
        </div>

    </div>
</div>
<script>
    
    const tabla = document.getElementById('tabla');
    const tbody = tabla.querySelector('tbody');
    let hayDescuentosConMonto = false;
    
    ventas.forEach((venta, index) => {
        
            
                hayDescuentosConMonto = true;
                indexGuardado = index+1;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="hidden">
                        <input type="text" name="items[${index}][id]" class="w-full text-center" value="${venta.id}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="text" name="items[${index}][nombre]" class="w-full text-center" value="${venta.nombre}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][cantidad]" class="campo-jaula w-full text-center" value="${venta.cantidad_bruto}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][cantidad]" class="campo-jaula w-full text-center" value="${venta.cantidad_neto}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][precio]" class="precio-jaula w-full text-center" value="${venta.precio}" readonly step="0.01">
                    </td>
                    <td class="text-center">
                        <span class="resultado">${venta.total}</span>
                    </td>
                `;
                tbody.appendChild(row);
                
        
            
    });
    document.addEventListener('DOMContentLoaded', function() {
        if(descuentos.length > 0){tabla.classList.remove('hidden');}
    });
</script>
@endsection