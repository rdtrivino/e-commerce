@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column align-items-center min-vh-100"
        style="background: linear-gradient(to bottom, #f8f9fa, #e0e0e0);">
        <div class="w-100 d-flex justify-content-start mb-3" style="position: absolute; top: 20px; left: 20px;">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Productos
            </a>
        </div>
        <div class="container">
            <div class="card mx-auto" style="max-width: 700px;">
                <div class="card-header text-center">
                    <h1>Detalles del Producto</h1>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> {{ $product->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            @if ($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <p>No hay imagen disponible</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p><strong>Descripción:</strong></p>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-custom mr-2">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-custom mr-2">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
