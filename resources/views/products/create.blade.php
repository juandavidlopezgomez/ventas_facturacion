@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title">Nuevo Producto</h3>
                </div>
                
                <div class="card-body">
                    <form id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Código de Producto -->
                                <div class="form-group">
                                    <label>Código de Producto</label>
                                    <div class="input-group">
                                        <input type="text" name="code" value="{{ $newProductCode }}" class="form-control" readonly>
                                        <div class="input-group-append">
                                            <button type="button" id="generateBarcodeBtn" class="btn btn-outline-secondary">
                                                <i class="fas fa-barcode"></i> Generar Código
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lector de Código de Barras -->
                                <div class="form-group">
                                    <label>Escanear Código de Barras</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="barcodeScanner" accept="image/*">
                                        <label class="custom-file-label" for="barcodeScanner">
                                            <i class="fas fa-camera"></i> Escanear
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Resto de campos -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lógica de escáner de código de barras
    const barcodeScanner = document.getElementById('barcodeScanner');
    
    barcodeScanner.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Usar Quagga.js para escanear código de barras
            Quagga.decodeSingle({
                decoder: {
                    readers: ["ean_reader"] // Puedes cambiar según necesites
                },
                locate: true,
                src: URL.createObjectURL(file)
            }, function(result) {
                if (result && result.codeResult) {
                    document.getElementById('barcode').value = result.codeResult.code;
                }
            });
        }
    });

    // Generar código de barras
    document.getElementById('generateBarcodeBtn').addEventListener('click', function() {
        fetch('/products/generate-barcode', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            // Mostrar código de barras generado
            document.getElementById('barcode').value = data.barcode;
        });
    });
});
</script>
@endpush