@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('header-title', 'Editar Cliente')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <form action="{{ route('clients.update', $client) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-medium">Nombre</label>
                                <input type="text" name="name" id="name" class="w-full border rounded p-2 @error('name') border-red-500 @enderror" value="{{ old('name', $client->name) }}">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-medium">Email</label>
                                <input type="email" name="email" id="email" class="w-full border rounded p-2 @error('email') border-red-500 @enderror" value="{{ old('email', $client->email) }}">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 font-medium">Teléfono</label>
                                <input type="text" name="phone" id="phone" class="w-full border rounded p-2 @error('phone') border-red-500 @enderror" value="{{ old('phone', $client->phone) }}">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="address" class="block text-gray-700 font-medium">Dirección</label>
                                <textarea name="address" id="address" class="w-full border rounded p-2 @error('address') border-red-500 @enderror">{{ old('address', $client->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="preferred_bike_type" class="block text-gray-700 font-medium">Tipo de Bicicleta Preferida</label>
                                <select name="preferred_bike_type" id="preferred_bike_type" class="w-full border rounded p-2 @error('preferred_bike_type') border-red-500 @enderror">
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Urbana" {{ old('preferred_bike_type', $client->preferred_bike_type) == 'Urbana' ? 'selected' : '' }}>Urbana</option>
                                    <option value="Montaña" {{ old('preferred_bike_type', $client->preferred_bike_type) == 'Montaña' ? 'selected' : '' }}>Montaña</option>
                                    <option value="Ruta" {{ old('preferred_bike_type', $client->preferred_bike_type) == 'Ruta' ? 'selected' : '' }}>Ruta</option>
                                </select>
                                @error('preferred_bike_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="is_loyalty_member" class="block text-gray-700 font-medium">Miembro de Lealtad</label>
                                <input type="checkbox" name="is_loyalty_member" id="is_loyalty_member" value="1" {{ old('is_loyalty_member', $client->is_loyalty_member) ? 'checked' : '' }}>
                                @error('is_loyalty_member')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">Actualizar Cliente</button>
                            <a href="{{ route('clients.index') }}" class="ml-2 text-gray-500 hover:underline">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection