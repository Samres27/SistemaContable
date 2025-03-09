@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Detalles de Liquidación</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Información General</h4>
                    <p><strong>Comprobante:</strong> {{ $liquidacion->comprobante }}</p>
                    <p><strong>Proveedor:</strong> {{ $liquidacion->proveedor->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $liquidacion->fecha }}</p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Detalles de Peso</h4>
                    <p><strong>Número de Pollos:</strong> {{ $liquidacion->nro_pollos }}</p>
                    <p><strong>Peso Bruto:</strong> {{ number_format($liquidacion->peso_bruto, 2) }} kg</p>
                    <p><strong>Peso Tara:</strong> {{ number_format($liquidacion->peso_tara, 2) }} kg</p>
                    <p><strong>Peso Neto:</strong> {{ number_format($liquidacion->peso_neto, 2) }} kg</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Cálculos Adicionales</h4>
                    <p><strong>Porcentaje Descuento:</strong> {{ number_format($liquidacion->porcentaje_descuento, 2) }}%</p>
                    <p><strong>Peso Tiki/Buche:</strong> {{ number_format($liquidacion->peso_tiki_buche, 2) }} kg</p>
                    <p><strong>Modalidad Cálculo:</strong> 
                        {{ $liquidacion->modalidad_calculo == 'opcion1' 
                            ? 'Porcentaje de descuento' 
                            : 'Descuento Tiki/Buche' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-xl font-bold mb-6 text-gray-800">Resultados Finales</h4>
                    <p><strong>Promedio Peso:</strong> {{ number_format($liquidacion->promedio_peso, 2) }} kg</p>
                    <p><strong>Peso Neto a Pagar:</strong> {{ number_format($liquidacion->peso_neto_pagar, 2) }} kg</p>
                    <p><strong>Precio:</strong> {{ number_format($liquidacion->precio, 2) }}</p>
                    <p><strong>Total:</strong> {{ number_format($liquidacion->total_sin_descuento, 2) }}</p>
                </div>
            </div>
        </div>
        <script>
            const descuentos = @json($descuentos);
        </script>
        <table  id="tabla" class="min-w-full divide-y divide-gray-200 mt-10 mb-10  hidden">
            
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 border">Nombre</th>
                        <th class="px-4 py-2 border">Cantidad</th>
                        <th class="px-4 py-2 border">Precio</th>
                        <th class="px-4 py-2 border">Resultado</th>
                    </tr>
                </thead>
                <tbody id="tabla-jaulas" class="bg-white divide-y divide-gray-200">
          
                    
                </tbody>
            </table>
            <div class="flex justify-end p-4">
            <div class=" rounded-lg">
                <span ><strong>Total a Pagar:</strong></span>
                <span id="total-pagar" class="ml-2 text-xl">{{ number_format($liquidacion->total_descuento, 2) }}</span>
            </div>
        </div>

    </div>
</div>
<script>
    
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
                        <input type="text" name="items[${index}][nombre_item]" class="w-full text-center" value="${descuento.nombre_item}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][cantidad]" class="campo-jaula w-full text-center" value="${descuento.cantidad}" readonly>
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][precio]" class="precio-jaula w-full text-center" value="${descuento.precio}" readonly step="0.01">
                    </td>
                    <td class="text-center">
                        <span class="resultado">${descuento.total}</span>
                    </td>
                `;
                tbody.appendChild(row);
                
        
            }
    });
    document.addEventListener('DOMContentLoaded', function() {
        if(descuentos.length > 0){tabla.classList.remove('hidden');}
    });
</script>
@endsection