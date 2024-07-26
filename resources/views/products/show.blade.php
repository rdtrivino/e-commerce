<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Product</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div id="app">
        <h1>Product Details</h1>
        <p>Name: {{ $product->name }}</p>
        <p>Price: {{ $product->price }}</p>
        <a href="{{ route('products.edit', $product) }}">Edit</a>
        <form action="{{ route('products.destroy', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
