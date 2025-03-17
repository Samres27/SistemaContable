@props(['value' => null, 'text','name'])

<div class="form-group">
    <label class="block text-gray-700 font-medium mb-2">{{$text}}</label>
    <input type="number" name="{{$name}}" step="0.01" value="{{ $value }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
</div>