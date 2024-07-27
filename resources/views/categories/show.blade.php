<!-- resources/views/categories/show.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details</title>
    <!-- Puedes agregar CSS aquí -->
</head>

<body>
    <h1>Category Details</h1>

    <!-- Mostrar detalles de la categoría -->
    <h2>Category: {{ $category->name }}</h2>
    <p>{{ $category->description }}</p>

    <!-- Mostrar productos asociados -->
    <h3>Products in this Category:</h3>
    <ul>
        @forelse($products as $product)
            <li>{{ $product->name }} - ${{ $product->price }}</li>
        @empty
            <li>No products found.</li>
        @endforelse
    </ul>

    <a href="{{ route('categories.index') }}">Back to Categories</a>

    <!-- Puedes agregar más contenido aquí -->
</body>

</html>
