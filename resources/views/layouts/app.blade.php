<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' | ' : '' }}Sistema de Liquidaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Agregar el CDN de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100">
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-evenly h-16 text-center"> <!-- Cambié justify-between por justify-evenly -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <!-- Aquí puedes poner un logo o algo que prefieras -->
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('proveedores.index') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Proveedores
                    </a>
                    <a href="{{ route('liquidaciones.index_all') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Liquidaciones
                    </a>
                    <a href="{{ route('pagos.index') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Pagos a Proveedores
                    </a>
                    <div class='w-1/8'></div>
                    <a href="{{ route('clientes.index') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Clientes
                    </a>
                    <a href="{{ route('ventas.index_all') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Ventas
                    </a>
                    <a href="{{ route('productos.index') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Productos
                    </a>
                    <a href="{{ route('envases.index') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Envases
                    </a>
                    <a href="{{ route('cobros.index') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium m-auto">
                        Cobros a clientes
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>


    <main class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            @yield('content')
        </div>
    </main>
</body>
</html>
