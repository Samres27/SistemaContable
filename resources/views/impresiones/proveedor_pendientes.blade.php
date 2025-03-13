

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pagos y Liquidaciones - {{ $proveedor->nombre }}</title>
    <!-- Estilos CSS puros -->
    <style>
        /* Reset y estilos básicos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            color: #1f2937;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }
        
        /* Encabezados */
        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        /* Información del proveedor */
        .proveedor-info {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        .proveedor-info p {
            margin-bottom: 0.25rem;
        }
        
        .proveedor-info strong {
            font-weight: 600;
        }
        
        /* Tabla */
        .tabla-container {
            overflow-x: auto;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background-color: #f3f4f6;
        }
        
        th, td {
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
            text-align: left;
        }
        
        tbody tr:hover {
            background-color: #f9fafb;
        }
        
        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .text-red {
            color: #ef4444;
        }
        
        .text-green {
            color: #10b981;
        }
        
        /* Totales */
        tfoot {
            font-weight: bold;
            background-color: #f3f4f6;
        }
        
        tfoot td {
            border-top: 2px solid #d1d5db;
        }
        
        .total-deuda {
            font-size: 1.1rem;
            color: #ef4444;
        }
        
        /* Paginación */
        .paginacion {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }

        /* Estilos de paginación simulados para Laravel */
        .paginacion ul {
            display: flex;
            list-style: none;
        }
        
        .paginacion li {
            margin: 0 0.25rem;
        }
        
        .paginacion a, .paginacion span {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            color: #1f2937;
            text-decoration: none;
        }
        
        .paginacion a:hover {
            background-color: #f3f4f6;
        }
        
        .paginacion .active span {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Liquidaciones Pendientes de Pago</h1>
        
        <!-- Información del proveedor -->
        <div class="proveedor-info">
            <h2>Proveedor: {{ $proveedor->nombre }}</h2>
            <p><strong>Alias:</strong> {{ $proveedor->alias }}</p>
            <p><strong>Teléfono:</strong> {{ $proveedor->telefono }}</p>
            <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
            <p><strong>Total de Liquidaciones Pendientes:</strong> {{ $liquidacionesPendientes->total() }}</p>
        </div>
        
        <!-- Tabla de Liquidaciones Pendientes -->
        <div class="tabla-container">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Comprobante</th>
                        <th>Peso Neto</th>
                        <th>Total Descuento</th>
                        <th>Total Pagado</th>
                        <th>Saldo Pendiente</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($liquidacionesPendientes as $liquidacion)
                        @php
                            $totalPagado = $liquidacion->pagos->sum('monto');
                            $saldoPendiente = $liquidacion->calcularTotalDescuento() - $totalPagado;
                        @endphp
                        <tr>
                            <td>{{ $liquidacion->fecha }}</td>
                            <td>{{ $liquidacion->comprobante }}</td>
                            <td>{{ number_format($liquidacion->calcularPesoNeto(), 2) }} kg</td>
                            <td>{{ number_format($liquidacion->calcularTotalDescuento(), 2) }} $</td>
                            <td>{{ number_format($totalPagado, 2) }} $</td>
                            <td class="{{ $saldoPendiente > 0 ? 'text-red' : 'text-green' }}">
                                {{ number_format($saldoPendiente, 2) }} $
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right;">Total Deuda Pendiente:</td>
                        <td class="total-deuda">
                            @php
                                $totalDeuda = 0;
                                foreach($liquidacionesPendientes as $liquidacion) {
                                    $totalPagado = $liquidacion->pagos ? $liquidacion->pagos->sum('monto') : 0;
                                    $saldoPendiente = $liquidacion->calcularTotalDescuento() - $totalPagado;
                                    $totalDeuda += $saldoPendiente;
                                }
                            @endphp
                            {{ number_format($totalDeuda, 2) }} $
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Paginación -->
        <div class="paginacion">
            {{ $liquidacionesPendientes->links() }}
        </div>
    </div>
</body>
</html>