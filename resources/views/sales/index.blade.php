@extends('layouts.app')

@section('title', 'Ventas')
@section('header-title', 'Gestión de Ventas')

@section('content')
    <div class="grid grid-cols-1 gap-6">
        <div class="flex justify-between items-center mb-4">
            <div class="flex gap-2">
                <a href="{{ route('sales.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 animate-fadeIn flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nueva Venta
                </a>
                <a href="#" id="export-sales" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all duration-300 animate-fadeIn flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Exportar
                </a>
            </div>
            <div class="flex items-center">
                <input type="text" id="sales-search" placeholder="Buscar ventas..." class="p-2 border border-accent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-black dark:text-white bg-white dark:bg-gray-800 mr-2">
                <div class="relative">
                    <button id="filter-button" class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtros
                    </button>
                    <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 z-10">
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Fecha</label>
                            <div class="flex space-x-2">
                                <input type="date" id="date-from" class="w-full p-2 border border-accent rounded-lg">
                                <input type="date" id="date-to" class="w-full p-2 border border-accent rounded-lg">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Método de Pago</label>
                            <select id="payment-method-filter" class="w-full p-2 border border-accent rounded-lg">
                                <option value="">Todos</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Facturada</label>
                            <select id="invoice-filter" class="w-full p-2 border border-accent rounded-lg">
                                <option value="">Todos</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button id="apply-filters" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Aplicar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-card rounded-lg p-6 shadow-card animate-fadeIn">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center" role="alert">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="close-alert" onclick="this.parentElement.style.display='none'">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            @endif
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Impuesto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descuento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Método de Pago</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Facturada</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($sales as $sale)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $sale->client->name ?? 'Sin cliente' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-semibold">${{ number_format($sale->total, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">${{ number_format($sale->tax, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">${{ number_format($sale->discount, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @switch($sale->payment_method)
                                        @case('efectivo')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Efectivo</span>
                                            @break
                                        @case('tarjeta')
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Tarjeta</span>
                                            @break
                                        @case('transferencia')
                                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Transferencia</span>
                                            @break
                                        @default
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">{{ ucfirst($sale->payment_method) }}</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($sale->is_invoiced)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Sí</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if(isset($sale->status))
                                        @switch($sale->status)
                                            @case('pending')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pendiente</span>
                                                @break
                                            @case('completed')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Completada</span>
                                                @break
                                            @case('cancelled')
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Cancelada</span>
                                                @break
                                            @default
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">{{ ucfirst($sale->status) }}</span>
                                        @endswitch
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">No definido</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('sales.show', $sale) }}" class="text-blue-500 hover:text-blue-700" title="Ver detalles">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('sales.edit', $sale) }}" class="text-yellow-500 hover:text-yellow-700" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro que deseas eliminar esta venta?')" title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('sales.print', $sale) }}" class="text-green-500 hover:text-green-700" title="Imprimir" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No hay ventas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter dropdown toggle
            const filterButton = document.getElementById('filter-button');
            const filterDropdown = document.getElementById('filter-dropdown');
            
            filterButton.addEventListener('click', function() {
                filterDropdown.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });
            
            // Search functionality
            const searchInput = document.getElementById('sales-search');
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    window.location.href = '{{ route("sales.index") }}?search=' + this.value;
                }
            });
            
            // Apply filters
            document.getElementById('apply-filters').addEventListener('click', function() {
                const dateFrom = document.getElementById('date-from').value;
                const dateTo = document.getElementById('date-to').value;
                const paymentMethod = document.getElementById('payment-method-filter').value;
                const invoiced = document.getElementById('invoice-filter').value;
                
                let url = '{{ route("sales.index") }}?';
                if (dateFrom) url += 'date_from=' + dateFrom + '&';
                if (dateTo) url += 'date_to=' + dateTo + '&';
                if (paymentMethod) url += 'payment_method=' + paymentMethod + '&';
                if (invoiced) url += 'invoiced=' + invoiced + '&';
                
                window.location.href = url;
            });
            
            // Export functionality
            document.getElementById('export-sales').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '{{ route("sales.export") }}';
            });
        });
    </script>
    @endpush
@endsection