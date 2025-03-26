@extends('layouts.app')

@section('title', 'Detalles de la Venta')
@section('header-title', 'Detalles de la Venta')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md animate-fadeIn text-gray-800">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detalles de la Venta #{{ $sale->id }}</h2>
            <a href="{{ route('sales.index') }}" class="text-green-600 hover:text-green-700 flex items-center transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 fill-current" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a Ventas
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 border border-green-400 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-green-50 p-4 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Información de la Venta</h3>
                <p class="text-gray-700"><strong class="text-gray-800">Fecha:</strong> {{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i:s') : 'N/A' }}</p>
                <p class="text-gray-700"><strong class="text-gray-800">Cliente:</strong> {{ $sale->client->name ?? 'Sin cliente' }}</p>
                <p class="text-gray-700"><strong class="text-gray-800">Vendedor:</strong> {{ $sale->user->name ?? 'N/A' }}</p>
                <p class="text-gray-700"><strong class="text-gray-800">Estado:</strong> 
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $sale->status === 'completed' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                        {{ $sale->status === 'completed' ? 'Completada' : 'Cancelada' }}
                    </span>
                </p>
            </div>

            <div class="bg-green-50 p-4 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Información de Pago</h3>
                <p class="text-gray-700"><strong class="text-gray-800">Método de Pago:</strong> {{ ucfirst($sale->payment_method) }}</p>
                <p class="text-gray-700"><strong class="text-gray-800">Facturada:</strong> {{ $sale->is_invoiced ? 'Sí' : 'No' }}</p>
                <p class="text-gray-700"><strong class="text-gray-800">Impuesto (IVA 19%):</strong> ${{ number_format($sale->tax, 2) }}</p>
                <p class="text-gray-700"><strong class="text-gray-800">Descuento:</strong> ${{ number_format($sale->discount, 2) }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Productos</h3>
            <div class="overflow-x-auto rounded-xl shadow-sm">
                <table class="w-full text-left">
                    <thead class="bg-green-100">
                        <tr>
                            <th class="px-4 py-3 text-gray-700 font-semibold">Producto</th>
                            <th class="px-4 py-3 text-gray-700 font-semibold">Cantidad</th>
                            <th class="px-4 py-3 text-gray-700 font-semibold">Precio Unitario</th>
                            <th class="px-4 py-3 text-gray-700 font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($sale->saleDetails as $detail)
                            <tr class="border-b border-green-50 hover:bg-green-50 transition-colors duration-200">
                                <td class="px-4 py-3 text-gray-700">{{ $detail->product->name }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $detail->quantity }}</td>
                                <td class="px-4 py-3 text-gray-700">${{ number_format($detail->price, 2) }}</td>
                                <td class="px-4 py-3 text-gray-700">${{ number_format($detail->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <p class="text-xl font-bold text-gray-800">Total: <span class="text-green-600">${{ number_format($sale->total, 2) }}</span></p>
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
                        class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 fill-current" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H9v4a2 2 0 002 2zM9 5h6M7 9h10" />
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('sales.edit', $sale->id) }}" class="bg-white border-2 border-green-500 text-green-600 px-6 py-3 rounded-xl hover:bg-green-50 hover:shadow-md transition-all duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
            </div>
        </div>
    </div>
@endsection