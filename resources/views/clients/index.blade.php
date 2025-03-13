@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">ID</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Nombre</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Email</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Teléfono</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>
                <td class="px-6 py-4 border-b border-gray-300">{{ $client->id }}</td>
                <td class="px-6 py-4 border-b border-gray-300">{{ $client->name }}</td>
                <td class="px-6 py-4 border-b border-gray-300">{{ $client->email }}</td>
                <td class="px-6 py-4 border-b border-gray-300">{{ $client->phone }}</td>
                <td class="px-6 py-4 border-b border-gray-300">
                    <a href="{{ route('clients.edit', $client->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a href="{{ route('clients.create') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Crear Cliente</a>
@endsection