<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BARUCK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Agregar el CDN de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head> 
<body>   
    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg">
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="name" id="name" placeholder="Enter your username"
                class="mt-2 w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password"
                class="mt-2 w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <button type="submit"
            class="w-full py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Login
        </button>

        
    </form>
</body>
