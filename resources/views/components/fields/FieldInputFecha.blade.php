@props(['value' => null,'name'=>'fecha'])

<div class="form-group">
    <label class="block text-gray-700 font-medium mb-2">Fecha</label>
    <input type="date" name="{{$name}}" value="{{ $value }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
</div>