<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Responsiva con Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Tabla Responsiva con Tailwind CSS</h1>
        
        <!-- Contenedor con scroll horizontal en dispositivos pequeños -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-800 font-medium">JD</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Juan Pérez</div>
                                    <div class="text-sm text-gray-500">ID: 12345</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">juan.perez@ejemplo.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Administrador</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-pink-100 flex items-center justify-center">
                                        <span class="text-pink-800 font-medium">ML</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">María López</div>
                                    <div class="text-sm text-gray-500">ID: 67890</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">maria.lopez@ejemplo.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Editor</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pendiente
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">CR</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Carlos Rodríguez</div>
                                    <div class="text-sm text-gray-500">ID: 54321</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">carlos.rodriguez@ejemplo.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Usuario</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Inactivo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Versión para dispositivos móviles (tarjetas en lugar de tabla) -->
        <div class="mt-4 block lg:hidden">
            <h2 class="text-lg font-semibold mb-2 text-gray-700">Vista móvil (tarjetas)</h2>
            <div class="space-y-4">
                <!-- Tarjeta 1 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-800 font-medium">JD</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Juan Pérez</h3>
                                <p class="text-sm text-gray-500">ID: 12345</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-b">
                        <div class="text-sm font-medium text-gray-500">Correo</div>
                        <div class="mt-1">juan.perez@ejemplo.com</div>
                    </div>
                    <div class="px-4 py-3 border-b">
                        <div class="text-sm font-medium text-gray-500">Rol</div>
                        <div class="mt-1">Administrador</div>
                    </div>
                    <div class="px-4 py-3 border-b">
                        <div class="text-sm font-medium text-gray-500">Estado</div>
                        <div class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                        </div>
                    </div>
                    <div class="px-4 py-3 flex justify-end">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                    </div>
                </div>
                
                <!-- Tarjeta 2 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Contenido similar al de la tarjeta 1 pero para María López -->
                    <div class="p-4 border-b">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-pink-100 flex items-center justify-center">
                                    <span class="text-pink-800 font-medium">ML</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">María López</h3>
                                <p class="text-sm text-gray-500">ID: 67890</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-b">
                        <div class="text-sm font-medium text-gray-500">Correo</div>
                        <div class="mt-1">maria.lopez@ejemplo.com</div>
                    </div>
                    <div class="px-4 py-3 border-b">
                        <div class="text-sm font-medium text-gray-500">Rol</div>
                        <div class="mt-1">Editor</div>
                    </div>
                    <div class="px-4 py-3 border-b">
                        <div class="text-sm font-medium text-gray-500">Estado</div>
                        <div class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pendiente
                            </span>
                        </div>
                    </div>
                    <div class="px-4 py-3 flex justify-end">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
