@extends('layouts.app')

@section('title', 'Clientes')

@section('header-title', 'Clientes')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('clients.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-600 transition-colors">Nuevo Cliente</a>

                    <div class="bg-white shadow-md rounded-lg p-6">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left">Nombre</th>
                                    <th class="px-4 py-2 text-left">Email</th>
                                    <th class="px-4 py-2 text-left">Teléfono</th>
                                    <th class="px-4 py-2 text-left">Tipo de Bicicleta</th>
                                    <th class="px-4 py-2 text-left">Miembro de Lealtad</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $client->name }}</td>
                                        <td class="border px-4 py-2">{{ $client->email }}</td>
                                        <td class="border px-4 py-2">{{ $client->phone ?? 'N/A' }}</td>
                                        <td class="border px-4 py-2">{{ $client->preferred_bike_type ?? 'N/A' }}</td>
                                        <td class="border px-4 py-2">{{ $client->is_loyalty_member ? 'Sí' : 'No' }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('clients.show', $client) }}" class="text-blue-500 hover:underline">Ver</a>
                                            <a href="{{ route('clients.edit', $client) }}" class="text-yellow-500 hover:underline ml-2">Editar</a>
                                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('¿Estás seguro de desactivar este cliente?')">Desactivar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-2 text-center">No hay clientes activos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection