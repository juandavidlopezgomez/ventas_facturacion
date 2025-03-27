@extends('layouts.app')

@section('title', 'Clientes')

@push('styles')
<style>
    /* Advanced Keyframe Animations */
    @keyframes subtleFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @keyframes smoothPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes fadeInSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes borderGlow {
        0%, 100% { 
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.1);
        }
        50% {
            border-color: rgba(16, 185, 129, 0.7);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
    }

    /* Enhanced Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f0f9f0;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #10b981, #22c55e);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #059669, #4ade80);
    }

    /* Advanced Interactive Elements */
    .smooth-hover {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .card-hover {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.2);
    }

    .elegant-input {
        transition: all 0.4s ease;
        border: 2px solid rgba(16, 185, 129, 0.2);
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.1);
    }

    .elegant-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .action-icon {
        transition: transform 0.3s, color 0.3s;
    }

    .action-icon:hover {
        transform: scale(1.2) rotate(5deg);
    }

    /* Advanced Animation Classes */
    .animate-fade-in-slide {
        animation: fadeInSlideUp 0.6s ease-out;
    }

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }

    .client-avatar {
        background: linear-gradient(135deg, #10b981, #22c55e);
        transition: all 0.4s ease;
    }

    .client-avatar:hover {
        animation: smoothPulse 1s infinite;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8 bg-white min-h-screen">
    {{-- Professional Header Section --}}
    <div class="mb-12 flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0 p-6 rounded-2xl bg-green-50 shadow-lg animate-fade-in-slide">
        <div>
            <h1 class="text-4xl font-extrabold text-green-700 mb-3 tracking-tight">
                Gestión de Clientes
            </h1>
            <p class="text-green-600 text-lg leading-relaxed">
                Administra y visualiza la información de tus clientes con precisión y elegancia
            </p>
        </div>

        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
            {{-- Enhanced Search Input --}}
            <div class="relative flex-grow md:flex-grow-0">
                <input 
                    type="text" 
                    id="client-search" 
                    placeholder="Buscar clientes..." 
                    class="elegant-input w-full md:w-80 px-6 py-3 border-2 rounded-xl pl-12 text-green-800 focus:outline-none"
                >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute left-4 top-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            {{-- New Client Button with Professional Styling --}}
            <a href="{{ route('clients.create') }}" 
               class="flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-300 hover-scale focus:outline-none focus:ring-4 focus:ring-green-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nuevo Cliente
            </a>
        </div>
    </div>

    {{-- Success Message with Enhanced Styling --}}
    @if (session('success'))
        <div class="bg-green-50 border-l-8 border-green-500 text-green-700 p-5 mb-8 rounded-r-lg shadow-md animate-fade-in-slide" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Clients Table with Professional Design --}}
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-green-100 card-hover">
        <table class="min-w-full divide-y divide-green-100">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-green-700 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-green-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-green-700 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-green-700 uppercase tracking-wider">Tipo de Bicicleta</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-green-700 uppercase tracking-wider">Miembro</th>
                    <th class="px-6 py-4 text-right text-sm font-bold text-green-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-green-100">
                @forelse ($clients as $client)
                    <tr class="hover:bg-green-50 transition-all duration-300 smooth-hover">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-full text-white flex items-center justify-center font-bold client-avatar">
                                        {{ substr($client->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-green-900">
                                        {{ $client->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm text-green-600">
                            {{ $client->email }}
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm text-green-600">
                            {{ $client->phone ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                {{ $client->preferred_bike_type == 'Urbana' ? 'bg-green-100 text-green-800' : 
                                   ($client->preferred_bike_type == 'Montaña' ? 'bg-emerald-100 text-emerald-800' : 'bg-teal-100 text-teal-800') }}">
                                {{ $client->preferred_bike_type ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm">
                            <span class="{{ $client->is_loyalty_member ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full">
                                {{ $client->is_loyalty_member ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('clients.show', $client) }}" class="text-green-500 hover:text-green-700 action-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="{{ route('clients.edit', $client) }}" class="text-emerald-500 hover:text-emerald-700 action-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 action-icon"
                                            onclick="return confirm('¿Estás seguro de desactivar este cliente?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-green-500 text-lg font-semibold">
                            No hay clientes activos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Enhanced Client Search Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('client-search');
        const tableRows = document.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(searchTerm)) {
                    row.style.display = '';
                    row.classList.remove('opacity-0');
                    row.classList.add('opacity-100');
                } else {
                    row.classList.remove('opacity-100');
                    row.classList.add('opacity-0');
                    setTimeout(() => {
                        row.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
</script>
@endpush
@endsection