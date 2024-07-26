<?php

use App\Http\Controllers\ProductController as ApiProductController;
use App\Http\Controllers\CategoryController as ApiCategoryController;
use App\Http\Controllers\OrderController as ApiOrderController;
use App\Http\Controllers\OrderItemController as ApiOrderItemController;
use Illuminate\Support\Facades\Route;

// Define API routes with Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ApiProductController::class);
    Route::apiResource('categories', ApiCategoryController::class);
    Route::apiResource('orders', ApiOrderController::class);
    Route::apiResource('order-items', ApiOrderItemController::class);
});
