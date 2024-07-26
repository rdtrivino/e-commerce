<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div id="app">
        <h1>Create Product</h1>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
            <label for="price">Price</label>
            <input type="number" name="price" id="price" required>
            <button type="submit">Save</button>
        </form>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
