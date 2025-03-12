<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Boletas Pendientes</title>
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
            padding: 2rem 1rem;
        }
        
        /* Encabezados */
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        /* Información del cliente */
        .cliente-info {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
        }
        
        .cliente-info p {
            margin-bottom: 0.25rem;
        }
        
        .cliente-info strong {
            font-weight: 600;
            margin-right: 0.25rem;
        }
        
        /* Tabla */
        table {
            width: 100%;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }
        
        thead {
            background-color: #f3f4f6;
        }
        
        th {
            padding: 0.75rem 1.5rem;
            text-align: left;
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
        }
        
        td {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        /* Estados */
        .estado-pendiente {
            color: #ef4444;  /* Equivalente a text-red-500 */
        }
        
        .estado-cancelado {
            color: #10b981;  /* Equivalente a text-green-500 */
        }
        
        /* Cobros */
        .cobro-item {
            margin-bottom: 0.25rem;
        }
        
        /* Paginación */
        .paginacion {
            margin-top: 1.5rem;
            text-align: center;
        }

        /* Estilos de paginación simulados para Laravel */
        .paginacion ul {
            display: inline-flex;
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
        <h1>Boletas Pendientes</h1>
        
        <div class="cliente-info">
            <h2>Cliente: {{ $cliente->nombre }}</h2>
            <p><strong>Apellido:</strong> {{ $cliente->apellido }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
            <p><strong>Localizacion:</strong> {{ $cliente->localizacion }}</p>
            <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
        </div>
        
        <!-- Tabla de Boletas Pendientes -->
        <table>
            <thead>
                <tr>
                    <th>Comprobante</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Saldo Pendiente</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boletasPendientes as $boleta)
                    @if(! $boleta->calcularCancelacion())
                        <tr>
                            <td>{{ $boleta->comprobante }}</td>
                            <td>{{ $boleta->cliente->nombre_completo }}</td>
                            <td>{{ $boleta->fecha }}</td>
                            <td>{{ $boleta->calcularTotalSaldo() }}</td>
                            <td>
                                @if($boleta->calcularCancelacion())
                                    <span class="estado-cancelado">Cancelado</span>
                                @else
                                    <span class="estado-pendiente">Pendiente</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;">Total Deuda Pendiente:</td>
                        <td class="total-deuda">
                            @php
                                $totalDeuda = 0;
                                foreach($boletasPendientes as $boleta) {
                                    $totalPagado = $boleta->cobros ? $boleta->cobros->sum('monto') : 0;
                                    $saldoPendiente = $boleta->calcularTotalVenta() - $totalPagado;
                                    $totalDeuda += $saldoPendiente;
                                }
                            @endphp
                            {{ number_format($totalDeuda, 2) }} $
                        </td>
                    </tr>
            </tfoot>
        </table>

        <!-- Paginación -->
        <div class="paginacion">
            {{ $boletasPendientes->links() }}
        </div>
    </div>
</body>
</html>