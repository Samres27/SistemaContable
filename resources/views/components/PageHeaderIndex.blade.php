@props(['title', 'buttonRoute' => null, 'buttonText' => null])

<div class="row mb-3">
    <div class="col-md-10">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ $title }}</h1>
    </div>
    @if($buttonRoute)
    <div class="col-md-2 text-right mb-10">
        <a href="{{ $buttonRoute }}" class="m-3 p-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
            {{ $buttonText }}
        </a>
    </div>
    @endif
</div>