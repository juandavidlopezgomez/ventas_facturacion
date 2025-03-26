@extends('layouts.app')

@section('title', 'Productos')
@section('header-title', 'Gestión de Productos')

@section('content')
    <div class="grid grid-cols-1 gap-6">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('products.index') }}" method="GET" class="flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o código..." class="p-2 border border-accent rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="bg-green-500 text-white p-2 rounded-r-lg hover:bg-green-600 transition-all duration-300">Buscar</button>
            </form>
            <a href="{{ route('products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 animate-fadeIn">Nuevo Producto</a>
        </div>

        <div class="bg-card rounded-lg p-6 shadow-card animate-fadeIn">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table-product">
                <thead>
                    <tr class="border-b border-accent">
                        <th class="py-2">Imagen</th>
                        <th class="py-2">Código</th>
                        <th class="py-2">Nombre</th>
                        <th class="py-2">Descripción</th>
                        <th class="py-2">Precio</th>
                        <th class="py-2">Stock</th>
                        <th class="py-2">Categoría</th>
                        <th class="py-2">Proveedor</th>
                        <th class="py-2">Estado</th>
                        <th class="py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-b border-accent hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                            <td class="py-2">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded" onerror="this.src='{{ asset('images/default-product.png') }}';">
                            </td>
                            <td class="py-2">{{ $product->code }}</td>
                            <td class="py-2">{{ $product->name }}</td>
                            <td class="py-2">{{ $product->description ?? 'N/A' }}</td>
                            <td class="py-2">${{ number_format($product->price, 2) }}</td>
                            <td class="py-2">{{ $product->stock }}</td>
                            <td class="py-2">{{ $product->category->name ?? 'Sin categoría' }}</td>
                            <td class="py-2">{{ $product->supplier->name ?? 'Sin proveedor' }}</td>
                            <td class="py-2">{{ $product->status ? 'Activo' : 'Inactivo' }}</td>
                            <td class="py-2">
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-2">Editar</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-4 text-center">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
@endsection