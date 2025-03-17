@props(['id', 'label'])

<label for="{{ $id }}" class="block text-gray-700 font-medium mb-2">{{ $label }}</label>
<input type="date" name="{{ $id }}" id="{{ $id }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request($id) }}">
