@extends('layouts.app')

@section('title', 'Detalles del Producto')
@section('header-title', 'Detalles del Producto')

@section('content')
    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow-card animate-fadeIn text-white">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Detalles del Producto #{{ $product->id }}</h2>
            <a href="{{ route('products.index') }}" class="text-blue-400 hover:text-blue-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a Productos
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Información del Producto</h3>
                <p><strong>Código:</strong> {{ $product->code ?? 'Sin código' }}</p>
                <p><strong>Nombre:</strong> {{ $product->name }}</p>
                <p><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
                <p><strong>Stock:</strong> 
                    <span class="{{ $product->stock <= 10 ? 'text-red-500' : 'text-green-500' }} font-semibold">
                        {{ $product->stock }}
                    </span>
                    @if ($product->stock <= 10)
                        <span class="text-red-500 text-xs ml-2">(Stock bajo)</span>
                    @endif
                </p>
                <p><strong>Descripción:</strong> {{ $product->description ?? 'Sin descripción' }}</p>
            </div>

            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Imagen del Producto</h3>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg">
                @else
                    <p class="text-gray-400">No hay imagen disponible.</p>
                @endif
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <div></div>
            <div class="space-x-4">
                <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-all duration-300 flex items-center" onclick="return confirm('¿Estás seguro que deseas eliminar este producto?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection