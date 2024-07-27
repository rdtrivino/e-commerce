<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Ruta de inicio
Route::get('/', [ProductController::class, 'index'])->name('home');

// Dashboard para Usuario
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'role:user'])
    ->name('user.dashboard');

// Rutas de autenticación
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Ruta de búsqueda
Route::get('search', [ProductController::class, 'search'])->name('search');

// Rutas de recursos de productos
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class)->names([
        'index' => 'products.index',
        'create' => 'products.create',
        'store' => 'products.store',
        'show' => 'products.show',
        'edit' => 'products.edit',
        'update' => 'products.update',
        'destroy' => 'products.destroy',
    ]);

    // Rutas de recursos de categorías
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'show' => 'categories.show',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);

    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category');

    // Rutas de recursos de órdenes
    Route::resource('orders', OrderController::class)->names([
        'index' => 'orders.index',
        'create' => 'orders.create',
        'store' => 'orders.store',
        'show' => 'orders.show',
        'edit' => 'orders.edit',
        'update' => 'orders.update',
        'destroy' => 'orders.destroy',
    ]);

    // Rutas de recursos de ítems de órdenes
    Route::resource('order-items', OrderItemController::class)->names([
        'index' => 'order-items.index',
        'create' => 'order-items.create',
        'store' => 'order-items.store',
        'show' => 'order-items.show',
        'edit' => 'order-items.edit',
        'update' => 'order-items.update',
        'destroy' => 'order-items.destroy',
    ]);

    // Ruta para actualizar el avatar del usuario
    Route::put('/user/avatar', [UserController::class, 'updateAvatar'])->name('user.update.avatar');

    // Rutas de recursos de usuarios
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
});

// Dashboard para Administrador
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Rutas del carrito de compras
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
