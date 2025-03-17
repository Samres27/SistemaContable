@props(['route', 'object'])

<div class="space-x-3 "  role="group">
    
    <a href="{{ route($route.'.show', $object) }}" class="text-indigo-600 hover:text-indigo-900">
        Ver
    </a>
    <a href="{{ route($route.'.edit', $object) }}" class="text-yellow-600 hover:text-yellow-900">
        Editar
    </a>
    <form action="{{ route($route.'.destroy', $object) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">
            Eliminar
        </button>
    </form>
</div>
