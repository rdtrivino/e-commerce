<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        return view('index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all(); // Obtener todas las categorías para el formulario de creación
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        // Crear un nuevo producto con la categoría asociada
        Product::create($request->validated());
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); // Obtener todas las categorías para el formulario de edición
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        // Actualizar el producto con los datos proporcionados
        $product->update($request->validated());
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
