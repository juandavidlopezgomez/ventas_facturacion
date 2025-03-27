@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Editar Producto</h3>
                </div>
                
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Código de Producto</label>
                                    <input type="text" name="code" class="form-control" value="{{ $product->code }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Nombre del Producto</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="number" name="price" step="0.01" class="form-control" value="{{ $product->price }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Categoría</label>
                                    <select name="category_id" class="form-control" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Imagen del Producto</label>
                                    <input type="file" name="image" class="form-control-file">
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" width="100" class="mt-2">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Código de Barras</label>
                                    <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection