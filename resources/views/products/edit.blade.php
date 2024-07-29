@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column align-items-center min-vh-100"
        style="background: linear-gradient(to bottom, #f8f9fa, #e0e0e0);">
        <div class="w-100 d-flex justify-content-start mb-3" style="position: absolute; top: 20px; left: 20px;">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Productos
            </a>
        </div>
        <div class="card mx-auto" style="max-width: 500px; margin-top: 20px;">
            <div class="card-header text-center">
                <h1>Editar Producto</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ $product->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Precio</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ $product->price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required>{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_url">Imagen del Producto</label>
                        <input type="file" name="image_url" id="image_url" class="form-control">
                        @if ($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-thumbnail mt-2"
                                style="max-width: 150px;">
                        @endif
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary btn-custom">Actualizar</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-custom">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
