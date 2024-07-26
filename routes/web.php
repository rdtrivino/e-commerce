<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Ruta de inicio
Route::get('/', [ProductController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Ruta de búsqueda
Route::get('search', [ProductController::class, 'search'])->name('search');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::resource('users', UserController::class);
});

// Dashboard para Administrador
Route::middleware('role:admin')->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Dashboard para Usuario
Route::middleware('role:user')->get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');
