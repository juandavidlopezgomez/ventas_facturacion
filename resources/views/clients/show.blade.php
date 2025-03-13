@extends('layouts.app')

@section('title', 'Detalles de Cliente')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Detalles de Cliente</h1>

    <!-- Información del cliente -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-bold mb-2">Nombre</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $client->name }}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2">Email</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $client->email }}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2">Teléfono</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $client->phone }}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2">Dirección</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $client->address }}</p>
            </div>
        </div>
    </div>

    <!-- Historial de compras -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">Historial de Compras</h2>
        <table class="min-w-full">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($client->sales as $sale)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4">{{ $sale->id }}</td>
                        <td class="px-6 py-4">${{ number_format($sale->total, 2) }}</td>
                        <td class="px-6 py-4">{{ $sale->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection