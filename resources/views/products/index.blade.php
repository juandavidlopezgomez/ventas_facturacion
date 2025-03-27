@extends('layouts.app')

@section('title', 'Gestión de Productos')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Catálogo de Productos</h2>
            
            <div class="flex space-x-3">
                <div class="relative">
                    <input type="text" id="global-search" 
                           placeholder="Buscar producto..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button">
                        <i class="fas fa-plus mr-2"></i>Nuevo Producto
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('products.create') }}" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i>Crear Manualmente
                        </a>
                        <a href="#" id="scan-barcode" class="dropdown-item">
                            <i class="fas fa-barcode mr-2"></i>Escanear Código
                        </a>
                        <a href="#" id="import-csv" class="dropdown-item">
                            <i class="fas fa-file-csv mr-2"></i>Importar CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                <select class="form-control" id="category-filter">
                    <option value="">Todas las Categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <select class="form-control" id="stock-filter">
                    <option value="">Estado de Stock</option>
                    <option value="low">Bajo Stock</option>
                    <option value="out">Sin Stock</option>
                    <option value="available">Disponible</option>
                </select>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show-active" checked>
                    <label for="show-active">Mostrar solo activos</label>
                </div>
            </div>

            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">Imagen</th>
                        <th class="py-3 px-4 text-left">Código</th>
                        <th class="py-3 px-4 text-left">Nombre</th>
                        <th class="py-3 px-4 text-center">Stock</th>
                        <th class="py-3 px-4 text-center">Precio</th>
                        <th class="py-3 px-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <!-- Columnas de producto similar a tu diseño actual -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection