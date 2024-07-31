<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css'])
</head>

<body>
    <div id="app">
        <div class="container mt-4">
            <nav class="navbar navbar-expand-lg navbar-light"
                style="background: linear-gradient(to right, rgba(173, 211, 249, 0.9), rgba(234, 227, 225, 0.9)); border-radius: 10px; padding: 10px;">
                <a class="navbar-brand" href="{{ url('/') }}">Tienda Ruben</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if (Auth::user()->hasRole('admin'))
                                <!-- Menú para administradores -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('products.index') }}">Productos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('categories.index') }}">Categorías</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                                </li>
                            @else
                                <!-- Menú desplegable para usuarios normales -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-list"></i> Categorías
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('index', ['category_id' => $category->id, 'query' => request()->input('query')]) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-person"></i> {{ __('Iniciar Sesión') }}
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                            <!-- Menú de usuario autenticado -->
                            @if (!Auth::user()->hasRole('admin'))
                                <!-- Enlace al carrito (solo para usuarios normales) -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('cart.index') }}">
                                        <i class="bi bi-cart"></i> Carrito
                                        <span class="badge bg-primary">{{ $cartCount }}</span>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="rounded-circle"
                                        width="30" height="30">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @vite(['resources/js/app.js'])
</body>

</html>
