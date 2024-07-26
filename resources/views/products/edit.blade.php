<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div id="app">
        <h1>Edit Product</h1>
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $product->name }}" required>
            <label for="price">Price</label>
            <input type="number" name="price" id="price" value="{{ $product->price }}" required>
            <button type="submit">Update</button>
        </form>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
