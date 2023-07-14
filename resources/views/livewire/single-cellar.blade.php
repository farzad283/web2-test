@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-4">{{ $cellar->name }}</h1>
    <h2 class="text-xl font-semibold mb-2">Bouteilles:</h2>
    <ul class="grid gap-4">
        @foreach($cellar->bottles as $bottle)
            <li class="bg-white p-4 shadow-md rounded-md flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ $bottle->url_image }}" alt="{{ $bottle->name }}" class="h-30 w-40 rounded-full">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $bottle->name }}</h3>
                        <p class="text-sm text-gray-500">Quantité: {{ $bottle->pivot->quantity }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button wire:click="increment" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                    <button wire:click="decrement" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
