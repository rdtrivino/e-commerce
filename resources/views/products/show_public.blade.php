<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f0f0f0, #4f4f4f);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .product-details {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
            text-align: center;
        }

        .product-details img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-details h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .product-details p {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .product-details .price {
            font-size: 1.5rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div class="product-details">
        <h1>{{ $product->name }}</h1>
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        <p>{{ $product->description }}</p>
        <p class="price">Precio: ${{ $product->price }}</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Volver al catálogo</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
