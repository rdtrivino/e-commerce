@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <nav class="navbar navbar-expand-lg navbar-light"
            style="background: linear-gradient(to right, rgba(150, 200, 150, 0.9), rgba(255, 212, 200, 0.9)); border-radius: 10px; padding: 10px;">
            <a class="navbar-brand" href="#">Tienda Ruben</a>

            <div class="search-form-container">
                <form class="form-inline" id="search-form" action="{{ route('search.live') }}" method="GET">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar productos" aria-label="Buscar"
                        name="query" id="search-input" value="{{ request()->input('query') }}">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i
                            class="fa fa-search"></i></button>
                </form>
                <div id="search-results" class="mt-3"></div>
            </div>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user"></i> INICIAR SESIÓN
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="text-center mb-4">
            <h1> Mi Tienda</h1>
        </div>

        <div class="categories" id="product-list">
            @foreach ($categories as $category)
                <h2 class="category-name">{{ $category->name }}</h2>

                <div class="swiper-container">
                    <div class="swiper-wrapper" id="categories-container">
                        @forelse($category->products as $product)
                            <div class="swiper-slide">
                                <div class="card">
                                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                        <p class="card-text">${{ $product->price }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('products.showPublic', $product->id) }}"
                                            class="btn btn-primary">Ver Producto</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No hay productos en esta categoría.</p>
                        @endforelse
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            @endforeach
        </div>

        <footer class="text-center mt-4">
            <p>&copy; 2024 Tienda Ruben. Todos los derechos reservados.</p>
        </footer>
    </div>
    <script>
        const searchLiveUrl = '{{ route('search.live') }}';
        const productsPublicUrl = '{{ url('products/public') }}';
    </script>
@endsection
