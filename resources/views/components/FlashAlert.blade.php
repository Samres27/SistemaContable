@props(['type' => 'success'])

@if(session($type))
    <div class="p-4 mb-4 text-sm rounded-lg border-l-4
        @if($type === 'success') bg-green-100 text-green-800 border-green-500 
        @elseif($type === 'error') bg-red-100 text-red-800 border-red-500 
        @elseif($type === 'warning') bg-yellow-100 text-yellow-800 border-yellow-500 
        @elseif($type === 'info') bg-blue-100 text-blue-800 border-blue-500 
        @endif">
        <strong class="capitalize">{{ $type }}:</strong> {{ session($type) }}
    </div>
@endif
