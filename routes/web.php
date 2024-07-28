<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Ruta de la página de inicio
Route::get('/', [IndexController::class, 'index'])->name('home');

// Ruta para mostrar un producto público
Route::get('products/public/{id}', [ProductController::class, 'showPublic'])->name('products.showPublic');

// Rutas de autenticación
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Ruta de búsqueda
Route::get('/search/live', function (Request $request) {
    $query = $request->input('query');
    $products = Product::where('name', 'like', "%{$query}%")
        ->orWhere('description', 'like', "%{$query}%")
        ->get();

    return response()->json(['products' => $products]);
})->name('search.live');

// Ruta para cambiar de categoría y mostrar productos
Route::get('/categories/change', [CategoryController::class, 'change'])->name('categories.change');

// Ruta para obtener productos de una categoría específica
Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts']);

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Dashboard para Usuario
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->middleware('role:user')
        ->name('user.dashboard');

    // Rutas de recursos de productos
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

    // Ruta para mostrar una categoría específica
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

    // Dashboard para Administrador
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    // Rutas del carrito de compras
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/order/create', [OrderController::class, 'createOrder'])->name('order.create');
});
