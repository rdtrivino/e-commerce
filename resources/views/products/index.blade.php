@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-center">Productos</h1>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" title="Volver al Dashboard">
                <i class="fas fa-arrow-left"></i>
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-custom">Agregar Producto</a>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th style="width: 120px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                style="width: 100px; height: auto;">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td class="d-flex justify-content-around">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm"
                                title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $products->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
