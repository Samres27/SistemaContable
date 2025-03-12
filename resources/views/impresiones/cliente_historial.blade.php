<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Boletas y Cobros</title>
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
            font-weight: 200;
            color: #4b5563;
        }
        
        td {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            font-size: 0.75rem;
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
        
        /* Estilos para los cobros */
        .cobro-item {
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Historial de Boletas y Cobros</h1>

        <div class="cliente-info">
            <h2>Cliente: {{ $cliente->nombre }}</h2>
            <p><strong>Apellido:</strong> {{ $cliente->apellido }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
            <p><strong>Localizacion:</strong> {{ $cliente->localizacion }}</p>
            <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
        </div> 

        <!-- Tabla de Boletas -->
        <table>
            <thead>
                <tr>
                    <th>Comprobante</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Ventas</th>
                    <th>Cobros</th>
                    <th>Saldo Pendiente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boletas as $boleta)
                    <tr>
                        <td>{{ $boleta->comprobante }}</td>
                        <td>{{ $boleta->cliente->nombre_completo }}</td>
                        <td>{{ $boleta->fecha }}</td>
                        <td>{{ $boleta->calcularTotalVenta() }}</td>
                        <td>
                            @foreach($boleta->cobros as $cobro)
                                <div class="cobro-item">
                                    {{ $cobro->monto }} ({{ $cobro->fecha }})
                                </div>
                            @endforeach
                        </td>
                        <td>{{ $boleta->calcularTotalSaldo() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="paginacion">
            {{ $boletas->links() }}
        </div>
    </div>
</body>
</html>
