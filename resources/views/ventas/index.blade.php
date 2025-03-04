{{-- resources/views/ventas/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de ventas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Listado de ventas</h1>
            <a href="{{ route('ventas.import.form') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Importar Excel
            </a>
        </div>
        
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Contenedor con scroll horizontal en dispositivos pequeños -->
        <div class="overflow-x-auto bg-white rounded-lg shadow hidden lg:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Num Reci</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ventas as $producto)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($producto->fecha)->format('Y-m-d') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $producto->nro_reci }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($producto->peso, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${{ number_format($producto->precio, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${{ number_format($producto->precio*$producto->peso, 2) }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No hay ventas disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Versión para dispositivos móviles (tarjetas en lugar de tabla) -->
        <div class="mt-4 block lg:hidden">
            <!-- <h2 class="text-lg font-semibold mb-2 text-gray-700">Vista móvil (tarjetas)</h2> -->
            <div class="space-y-4">
                @forelse($ventas as $producto)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-4 border-b">
                            <h3 class="text-lg font-medium text-gray-900">{{ $producto->nombre }}</h3>
                        </div>
                        <div class="px-4 py-3 border-b">
                            <div class="text-sm font-medium text-gray-500">Fecha</div>
                            <div class="mt-1">{{ \Carbon\Carbon::parse($producto->fecha)->format('Y-m-d') }}</div>
                        </div>
                        <div class="px-4 py-3 border-b">
                            <div class="text-sm font-medium text-gray-500">Nro Boleta</div>
                            <div class="mt-1">{{ $producto->nro_reci}}</div>
                        </div>
                        <div class="px-4 py-3 border-b">
                            <div class="text-sm font-medium text-gray-500">Peso</div>
                            <div class="mt-1">{{ number_format($producto->peso, 2) }}</div>
                        </div>
                        <div class="px-4 py-3 border-b">
                            <div class="text-sm font-medium text-gray-500">Precio</div>
                            <div class="mt-1">${{ number_format($producto->precio, 2) }}</div>
                        </div>
                        <div class="px-4 py-3 border-b">
                            <div class="text-sm font-medium text-gray-500">Monto</div>
                            <div class="mt-1">${{ number_format($producto->precio * $producto->peso, 2) }}</div>
                        </div>
                        <div class="px-4 py-3 flex justify-end">
                            <a href="{{ route('ventas.edit', $producto->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <form class="inline" action="{{ route('ventas.destroy', $producto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                        No hay ventas disponibles
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Paginación -->
        @if(isset($ventas) && method_exists($ventas, 'links'))
            <div class="mt-4">
                {{ $ventas->links() }}
            </div>
        @endif
    </div>
</body>
</html>