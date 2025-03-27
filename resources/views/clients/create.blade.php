@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('header-title', 'Nuevo Cliente')

@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-form-entry {
        animation: fadeIn 0.6s ease-out;
    }
    .input-hover {
        @apply transition-all duration-300 ease-in-out;
    }
    .input-hover:hover {
        @apply shadow-md border-green-300;
    }
    .input-focus {
        @apply ring-2 ring-green-500 border-transparent;
    }
</style>
@endpush

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg animate-form-entry">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-white dark:bg-gray-700 shadow-2xl rounded-lg p-8 transform transition-all hover:scale-[1.02]">
                        <form action="{{ route('clients.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Nombre</label>
                                    <input type="text" name="name" id="name" 
                                        class="w-full border rounded-lg p-3 input-hover @error('name') border-red-500 @enderror" 
                                        value="{{ old('name') }}"
                                        onfocus="this.classList.add('input-focus')"
                                        onblur="this.classList.remove('input-focus')">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1 animate-pulse">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Email</label>
                                    <input type="email" name="email" id="email" 
                                        class="w-full border rounded-lg p-3 input-hover @error('email') border-red-500 @enderror" 
                                        value="{{ old('email') }}"
                                        onfocus="this.classList.add('input-focus')"
                                        onblur="this.classList.remove('input-focus')">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1 animate-pulse">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Teléfono</label>
                                    <input type="text" name="phone" id="phone" 
                                        class="w-full border rounded-lg p-3 input-hover @error('phone') border-red-500 @enderror" 
                                        value="{{ old('phone') }}"
                                        onfocus="this.classList.add('input-focus')"
                                        onblur="this.classList.remove('input-focus')">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1 animate-pulse">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="preferred_bike_type" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Tipo de Bicicleta Preferida</label>
                                    <select name="preferred_bike_type" id="preferred_bike_type" 
                                        class="w-full border rounded-lg p-3 input-hover @error('preferred_bike_type') border-red-500 @enderror"
                                        onfocus="this.classList.add('input-focus')"
                                        onblur="this.classList.remove('input-focus')">
                                        <option value="">Seleccione un tipo</option>
                                        <option value="Urbana" {{ old('preferred_bike_type') == 'Urbana' ? 'selected' : '' }}>Urbana</option>
                                        <option value="Montaña" {{ old('preferred_bike_type') == 'Montaña' ? 'selected' : '' }}>Montaña</option>
                                        <option value="Ruta" {{ old('preferred_bike_type') == 'Ruta' ? 'selected' : '' }}>Ruta</option>
                                    </select>
                                    @error('preferred_bike_type')
                                        <p class="text-red-500 text-sm mt-1 animate-pulse">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Dirección</label>
                                <textarea name="address" id="address" 
                                    class="w-full border rounded-lg p-3 input-hover @error('address') border-red-500 @enderror"
                                    onfocus="this.classList.add('input-focus')"
                                    onblur="this.classList.remove('input-focus')">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1 animate-pulse">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center space-x-4">
                                <input type="checkbox" name="is_loyalty_member" id="is_loyalty_member" 
                                    class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded" 
                                    value="1" {{ old('is_loyalty_member') ? 'checked' : '' }}>
                                <label for="is_loyalty_member" class="text-gray-700 dark:text-gray-200">Miembro de Lealtad</label>
                            </div>

                            <div class="flex space-x-4">
                                <button type="submit" 
                                    class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Crear Cliente
                                </button>
                                <a href="{{ route('clients.index') }}" 
                                    class="text-gray-500 hover:underline bg-gray-100 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors duration-300">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection