
@extends('layouts.app')

@section('title', 'Crear Venta')
@section('header-title', 'Nueva Venta')

@section('content')
    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow-card animate-fadeIn text-white">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Nueva Venta</h2>
            <a href="{{ route('sales.index') }}" class="text-blue-400 hover:text-blue-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a Ventas
            </a>
        </div>
        
        <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" id="sale-form">
            @csrf
            <div class="space-y-6">
                <div class="border-t border-gray-700 pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Productos de la Venta</h3>
                        <button type="button" id="add-product" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Agregar Producto
                        </button>
                    </div>
                    
                    <div id="product-items" class="space-y-4">
                        <div class="grid grid-cols-12 gap-4 items-center bg-gray-800 p-4 rounded-lg">
                            <div class="col-span-5">
                                <label class="block text-sm font-medium mb-1 text-gray-300">Producto <span class="text-red-500">*</span></label>
                                <input type="text" name="product_search[0]" class="product-search w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Buscar por código o nombre..." autocomplete="off">
                                <select name="products[0][product_id]" class="product-select w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700 hidden" required>
                                    <option value="" disabled selected data-code="">Selecciona un producto</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price ?? 0 }}" data-stock="{{ $product->stock ?? 0 }}" data-code="{{ $product->code ?? '' }}">
                                            {{ $product->name }} ({{ $product->code ?? 'Sin código' }} - ${{ number_format($product->price ?? 0, 2, '.', ',') }} - {{ $product->stock ?? 0 }} disponibles)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1 text-gray-300">Cantidad <span class="text-red-500">*</span></label>
                                <input type="number" name="products[0][quantity]" min="1" class="quantity-input w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Cant." value="1" required>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1 text-gray-300">Precio ($)</label>
                                <input type="number" name="products[0][price]" step="0.01" min="0" class="price-input w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="0.00" readonly>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1 text-gray-300">Subtotal ($)</label>
                                <input type="text" class="subtotal-display w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="$0.00" readonly>
                            </div>
                            <div class="col-span-1 pt-6">
                                <button type="button" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-all duration-300" onclick="removeProductItem(this)" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('products')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-300">Cliente (Opcional)</label>
                        <button type="button" id="add-client" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-all duration-300 flex items-center" title="Nuevo Cliente">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Agregar Cliente
                        </button>
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium mb-1 text-gray-300">Método de Pago <span class="text-red-500">*</span></label>
                        <select name="payment_method" id="payment_method" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" required>
                            <option value="efectivo" {{ old('payment_method') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="tarjeta" {{ old('payment_method') === 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="transferencia" {{ old('payment_method') === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="cash-section" class="hidden space-y-4">
                        <div>
                            <label for="cash_received" class="block text-sm font-medium mb-1 text-gray-300">Monto Recibido ($) <span class="text-red-500">*</span></label>
                            <input type="number" name="cash_received" id="cash_received" step="0.01" min="0" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="0.00" required>
                            @error('cash_received')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <p id="change-due" class="text-sm font-medium text-gray-300">Cambio: $0.00</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tax" class="block text-sm font-medium mb-1 text-gray-300">Impuesto (IVA 19%)</label>
                            <input type="number" name="tax" id="tax" value="{{ old('tax', 0) }}" step="0.01" min="0" class="w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" readonly>
                            @error('tax')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-800 p-4 rounded-lg">
                    <div class="flex justify-between items-center text-lg mb-2">
                        <span class="font-medium text-gray-300">Subtotal:</span>
                        <span id="total-subtotal" class="font-semibold">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center text-lg mb-2">
                        <span class="font-medium text-gray-300">Impuesto (IVA 19%):</span>
                        <span id="total-tax" class="font-semibold">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center text-xl pt-2 border-t border-gray-700">
                        <span class="font-bold text-gray-300">TOTAL:</span>
                        <span id="total-amount" class="font-bold">$0.00</span>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Crear Venta
                    </button>
                    <button type="button" id="print-receipt" class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition-all duration-300 flex items-center hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H9v4a2 2 0 002 2zM9 5h6M7 9h10" />
                        </svg>
                        Imprimir Factura
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let productIndex = 1;
        let products = @json($products ?? []);

        // Mostrar sección de efectivo y calcular impuestos al cargar o cambiar método de pago
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.getElementById('payment_method');
            const cashSection = document.getElementById('cash-section');
            if (paymentMethod.value === 'efectivo') {
                cashSection.classList.remove('hidden');
                document.getElementById('cash_received').setAttribute('required', 'required');
            }
            updateTotals(); // Calcular inicial
        });

        document.getElementById('payment_method').addEventListener('change', function() {
            const cashSection = document.getElementById('cash-section');
            if (this.value === 'efectivo') {
                cashSection.classList.remove('hidden');
                document.getElementById('cash_received').setAttribute('required', 'required');
            } else {
                cashSection.classList.add('hidden');
                document.getElementById('cash_received').removeAttribute('required');
            }
            updateTotals(); // Actualizar totales al cambiar método
        });

        // Calcular cambio
        document.getElementById('cash_received').addEventListener('input', function() {
            const total = parseFloat(document.getElementById('total-amount').textContent.replace('$', '')) || 0;
            const received = parseFloat(this.value) || 0;
            const change = received - total;
            document.getElementById('change-due').textContent = `Cambio: $${change.toFixed(2)}`;
            if (change < 0) {
                document.getElementById('change-due').classList.add('text-red-500');
            } else {
                document.getElementById('change-due').classList.remove('text-red-500');
            }
        });

        // Redirigir a crear cliente
        document.getElementById('add-client').addEventListener('click', function() {
            window.location.href = '{{ route('clients.create') }}';
        });

        // Función para agregar un nuevo producto
        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('product-items');
            const newItem = document.createElement('div');
            newItem.className = 'grid grid-cols-12 gap-4 items-center bg-gray-800 p-4 rounded-lg';
            newItem.innerHTML = `
                <div class="col-span-5">
                    <label class="block text-sm font-medium mb-1 text-gray-300">Producto <span class="text-red-500">*</span></label>
                    <input type="text" name="product_search[${productIndex}]" class="product-search w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Buscar por código o nombre..." autocomplete="off">
                    <select name="products[${productIndex}][product_id]" class="product-select w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700 hidden" required>
                        <option value="" disabled selected data-code="">Selecciona un producto</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price ?? 0 }}" data-stock="{{ $product->stock ?? 0 }}" data-code="{{ $product->code ?? '' }}">
                                {{ $product->name }} ({{ $product->code ?? 'Sin código' }} - ${{ number_format($product->price ?? 0, 2, '.', ',') }} - {{ $product->stock ?? 0 }} disponibles)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1 text-gray-300">Cantidad <span class="text-red-500">*</span></label>
                    <input type="number" name="products[${productIndex}][quantity]" min="1" class="quantity-input w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="Cant." value="1" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1 text-gray-300">Precio ($)</label>
                    <input type="number" name="products[${productIndex}][price]" step="0.01" min="0" class="price-input w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="0.00" readonly>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1 text-gray-300">Subtotal ($)</label>
                    <input type="text" class="subtotal-display w-full p-2 border border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-white bg-gray-700" placeholder="$0.00" readonly>
                </div>
                <div class="col-span-1 pt-6">
                    <button type="button" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-all duration-300" onclick="removeProductItem(this)" title="Eliminar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            `;
            container.appendChild(newItem);

            initProductSearch(newItem.querySelector('.product-search'), newItem.querySelector('.product-select'));
            initProductItemListeners(newItem);

            productIndex++;
            updateTotals();
        });

        // Función para eliminar un producto
        function removeProductItem(button) {
            button.closest('.grid').remove();
            updateTotals();
        }

        // Inicializar búsqueda de productos
        function initProductSearch(searchInput, selectElement) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const options = Array.from(selectElement.options);
                let found = false;

                for (let i = 1; i < options.length; i++) {
                    const optionCode = options[i].getAttribute('data-code') ? options[i].getAttribute('data-code').toLowerCase() : '';
                    if (optionCode === searchTerm) {
                        selectElement.selectedIndex = i;
                        selectElement.classList.remove('hidden');
                        selectElement.setAttribute('required', 'required');
                        searchInput.classList.add('hidden');
                        selectElement.dispatchEvent(new Event('change'));
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    for (let i = 1; i < options.length; i++) {
                        const optionText = options[i].text ? options[i].text.toLowerCase() : '';
                        if (optionText.includes(searchTerm)) {
                            selectElement.selectedIndex = i;
                            selectElement.classList.remove('hidden');
                            selectElement.setAttribute('required', 'required');
                            searchInput.classList.add('hidden');
                            selectElement.dispatchEvent(new Event('change'));
                            found = true;
                            break;
                        }
                    }
                }

                if (!found && searchTerm) {
                    selectElement.selectedIndex = 0;
                    selectElement.classList.add('hidden');
                    selectElement.removeAttribute('required');
                    searchInput.classList.remove('hidden');
                    const priceInput = searchInput.closest('.grid').querySelector('.price-input');
                    const quantityInput = searchInput.closest('.grid').querySelector('.quantity-input');
                    const subtotalDisplay = searchInput.closest('.grid').querySelector('.subtotal-display');
                    priceInput.value = '0.00';
                    quantityInput.value = '1';
                    subtotalDisplay.value = '$0.00';
                    updateTotals();
                }
            });

            selectElement.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                    const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
                    const quantityInput = this.closest('.grid').querySelector('.quantity-input');
                    const priceInput = this.closest('.grid').querySelector('.price-input');
                    const subtotalDisplay = this.closest('.grid').querySelector('.subtotal-display');

                    priceInput.value = price.toFixed(2);
                    quantityInput.max = stock;
                    quantityInput.value = quantityInput.value || '1'; // Asegurar valor por defecto
                    updateSubtotal(quantityInput, priceInput, subtotalDisplay);
                    searchInput.classList.add('hidden');
                    selectElement.classList.remove('hidden');
                    selectElement.setAttribute('required', 'required');
                } else {
                    searchInput.classList.remove('hidden');
                    selectElement.classList.add('hidden');
                    selectElement.removeAttribute('required');
                    const priceInput = searchInput.closest('.grid').querySelector('.price-input');
                    const quantityInput = searchInput.closest('.grid').querySelector('.quantity-input');
                    const subtotalDisplay = searchInput.closest('.grid').querySelector('.subtotal-display');
                    priceInput.value = '0.00';
                    quantityInput.value = '1';
                    subtotalDisplay.value = '$0.00';
                    updateTotals();
                }
            });
        }

        // Inicializar event listeners para cada elemento producto
        function initProductItemListeners(item) {
            const productSelect = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const priceInput = item.querySelector('.price-input');
            const subtotalDisplay = item.querySelector('.subtotal-display');

            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

                priceInput.value = price.toFixed(2);
                quantityInput.max = stock;
                quantityInput.value = quantityInput.value || '1'; // Asegurar valor por defecto

                updateSubtotal(quantityInput, priceInput, subtotalDisplay);
            });

            quantityInput.addEventListener('input', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
                    if (parseInt(this.value) > stock) {
                        this.value = stock;
                        alert('La cantidad no puede exceder el stock disponible');
                    }
                    if (parseInt(this.value) < 1) {
                        this.value = 1;
                    }
                } else {
                    this.value = 1; // Valor por defecto si no hay producto seleccionado
                }

                updateSubtotal(quantityInput, priceInput, subtotalDisplay);
            });
        }

        // Actualizar el subtotal de un producto
        function updateSubtotal(quantityInput, priceInput, subtotalDisplay) {
            const quantity = parseInt(quantityInput.value) || 0; // Manejar caso nulo
            const price = parseFloat(priceInput.value) || 0; // Manejar caso nulo
            const subtotal = quantity * price;

            subtotalDisplay.value = '$' + subtotal.toFixed(2);
            updateTotals();
        }

        // Actualizar totales de la venta
        function updateTotals() {
            const allSubtotals = document.querySelectorAll('.subtotal-display');
            let subtotal = 0;
            allSubtotals.forEach(function(element) {
                const value = parseFloat(element.value.replace('$', '')) || 0; // Manejar caso nulo
                subtotal += value;
            });

            const tax = subtotal * 0.19; // IVA del 19%
            document.getElementById('tax').value = tax.toFixed(2);
            document.getElementById('total-tax').textContent = '$' + tax.toFixed(2);
            const total = subtotal + tax;

            document.getElementById('total-subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total-amount').textContent = '$' + total.toFixed(2);

            // Actualizar cambio si hay efectivo
            if (document.getElementById('payment_method').value === 'efectivo') {
                const cashReceived = parseFloat(document.getElementById('cash_received').value) || 0;
                const change = cashReceived - total;
                document.getElementById('change-due').textContent = `Cambio: $${change.toFixed(2)}`;
                if (change < 0) {
                    document.getElementById('change-due').classList.add('text-red-500');
                } else {
                    document.getElementById('change-due').classList.remove('text-red-500');
                }
            }
        }

        // Inicializar listeners para productos existentes
        document.querySelectorAll('#product-items > div').forEach(function(item) {
            initProductSearch(item.querySelector('.product-search'), item.querySelector('.product-select'));
            initProductItemListeners(item);
        });

        // Validar formulario antes de enviar
        document.getElementById('sale-form').addEventListener('submit', function(e) {
            const productItems = document.querySelectorAll('.product-select');
            let hasProducts = false;

            productItems.forEach(function(select) {
                if (select.value && !select.classList.contains('hidden')) {
                    hasProducts = true;
                } else if (select.classList.contains('hidden')) {
                    select.removeAttribute('required');
                }
            });

            if (!hasProducts) {
                e.preventDefault();
                alert('Debe seleccionar al menos un producto para la venta');
                return false;
            }

            return true;
        });

        // Función para imprimir factura (mostrará un mensaje temporal hasta que se cree la venta)
        function printReceipt() {
            alert('Por favor, cree la venta primero para imprimir el recibo.');
        }

        document.getElementById('print-receipt').addEventListener('click', printReceipt);
    </script>
    @endpush
@endsection