@props(['object', 'value' => null, 'text_label', 'text_name','name'])

<div class="form-group">
    <label class="block text-gray-700 font-medium mb-2">{{$text_name}}</label>
    <select name="{{$name}}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @if(!$value)
            <option>{{$text_label}}</option>
        @endif
        @foreach($object as $proveedor)
            <option value="{{ $proveedor->id }}" {{ $value == $proveedor->id ? 'selected' : '' }}>
                {{ $proveedor->nombre }}
            </option>
        @endforeach
    </select>
</div>