<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Clientes</title>
    <!-- Estilos CSS puros -->
    <style>
        /* Estilos generales */
        body {
            
            color: #1f2937;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            
        }
        
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        /* Estilos de la tabla */
        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
            font-size: 0.875rem;
        }
        
        tr {
            border-top: 1px solid #e5e7eb;
        }
        
        /* Sección de información adicional */
        .info-adicional {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .info-adicional p {
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        /* Paginación */
        .paginacion {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .paginacion p {
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Informe de Clientes</h1>

        <!-- Tabla de Clientes -->
        <table>
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Teléfono</th>
                    <th>Localización</th>
                    <th>Dirección</th>
                    <th>Ventas Realizadas</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nombre_completo }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->localizacion }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>{{ $cliente->ventasCount() }}</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>

        <!-- Información adicional -->
        <div class="info-adicional">
            <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Paginación (esto es solo informativo, no tiene efecto en el PDF) -->
        <div class="paginacion">
            <p>Página {{ $clientes->currentPage() }} de {{ $clientes->lastPage() }}</p>
        </div>
    </div>

</body>
</html>