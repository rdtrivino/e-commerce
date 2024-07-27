<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        nav {
            margin: 10px 0;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('products.index') }}">Productos</a>
            <a href="{{ route('categories.index') }}">Categories</a>
            <a href="{{ route('orders.index') }}">Orders</a>
            <a href="{{ route('users.index') }}">Users</a>
            <a href="{{ route('logout') }}">Logout</a>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Use the navigation menu to manage products, categories, orders, and users.</p>
        </div>
    </div>
</body>

</html>
