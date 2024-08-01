@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column align-items-center min-vh-100"
        style="background: linear-gradient(to bottom, #f8f9fa, #e0e0e0);">

        <div class="w-100 d-flex justify-content-start mb-3" style="position: absolute; top: 20px; left: 20px;">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Productos
            </a>
        </div>

        <div class="card mx-auto" style="max-width: 500px; margin-top: 20px;">
            <div class="card-header text-center">
                <h1>{{ isset($product) ? 'Editar Producto' : 'Agregar Producto' }}</h1>
            </div>

            <div class="card-body">
                <!-- Mostrar mensajes de éxito o error -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', isset($product) ? $product->name : '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Precio</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price', isset($product) ? $product->price : '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Categoría</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image_url">Imagen del Producto</label>
                        <input type="file" name="image_url" id="image_url" class="form-control">
                        @if (isset($product) && $product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-thumbnail mt-2"
                                style="max-width: 150px;">
                        @endif
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <button type="submit"
                            class="btn btn-primary">{{ isset($product) ? 'Actualizar' : 'Agregar' }}</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
