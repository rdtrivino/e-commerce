<?php

use App\Http\Controllers\{
    IndexController,
    ProductController,
    CategoryController,
    UserController,
    Auth\RegisteredUserController,
    Auth\PasswordResetLinkController,
    Auth\AuthenticatedSessionController,
    CartController,
    UserDashboardController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// Ruta de la página de inicio
Route::get('/', [IndexController::class, 'index'])->name('index');

// Rutas de productos
Route::get('/products/{id}', [ProductController::class, 'showPublic'])->name('products.showPublic');

// Rutas para el área de administración de productos
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Ruta de búsqueda
Route::get('/search/live', function (Request $request) {
    $query = $request->input('query');
    $products = Product::where('name', 'like', "%{$query}%")
        ->orWhere('description', 'like', "%{$query}%")
        ->get();

    return response()->json(['products' => $products]);
})->name('search.live');

// Rutas de categorías
Route::get('/category/{id}', [CategoryController::class, 'showCategoryProducts'])->name('category.products');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/categories/change', [CategoryController::class, 'change'])->name('categories.change');
Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts'])->name('category.products.list');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
});

// Ruta para el logout
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Dashboard para usuarios
    Route::middleware('role:user')->group(function () {
        Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    });

    // Dashboard para administradores
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    // Rutas del carrito
    Route::prefix('cart')->group(function () {
        Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // Rutas de recursos para usuarios
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    Route::put('/user/avatar', [UserController::class, 'updateAvatar'])->name('user.update.avatar');
});
