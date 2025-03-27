@extends('layouts.app')

@section('title', 'Detalles del Cliente')

@section('header-title', 'Detalles del Cliente')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Nombre</h3>
                                <p class="text-gray-900">{{ $client->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Email</h3>
                                <p class="text-gray-900">{{ $client->email }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Teléfono</h3>
                                <p class="text-gray-900">{{ $client->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Dirección</h3>
                                <p class="text-gray-900">{{ $client->address ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Tipo de Bicicleta Preferida</h3>
                                <p class="text-gray-900">{{ $client->preferred_bike_type ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Miembro de Lealtad</h3>
                                <p class="text-gray-900">{{ $client->is_loyalty_member ? 'Sí' : 'No' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total de Compras</h3>
                                <p class="text-gray-900">${{ number_format($client->total_purchases, 2) }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Estado</h3>
                                <p class="text-gray-900">{{ $client->status ? 'Activo' : 'Inactivo' }}</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('clients.edit', $client) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors">Editar</a>
                            <a href="{{ route('clients.index') }}" class="ml-2 text-gray-500 hover:underline">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection