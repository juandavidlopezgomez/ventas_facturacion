@extends('layouts.app')

@section('title', 'Crear Producto')
@section('header-title', 'Crear Nuevo Producto')

@section('content')
    <div class="max-w-2xl mx-auto bg-card p-6 rounded-lg shadow-card animate-fadeIn">
        <h2 class="text-2xl font-bold mb-6">Nuevo Producto</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-product">
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium mb-1">Código</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" required>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium mb-1">Descripción</label>
                    <textarea name="description" id="description" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium mb-1">Precio</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium mb-1">Stock</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" required>
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium mb-1">Categoría</label>
                    <select name="category_id" id="category_id" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" required>
                        <option value="" disabled {{ old('category_id') === null ? 'selected' : '' }}>Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="supplier_id" class="block text-sm font-medium mb-1">Proveedor</label>
                    <select name="supplier_id" id="supplier_id" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" required>
                        <option value="" disabled {{ old('supplier_id') === null ? 'selected' : '' }}>Selecciona un proveedor</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="expiration_date" class="block text-sm font-medium mb-1">Fecha de Expiración</label>
                    <input type="date" name="expiration_date" id="expiration_date" value="{{ old('expiration_date') }}" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800 cursor-pointer">
                    @error('expiration_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium mb-1">Estado</label>
                    <select name="status" id="status" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800" required>
                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium mb-1">Imagen</label>
                    <input type="file" name="image" id="image" class="w-full p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-all duration-300">Crear Producto</button>
            </div>
        </form>
    </div>
@endsection