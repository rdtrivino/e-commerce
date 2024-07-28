@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1 class="mb-0">Category Details</h1>
            </div>
            <div class="card-body">
                <!-- Mostrar detalles de la categoría -->
                <div class="mb-4">
                    <h2 class="h4">Category: {{ $category->name }}</h2>
                    <p>{{ $category->description }}</p>
                </div>

                <!-- Mostrar productos asociados -->
                <div class="mb-4">
                    <h3 class="h5">Products in this Category:</h3>
                    <ul class="list-group">
                        @forelse($products as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $product->name }}
                                <span class="badge bg-primary rounded-pill">${{ $product->price }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">No products found.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="text-center">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
                </div>
            </div>
        </div>
    </div>
@endsection
