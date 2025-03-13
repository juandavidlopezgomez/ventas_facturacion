@extends('layouts.app')

@section('title', 'Detalles de la Venta')
@section('header-title', 'Detalles de la Venta')

@section('content')
    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow-card animate-fadeIn text-white">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Detalles de la Venta #{{ $sale->id }}</h2>
            <a href="{{ route('sales.index') }}" class="text-blue-400 hover:text-blue-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a Ventas
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Información de la Venta</h3>
                <p><strong>Fecha:</strong> {{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i:s') : 'N/A' }}</p>
                <p><strong>Cliente:</strong> {{ $sale->client->name ?? 'Sin cliente' }}</p>
                <p><strong>Vendedor:</strong> {{ $sale->user->name ?? 'N/A' }}</p>
                <p><strong>Estado:</strong> 
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $sale->status === 'completed' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                        {{ $sale->status === 'completed' ? 'Completada' : 'Cancelada' }}
                    </span>
                </p>
            </div>

            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Información de Pago</h3>
                <p><strong>Método de Pago:</strong> {{ ucfirst($sale->payment_method) }}</p>
                <p><strong>Facturada:</strong> {{ $sale->is_invoiced ? 'Sí' : 'No' }}</p>
                <p><strong>Impuesto (IVA 19%):</strong> ${{ number_format($sale->tax, 2) }}</p>
                <p><strong>Descuento:</strong> ${{ number_format($sale->discount, 2) }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4">Productos</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-4 py-2">Producto</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Precio Unitario</th>
                            <th class="px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->saleDetails as $detail)
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-2">{{ $detail->product->name }}</td>
                                <td class="px-4 py-2">{{ $detail->quantity }}</td>
                                <td class="px-4 py-2">${{ number_format($detail->price, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($detail->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <p class="text-xl font-bold">Total: ${{ number_format($sale->total, 2) }}</p>
            <div class="space-x-4">
                <button data-sale-id="{{ $sale->id }}"
                        data-subtotal="{{ $sale->total - $sale->tax }}"
                        data-tax="{{ $sale->tax }}"
                        data-total="{{ $sale->total }}"
                        data-sale-date="{{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i:s') : 'N/A' }}"
                        data-client-name="{{ $sale->client->name ?? 'Sin cliente' }}"
                        data-payment-method="{{ ucfirst($sale->payment_method) }}"
                        data-sale-details="{{ json_encode($sale->saleDetails->map(function ($detail) {
                            return [
                                'productName' => $detail->product->name,
                                'quantity' => $detail->quantity,
                                'price' => $detail->price,
                                'subtotal' => $detail->subtotal
                            ];
                        })) }}"
                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-all duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H9v4a2 2 0 002 2zM9 5h6M7 9h10" />
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('sales.edit', $sale->id) }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
            </div>
        </div>
    </div>
@endsection