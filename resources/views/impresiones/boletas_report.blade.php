<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Boletas</title>
    <!-- Estilos Tailwind CSS -->
    <style>
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold text-center mb-6">Informe de Boletas</h1>

        <!-- Tabla de Boletas -->
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Comprobante</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Cliente</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Fecha</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Ventas</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Cobros</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Saldo Pendiente</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 bg-gray-100">Cancelada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boletas as $boleta)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $boleta->comprobante }}</td>
                        <td class="px-6 py-4">{{ $boleta->cliente->nombre_completo }}</td>
                        <td class="px-6 py-4">{{ $boleta->fecha->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $boleta->calcularTotalVenta() }}</td>
                        <td class="px-6 py-4">{{ $boleta->calcularTotalCobro() }}</td>
                        <td class="px-6 py-4">{{ $boleta->calcularTotalSaldo() }}</td>
                        <td class="px-6 py-4">{{ $boleta->calcularCancelacion() ? 'Sí' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Información adicional -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Paginación (esto es solo informativo, no tiene efecto en el PDF) -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
               {{-- Página {{ $boletas->currentPage() }} de {{ $boletas->lastPage() }} --}}
            </p>
        </div>
    </div>

</body>
</html>
