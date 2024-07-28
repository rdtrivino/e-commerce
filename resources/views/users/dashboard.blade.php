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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categorías
                        </a>
                        <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                            @foreach ($categories as $category)
                                <a class="dropdown-item category-item" href="#"
                                    data-id="{{ $category->id }}">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('orders.index') }}">Mis Órdenes</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-user"></i> INICIAR SESIÓN
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <div class="text-center mb-4">
            <h1>Mi Tienda</h1>
        </div>

        <div class="text-center mb-4">
            <h2 id="category-name">{{ $categories->isNotEmpty() ? $categories->first()->name : '' }}</h2>
        </div>

        <div class="row" id="product-list">
            @if ($categories->isNotEmpty())
                @php
                    $category = $categories->first();
                @endphp
                @forelse($category->products as $product)
                    <div class="col-md-4 mb-4 product-item">
                        <div class="card">
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="card-text">${{ $product->price }}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('products.showPublic', $product->id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-success add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No hay productos en esta categoría.</p>
                @endforelse
            @else
                <p>No hay categorías disponibles.</p>
            @endif
        </div>

        <footer class="text-center mt-4">
            <p>&copy; 2024 Tienda Ruben. Todos los derechos reservados.</p>
        </footer>

        <!-- Botón del carrito flotante -->
        <button class="btn btn-primary cart-btn" data-toggle="modal" data-target="#cartModal">
            <i class="fas fa-shopping-cart"></i> <span class="badge badge-light" id="cart-count">0</span>
        </button>

        <!-- Modal del carrito -->
        <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Carrito de Compras</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group" id="cart-items">
                            <li class="list-group-item">No hay productos en el carrito.</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cart-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            border-radius: 50%;
            padding: 15px;
            font-size: 18px;
        }
    </style>
@endsection
