@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Detalles del Producto</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded">
                    @else
                        <p>Sin imagen</p>
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th>Código</th>
                            <td>{{ $product->code }}</td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Descripción</th>
                            <td>{{ $product->description ?? 'Sin descripción' }}</td>
                        </tr>
                        <tr>
                            <th>Precio</th>
                            <td>${{ number_format($product->price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td>{{ $product->stock }}</td>
                        </tr>
                        <tr>
                            <th>Categoría</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <th>Código de Barras</th>
                            <td>{{ $product->barcode ?? 'No definido' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection