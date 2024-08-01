@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="text-center mb-3">
            <h1 class="display-4 font-weight-bold">Mi Tienda</h1>
            <p class="lead text-muted">Encuentra los mejores productos aquí</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <form action="{{ route('index') }}" method="GET">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Buscar productos" aria-label="Buscar"
                            name="query" id="search-input" value="{{ request()->input('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary search-btn" type="submit">
                                <i class="bi bi-search" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div id="search-results" class="mt-3"></div>
            </div>
        </div>
        @if ($products->isNotEmpty())
            <div class="mb-5">
                @if ($categoryId)
                    <h2 class="text-primary font-weight-bold mb-3">Categoría: {{ $categories->find($categoryId)->name }}
                    </h2>
                @else
                    <h2 class="text-primary font-weight-bold mb-3">Todos los Productos</h2>
                @endif

                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm border-light rounded">
                                <div class="card-img-wrapper" style="position: relative; overflow: hidden; height: 200px;">
                                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                                    <p class="card-text font-weight-bold text-primary">${{ $product->price }}</p>
                                    <div class="d-flex justify-content-center">
                                        @auth
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="me-2">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-cart" style="font-size: 1.2rem;"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-danger btn-sm me-2" onclick="showLoginAlert();">
                                                <i class="bi bi-cart" style="font-size: 1rem;"></i>
                                            </button>
                                        @endauth
                                        <a href="{{ route('products.showPublic', $product->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye" style="font-size: 1rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-muted">No hay productos disponibles.</p>
        @endif

        <footer class="text-center mt-5">
            <p>&copy; 2024 Tienda Ruben. Todos los derechos reservados.</p>
        </footer>
    </div>

    @vite(['resources/css/index_publi.css'])

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function showLoginAlert() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Por favor, inicie sesión para agregar productos al carrito.',
                });
            }
        </script>
    @endpush
@endsection
