@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 d-flex align-items-center">
                <!-- Detalles del producto -->
                <div class="row w-100">
                    <!-- Imagen del producto -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-lg">
                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/400x400' }}" class="card-img-top"
                                alt="{{ $product->name }}">
                        </div>
                    </div>

                    <!-- Detalles del producto y formulario -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="card border-0 shadow-lg w-100">
                            <div class="card-body">
                                <h1 class="card-title mb-4 text-center">{{ $product->name }}</h1>
                                <p class="card-text mb-4">{{ $product->description }}</p>
                                <p class="card-text mb-4"><strong>Precio:</strong> ${{ number_format($product->price, 2) }}
                                </p>

                                <!-- Mostrar formulario solo si el usuario está autenticado -->
                                @auth
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form">
                                        @csrf
                                        <div class="d-flex align-items-center">
                                            <!-- Contador de cantidad -->
                                            <input type="number" id="qty" name="qty" class="form-control me-2"
                                                value="1" min="1" max="100" style="max-width: 80px;">

                                            <!-- Botón de agregar al carrito -->
                                            <button type="submit" class="btn btn-primary rounded-pill shadow-sm">
                                                <i class="bi bi-cart"></i>
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <!-- Mostrar mensaje o icono si el usuario no está autenticado -->
                                    <p class="text-danger">Debes iniciar sesión para agregar productos al carrito.</p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-img-top {
            height: 250px;
            object-fit: cover;
            border-radius: 0.5rem;
            /* Redondear bordes */
        }

        .card-body {
            text-align: left;
        }

        .btn-primary {
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            /* Tamaño del botón */
            height: 60px;
            /* Tamaño del botón */
            padding: 0;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Color de fondo en hover */
            transform: scale(1.1);
            /* Escalar el botón en hover */
        }

        .btn-primary .bi-cart {
            margin: 0;
        }

        .card {
            display: flex;
            flex-direction: column;
            border-radius: 0.75rem;
            /* Redondear bordes de la tarjeta */
            overflow: hidden;
        }

        .row {
            margin: 0;
        }

        .col-md-6 {
            display: flex;
            align-items: center;
        }

        .form-control {
            text-align: center;
        }
    </style>
    @vite(['resources/css/index_publi.css'])
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('add-to-cart-form')?.addEventListener('submit', function(event) {
            @guest
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor, inicie sesión para agregar productos al carrito.',
                footer: '<a href="{{ route('login') }}">Iniciar sesión</a>'
            });
        @endguest
        });
    </script>
@endpush
