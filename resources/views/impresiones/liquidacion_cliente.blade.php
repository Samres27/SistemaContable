<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Liquidación</title>
    <style>
        /* Essential styles for mPDF */
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.5;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            width: 100%;
        }
        
        .card {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        /* Header Styles */
        .page-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        
        .page-header h1 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }
        
        /* Grid Layout - specifically for mPDF */
        .grid-container {
            width: 100%;
            display: table;
            table-layout: fixed;
        }
        
        .grid-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        /* Text Formatting */
        h4 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        
        p {
            margin: 3px 0;
        }
        
        strong {
            font-weight: bold;
        }
        
        /* Table Styles */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table.data-table th, 
        table.data-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        table.data-table thead {
            background-color: #f0f0f0;
        }
        
        /* Footer Totals */
        .total-container {
            text-align: right;
            padding: 10px;
            margin-top: 10px;
        }
        
        .total-label {
            font-weight: bold;
        }
        
        .total-value {
            margin-left: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="page-header">
                <h1>Detalles de Liquidación</h1>
            </div>
            
            <div class="grid-container">
                <div class="grid-column">
                    <div class="section">
                        <h4>Información General</h4>
                        <p><strong>Comprobante:</strong> {{ $liquidacion->comprobante }}</p>
                        <p><strong>Proveedor:</strong> {{ $liquidacion->proveedor->nombre }}</p>
                        <p><strong>Fecha:</strong> {{ $liquidacion->fecha }}</p>
                    </div>
                    <div class="section">
                        <h4>Detalles de Peso</h4>
                        <p><strong>Número de Pollos:</strong> {{ $liquidacion->nro_pollos }}</p>
                        <p><strong>Peso Bruto:</strong> {{ number_format($liquidacion->peso_bruto, 2) }} kg</p>
                        <p><strong>Peso Tara:</strong> {{ number_format($liquidacion->peso_tara, 2) }} kg</p>
                        <p><strong>Peso Neto:</strong> {{ number_format($liquidacion->peso_neto, 2) }} kg</p>
                    </div>
                </div>

                <div class="grid-column">
                    <div class="section">
                        <h4>Cálculos Adicionales</h4>
                        <p><strong>Porcentaje Descuento:</strong> {{ number_format($liquidacion->porcentaje_descuento, 2) }}%</p>
                        <p><strong>Peso Tiki/Buche:</strong> {{ number_format($liquidacion->peso_tiki_buche, 2) }} kg</p>
                        <p><strong>Modalidad Cálculo:</strong> 
                            {{ $liquidacion->modalidad_calculo == 'opcion1' 
                                ? 'Porcentaje de desc' 
                                : 'Descuento Tiki/Buche' }}
                        </p>
                    </div>
                    <div class="section">
                        <h4>Resultados Finales</h4>
                        <p><strong>Promedio Peso:</strong> {{ number_format($liquidacion->promedio_peso, 2) }} kg</p>
                        <p><strong>Peso Neto a Pagar:</strong> {{ number_format($liquidacion->peso_neto_pagar, 2) }} kg</p>
                        <p><strong>Precio:</strong> {{ number_format($liquidacion->precio, 2) }}</p>
                        <p><strong>Total:</strong> {{ number_format($liquidacion->total_sin_descuento, 2) }}</p>
                    </div>
                </div>
            </div>
            
            @if(count($descuentos) > 0)
            <table class="data-table" id="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($descuentos as $index => $descuento)
                        @if($descuento['total'] != 0)
                            <tr>
                                <td class="text-center">{{ $descuento['nombre_item'] }}</td>
                                <td class="text-center">{{ $descuento['cantidad'] }}</td>
                                <td class="text-center">{{ number_format($descuento['precio'], 2) }}</td>
                                <td class="text-center">{{ number_format($descuento['total'], 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @endif
            
            <div class="total-container">
                <span class="total-label">Total a Pagar:</span>
                <span class="total-value">{{ number_format($liquidacion->total_descuento, 2) }}</span>
            </div>
        </div>
    </div>
</body>
</html>