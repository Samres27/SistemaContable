{{-- resources/views/ventas/import.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar ventas desde Excel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Importar ventas desde Excel</h1>
        
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('ventas.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="archivo" class="block text-sm font-medium text-gray-700 mb-2">
                        Seleccionar archivo Excel (.xlsx, .xls, .csv)
                    </label>
                    <input type="file" id="archivo" name="archivo" accept=".xlsx,.xls,.csv" 
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100">
                    <p class="mt-1 text-sm text-gray-500">
                        El archivo debe tener columnas: fecha, nro_rec, nombre, peso, precio, monto
                    </p>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Importar Datos
                    </button>
                    <a href="{{ route('ventas.index') }}" class="text-blue-500 hover:text-blue-700">
                        Volver a la lista
                    </a>
                </div>
            </form>
            
            <div class="mt-8 p-4 border border-gray-200 rounded-md">
                <h2 class="text-lg font-semibold mb-2">Formato esperado del Excel</h2>
                <p class="mb-2 text-sm text-gray-600">Tu archivo Excel debe tener las siguientes columnas:</p>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">fecha</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">nro_rec</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">peso</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">precio</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">monto</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">27/09/2023</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">0023409</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Producto A</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">10.5</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">25.99</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">5.00</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">12/06/2024</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">0093904</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Producto B</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">5.2</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">15.75</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>