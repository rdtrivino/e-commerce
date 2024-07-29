@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column align-items-center min-vh-100"
        style="background: linear-gradient(to bottom, #f8f9fa, #e0e0e0);">
        <div class="w-100 d-flex justify-content-start mb-3" style="position: absolute; top: 20px; left: 20px;">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Productos
            </a>
        </div>
        <div class="container p-5"
            style="background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 600px;">
            <h1 class="text-center mb-4">Crear Producto</h1>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="price">Precio</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Imagen</label>
                    <input type="file" name="image" id="image" class="form-control-file" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
