@extends('layouts.admin')

@section('content')
    <header>
        <h1>Admin Dashboard</h1>
        <nav class="admin-nav">
            <a href="{{ route('products.index') }}">Productos</a>
            <a href="{{ route('users.index') }}">Usuarios</a>
        </nav>
        <div>
            <a class="logout-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h2 class="welcome-title">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/100' }}"
                    alt="User Avatar" class="user-avatar">
                Welcome, {{ Auth::user()->name }}
            </h2>
            <p>Use the navigation menu to manage products, and users.</p>
        </div>
    </div>

    <footer>
        <p>&copy; Tienda de Rubén</p>
    </footer>
@endsection
