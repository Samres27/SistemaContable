<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pagos y Liquidaciones - {{ $proveedor->nombre }}</title>
    <!-- Estilos de TailwindCSS -->
    <style>
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

    h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    h3 {
        font-size: 1.125rem;
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
        background-color: #ffffff;
    }

    .proveedor-info p {
        margin-bottom: 0.25rem;
    }

    .proveedor-info strong {
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
        margin-bottom: 2rem;
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
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold text-center mb-6">Historial de Pagos</h1>

        
        <div class="mb-6 p-4 border rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-2">Proveedor: {{ $proveedor->nombre }}</h2>
            <p><strong>Alias:</strong> {{ $proveedor->alias }}</p>
            <p><strong>Teléfono:</strong> {{ $proveedor->telefono }}</p>
            <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
        </div>  
        <!-- Historial de Pagos -->
        <h3 class="text-lg font-semibold mb-2">Pagos Realizados</h3>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mb-8">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Fecha de Pago</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Monto</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Método de Pago</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Comprobante</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Saldo</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Liquidación</th>
                </tr>
            </thead>
            <tbody>
            @foreach($proveedor->liquidaciones as $liquidacion)
                @foreach($liquidacion->pagos as $pago)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $pago->montoFormateado }}</td>
                        <td class="px-6 py-4">{{ $pago->metodo_pago }}</td>
                        <td class="px-6 py-4">{{ $pago->comprobante }}</td>
                        <td class="px-6 py-4">{{ $pago->saldo }}</td>
                        <td class="px-6 py-4">
                            @if($liquidacion)
                                {{ $liquidacion->comprobante }}
                            @else
                                No asociado
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>

        <!-- Paginación (si es necesario) -->
        <div class="mt-6 text-center">
            {{ $liquidaciones->links() }}
        </div>
    </div>

</body>
</html>
