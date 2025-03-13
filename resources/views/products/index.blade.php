@extends('layouts.app')

@section('title', 'Productos')
@section('header-title', 'Gestión de Productos')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header section with stats overview -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Gestión de Productos</h1>
                <p class="text-gray-500 mt-1">Administra tu inventario de productos de manera eficiente</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full md:w-auto">
                <div class="bg-green-50 rounded-lg p-4 text-center border-l-4 border-green-500 shadow-sm">
                    <span class="text-sm font-medium text-gray-600">Total Productos</span>
                    <p class="text-2xl font-bold text-green-600">{{ $products->total() }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center border-l-4 border-green-500 shadow-sm">
                    <span class="text-sm font-medium text-gray-600">Stock Total</span>
                    <p class="text-2xl font-bold text-green-600">{{ $products->sum('stock') }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center border-l-4 border-green-500 shadow-sm">
                    <span class="text-sm font-medium text-gray-600">Valor Inventario</span>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($products->sum(function($product) { return $product->price * $product->stock; }), 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium">Productos Activos</h3>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-baseline">
                <span class="text-3xl font-bold text-gray-800">{{ $products->where('status', 1)->count() }}</span>
                <span class="ml-2 text-sm text-green-500 font-medium">+{{ number_format(($products->where('status', 1)->count() / $products->total()) * 100, 1) }}%</span>
            </div>
            <div class="mt-4 h-16">
                <canvas id="activeProductsChart" class="w-full h-full"></canvas>
            </div>
            <div class="mt-2 flex justify-between items-center text-xs text-gray-500">
                <span>Este año</span>
                <select class="text-xs border-0 bg-transparent text-gray-500 cursor-pointer focus:outline-none focus:ring-0">
                    <option>Año</option>
                    <option>Mes</option>
                    <option>Semana</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium">Categorías</h3>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-baseline">
                <span class="text-3xl font-bold text-gray-800">{{ isset($categories) ? $categories->count() : 0 }}</span>
                <span class="ml-2 text-sm text-green-500 font-medium">+12.5%</span>
            </div>
            <div class="mt-4 h-16">
                <canvas id="categoriesChart" class="w-full h-full"></canvas>
            </div>
            <div class="mt-2 flex justify-between items-center text-xs text-gray-500">
                <span>Este mes</span>
                <select class="text-xs border-0 bg-transparent text-gray-500 cursor-pointer focus:outline-none focus:ring-0">
                    <option>Mes</option>
                    <option>Año</option>
                    <option>Semana</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium">Ingresos</h3>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-baseline">
                <span class="text-3xl font-bold text-gray-800">${{ number_format($products->sum(function($product) { return $product->price * $product->stock; }), 0) }}</span>
                <span class="ml-2 text-sm text-green-500 font-medium">+8.2%</span>
            </div>
            <div class="mt-4 h-16">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
            <div class="mt-2 flex justify-between items-center text-xs text-gray-500">
                <span>Este mes</span>
                <select class="text-xs border-0 bg-transparent text-gray-500 cursor-pointer focus:outline-none focus:ring-0">
                    <option>Semana</option>
                    <option>Año</option>
                    <option>Mes</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium">Stock Bajo</h3>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-baseline">
                <span class="text-3xl font-bold text-gray-800">{{ $products->where('stock', '<', 10)->where('stock', '>', 0)->count() }}</span>
                <span class="ml-2 text-sm text-yellow-500 font-medium">{{ number_format(($products->where('stock', '<', 10)->where('stock', '>', 0)->count() / $products->total()) * 100, 1) }}%</span>
            </div>
            <div class="mt-4 h-16">
                <canvas id="lowStockChart" class="w-full h-full"></canvas>
            </div>
            <div class="mt-2 flex justify-between items-center text-xs text-gray-500">
                <span>Esta semana</span>
                <select class="text-xs border-0 bg-transparent text-gray-500 cursor-pointer focus:outline-none focus:ring-0">
                    <option>Semana</option>
                    <option>Año</option>
                    <option>Mes</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Filters and actions toolbar -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="w-full md:w-1/2">
                <form action="{{ route('products.index') }}" method="GET" class="flex">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o código..." class="pl-10 w-full p-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-3 rounded-r-lg hover:bg-green-600 transition-all duration-300 flex items-center">
                        <span>Buscar</span>
                    </button>
                </form>
            </div>
            
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <div class="relative">
                    <select name="category_filter" id="category_filter" class="pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700 bg-white cursor-pointer">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category_filter') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="relative">
                    <select name="status_filter" id="status_filter" class="pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700 bg-white cursor-pointer">
                        <option value="">Todos los estados</option>
                        <option value="1" {{ request('status_filter') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('status_filter') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                
                <a href="{{ route('products.create') }}" class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nuevo Producto
                </a>
                
                <button id="exportBtn" class="bg-green-500 text-white px-3 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Exportar
                </button>
            </div>
        </div>
    </div>

    <!-- Notification area -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Products table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Código
                                <a href="{{ route('products.index', ['sort' => 'code', 'direction' => 'asc']) }}" class="ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Nombre
                                <a href="{{ route('products.index', ['sort' => 'name', 'direction' => 'asc']) }}" class="ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Precio
                                <a href="{{ route('products.index', ['sort' => 'price', 'direction' => 'asc']) }}" class="ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Stock
                                <a href="{{ route('products.index', ['sort' => 'stock', 'direction' => 'asc']) }}" class="ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="group relative">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200 cursor-pointer" onerror="this.src='{{ asset('images/default-product.png') }}';" onclick="openImageModal('{{ $product->image_url ? $product->image_url : asset('images/default-product.png') }}', '{{ $product->name }}')">
                                    <div class="absolute bottom-0 right-0 bg-green-500 text-white text-xs px-1 rounded-bl opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        Ver
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-medium">{{ $product->code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 truncate max-w-xs" title="{{ $product->description }}">
                                    {{ $product->description ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock > 10)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $product->stock }}
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $product->stock }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($product->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Sin categoría</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->supplier->name ?? 'Sin proveedor' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->status)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.show', $product) }}" class="text-gray-500 hover:text-green-600" title="Ver detalles">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-green-600" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button onclick="confirmDelete('{{ route('products.destroy', $product) }}', '{{ $product->name }}')" class="text-red-500 hover:text-red-700" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">No hay productos registrados</p>
                                    <a href="{{ route('products.create') }}" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 shadow-sm">
                                        Crear tu primer producto
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

    <!-- Activity Timeline Section -->
    <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Actividad Reciente</h2>
            <a href="#" class="text-green-500 hover:text-green-600 text-sm font-medium">Ver todo</a>
        </div>
        
        <div class="space-y-6">
            <div class="relative pl-8 pb-6 border-l-2 border-green-200">
                <div class="absolute -left-2 top-0">
                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                </div>
                <div class="flex items-center text-sm mb-1">
                    <span class="font-medium text-gray-900">Producto añadido</span>
                    <span class="ml-auto text-gray-500">Hace 2 horas</span>
                </div>
                <p class="text-gray-600 text-sm">Se ha añadido un nuevo producto: <span class="font-medium">Teclado Mecánico RGB</span></p>
            </div>
            
            <div class="relative pl-8 pb-6 border-l-2 border-blue-200">
                <div class="absolute -left-2 top-0">
                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                </div>
                <div class="flex items-center text-sm mb-1">
                    <span class="font-medium text-gray-900">Stock actualizado</span>
                    <span class="ml-auto text-gray-500">Hace 5 horas</span>
                </div>
                <p class="text-gray-600 text-sm">Se actualizó el stock de <span class="font-medium">Monitor UltraWide 34"</span> de 5 a 15 unidades</p>
            </div>
            
            <div class="relative pl-8 pb-6 border-l-2 border-yellow-200">
                <div class="absolute -left-2 top-0">
                    <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                </div>
                <div class="flex items-center text-sm mb-1">
                    <span class="font-medium text-gray-900">Precio modificado</span>
                    <span class="ml-auto text-gray-500">Ayer</span>
                </div>
                <p class="text-gray-600 text-sm">El precio de <span class="font-medium">Auriculares Inalámbricos</span> cambió de $89.99 a $79.99</p>
            </div>
            
            <div class="relative pl-8 border-l-2 border-red-200">
                <div class="absolute -left-2 top-0">
                    <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                </div>
                <div class="flex items-center text-sm mb-1">
                    <span class="font-medium text-gray-900">Producto eliminado</span>
                    <span class="ml-auto text-gray-500">Hace 2 días</span>
                </div>
                <p class="text-gray-600 text-sm">Se eliminó el producto <span class="font-medium">Webcam HD 1080p</span> del inventario</p>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden animate-fadeIn">
    <div class="bg-white rounded-lg p-6 max-w-2xl max-h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 id="imageModalTitle" class="text-xl font-medium text-gray-900"></h3>
            <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="relative">
            <img id="modalImage" src="" alt="Vista previa" class="max-h-[70vh] mx-auto">
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden animate-fadeIn">
    <div class="bg-white rounded-lg p-6 max-w-md mx-auto">
        <div class="flex items-start mb-4">
            <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-medium text-gray-900">Confirmar eliminación</h3>
                <p class="mt-2 text-sm text-gray-500">¿Estás seguro de que deseas eliminar <span id="deleteProductName" class="font-medium"></span>? Esta acción no se puede deshacer.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50">
                Cancelar
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Export Options Modal -->
<div id="exportModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden animate-fadeIn">
    <div class="bg-white rounded-lg p-6 max-w-md mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Exportar Productos</h3>
            <button type="button" onclick="closeExportModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            Selecciona el formato en el que deseas exportar la lista de productos.
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('products.export', ['format' => 'excel']) }}" class="block bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition-all duration-200 mb-2 text-center">
                <div class="flex items-center justify-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exportar a Excel
                </div>
            </a>
            <a href="{{ route('products.export', ['format' => 'pdf']) }}" class="block bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition-all duration-200 mb-2 text-center">
                <div class="flex items-center justify-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Exportar a PDF
                </div>
            </a>
            <a href="{{ route('products.export', ['format' => 'csv']) }}" class="block bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition-all duration-200 text-center">
                <div class="flex items-center justify-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Exportar a CSV
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Quick Add Product Modal -->
<div id="quickAddModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden animate-fadeIn">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">Añadir Producto Rápido</h3>
            <button type="button" onclick="closeQuickAddModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                    <input type="text" name="code" id="code" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" step="0.01" name="price" id="price" class="w-full pl-7 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    </div>
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="stock" id="stock" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select name="category_id" id="category_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Seleccionar categoría</option>
                        @foreach ($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                    <select name="supplier_id" id="supplier_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Seleccionar proveedor</option>
                        <!-- Aquí irían los proveedores -->
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" id="description" rows="3" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeQuickAddModal()" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image Modal Functionality
    function openImageModal(imageUrl, productName) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('imageModalTitle');
        
        modalImage.src = imageUrl;
        modalTitle.textContent = productName;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Delete Confirmation Modal
    function confirmDelete(deleteUrl, productName) {
        const modal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteProductName = document.getElementById('deleteProductName');
        
        deleteForm.action = deleteUrl;
        deleteProductName.textContent = productName;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Export Modal
    document.getElementById('exportBtn').addEventListener('click', function() {
        const modal = document.getElementById('exportModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
    
    function closeExportModal() {
        const modal = document.getElementById('exportModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Quick Add Modal
    function openQuickAddModal() {
        const modal = document.getElementById('quickAddModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeQuickAddModal() {
        const modal = document.getElementById('quickAddModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Category Filter Event Listener
    document.getElementById('category_filter').addEventListener('change', function() {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route('products.index') }}';
        
        const searchInput = document.createElement('input');
        searchInput.type = 'hidden';
        searchInput.name = 'search';
        searchInput.value = '{{ request('search') }}';
        
        const categoryInput = document.createElement('input');
        categoryInput.type = 'hidden';
        categoryInput.name = 'category_filter';
        categoryInput.value = this.value;
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status_filter';
        statusInput.value = document.getElementById('status_filter').value;
        
        form.appendChild(searchInput);
        form.appendChild(categoryInput);
        form.appendChild(statusInput);
        
        document.body.appendChild(form);
        form.submit();
    });
    
    // Status Filter Event Listener
    document.getElementById('status_filter').addEventListener('change', function() {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route('products.index') }}';
        
        const searchInput = document.createElement('input');
        searchInput.type = 'hidden';
        searchInput.name = 'search';
        searchInput.value = '{{ request('search') }}';
        
        const categoryInput = document.createElement('input');
        categoryInput.type = 'hidden';
        categoryInput.name = 'category_filter';
        categoryInput.value = document.getElementById('category_filter').value;
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status_filter';
        statusInput.value = this.value;
        
        form.appendChild(searchInput);
        form.appendChild(categoryInput);
        form.appendChild(statusInput);
        
        document.body.appendChild(form);
        form.submit();
    });
    
    // Initialize Charts
    document.addEventListener('DOMContentLoaded', function() {
        // Only initialize charts if the elements exist
        if (document.getElementById('activeProductsChart')) {
            const charts = ['activeProductsChart', 'categoriesChart', 'revenueChart', 'lowStockChart'];
            
            charts.forEach(chartId => {
                const ctx = document.getElementById(chartId).getContext('2d');
                
                // Sample data - would be replaced with real data in production
                const data = {
                    labels: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'],
                    datasets: [{
                        label: 'Datos',
                        data: [12, 19, 15, 17, 22, 24, 20],
                        backgroundColor: 'rgba(74, 222, 128, 0.2)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        fill: true
                    }]
                };
                
                // Different chart types for variety
                let type = 'line';
                if (chartId === 'categoriesChart') {
                    type = 'bar';
                }
                
                new Chart(ctx, {
                    type: type,
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                padding: 10,
                                cornerRadius: 6
                            }
                        },
                        scales: {
                            y: {
                                display: false
                            },
                            x: {
                                display: false
                            }
                        },
                        elements: {
                            line: {
                                tension: 0.4
                            }
                        }
                    }
                });
            });
        }
    });
</script>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    /* Custom scroll bar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #4ade80;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #22c55e;
    }
</style>
@endsectiongit add . 