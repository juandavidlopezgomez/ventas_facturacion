@extends('layouts.app')

@section('title', 'Editar Producto')
@section('header-title', 'Editar Producto')

@section('content')
    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow-card animate-fadeIn text-white">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Editar Producto #{{ $product->id }}</h2>
            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Ver detalles
            </a>
        </div>
        
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1 text-gray-300">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Nombre del producto" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="code" class="block text-sm font-medium mb-1 text-gray-300">Código <span class="text-red-500">*</span></label>
                        <input type="text" name="code" id="code" value="{{ old('code', $product->code) }}" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Código único" required>
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium mb-1 text-gray-300">Precio ($) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="0.00" required>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium mb-1 text-gray-300">Stock <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $product->stock) }}" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Cantidad en stock" required>
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium mb-1 text-gray-300">Descripción</label>
                    <textarea name="description" id="description" rows="4" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Descripción del producto">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium mb-1 text-gray-300">Imagen del Producto (Opcional)</label>
                    <input type="file" name="image" id="image" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700">
                    @if ($product->image)
                        <p class="text-gray-400 text-sm mt-2">Imagen actual: <a href="{{ asset('storage/' . $product->image) }}" target="_blank" class="text-blue-400 hover:text-blue-600">Ver imagen</a></p>
                    @endif
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-all duration-300">Cancelar</a>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-all duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
@endsection