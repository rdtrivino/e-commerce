<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Mi Tienda</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .navbar {
            position: relative;
            margin-bottom: 20px;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .navbar-toggler {
            border: none;
        }

        .search-form-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 500px;
            z-index: 1;
        }

        .search-form-container .form-inline {
            display: flex;
            justify-content: center;
        }

        .navbar-brand {
            position: relative;
            z-index: 2;
        }

        .categories h2 {
            margin-top: 30px;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-transform: uppercase;
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
            width: 280px;

        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            object-fit: cover;
            height: 180px;
            /* Adjust to fit your design */
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
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 10px;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            box-shadow: none;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #007bff;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light"
        style="background: linear-gradient(to right, rgba(150, 200, 150, 0.9), rgba(255, 212, 200, 0.9)); border-radius: 10px; padding: 10px;">
        <a class="navbar-brand" href="#">Tienda Ruben</a>

        <div class="search-form-container">
            <form class="form-inline" action="{{ route('search') }}" method="GET">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar productos" aria-label="Buscar"
                    name="query" value="{{ request()->input('query') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-user"></i> INICIAR SESION
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
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
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="btn btn-primary">Ver Producto</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No hay productos en esta categoría.</p>
                        @endforelse
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            spaceBetween: 3,
            slidesPerGroup: 1,
            loop: true,
            loopFillGroupWithBlank: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 3
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 3
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 3
                }
            }
        });
    </script>
</body>

</html>
