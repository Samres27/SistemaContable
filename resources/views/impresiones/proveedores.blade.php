<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
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
            background-color: #f9fafb;
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
        
        tr:hover {
            background-color: #f9fafb;
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
        <h1>Listado de Proveedores</h1>

        <!-- Tabla de Proveedores -->
        <table>
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Tipo de Liquidación</th>
                    <th>Total Liquidaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombreCompleto }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>{{ $proveedor->tipo_liquidacion }}</td>
                        <td>{{ $proveedor->totalLiquidaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="paginacion">
            {{ $proveedores->links() }}
        </div>
    </div>
</body>
</html>