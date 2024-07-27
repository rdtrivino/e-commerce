<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f0f0f0, #4f4f4f);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .dashboard-info {
            margin-top: 30px;
        }

        .dashboard-info h1 {
            font-size: 24px;
            color: #333;
        }

        .dashboard-info p {
            font-size: 18px;
            color: #666;
        }

        footer {
            background: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .swiper-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            margin-right: 10px;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            width: 270px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            object-fit: cover;
            height: 180px;
            width: 100%;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .card-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            position: absolute;
            top: 50%;
            /* Centrado verticalmente */
            left: 50%;
            transform: translate(-50%, -50%);
            /* Ajuste para centrar perfectamente */
            width: 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            text-align: center;
        }

        .card-footer a {
            font-size: 24px;
            color: #007bff;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .card-footer a:hover {
            color: #0056b3;
        }

        .card-footer .fa-cart-plus {
            color: red;
            /* Color rojo para el ícono del carrito */
        }

        .card-footer .fa-search {
            color: #333;
            /* Color negro para el ícono de la lupa */
        }

        .card:hover .card-footer {
            opacity: 1;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .cart-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .cart-button:hover {
            background-color: #0056b3;
        }

        /* Estilos para los botones de navegación del Swiper */
        .swiper-button-next,
        .swiper-button-prev {
            color: #007bff;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .swiper-button-next {
            right: 10px;
        }

        .swiper-button-prev {
            left: 10px;
        }


        .swiper-button-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Estilos adicionales para el avatar y el saludo */
        .avatar-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .welcome-message h1 {
            font-size: 10px;
            color: #333;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light"
        style="background: linear-gradient(to right, rgba(150, 200, 150, 0.9), rgba(255, 212, 200, 0.9)); border-radius: 10px; padding: 10px;">
        <div class="profile-header">
            <div class="avatar">
                <img src="{{ $user->avatar_url }}" alt="Avatar">
            </div>
            <h1>Bienvenido, {{ $user->name }}!</h1>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="container">

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="search-bar">
            <form action="{{ route('search') }}" method="GET" class="form-inline">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="Buscar productos"
                    aria-label="Buscar">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </div>

        <div class="text-center mb-4">
            <h1>Bienvenido a Mi Tienda</h1>
        </div>

        <div class="categories">
            @foreach ($categories as $category)
                <h2>{{ $category->name }}</h2>

                <!-- Swiper -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($category->products as $product)
                            <div class="swiper-slide">
                                <div class="card">
                                    <img src="{{ $product->image_url }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                        <p class="card-text">${{ $product->price }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('products.show', $product->id) }}" <a href="#"
                                            class="fa fa-cart-plus" onclick="addToCart({{ $product->id }})"></a>
                                        <a href="#" class="fa fa-search"></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No hay productos en esta categoría.</p>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            @endforeach
        </div>
    </div>
    </div>

    <footer>
        <p>&copy; 2024 Mi Tienda. Todos los derechos reservados. <a href="#">Política de privacidad</a> | <a
                href="#">Términos y condiciones</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        // Initializing Swiper
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        function addToCart(productId) {
            console.log('Producto agregado al carrito:', productId);
        }
    </script>
</body>

</html>
