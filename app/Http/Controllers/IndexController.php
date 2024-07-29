<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Obtener productos basados en la búsqueda o productos destacados
        $products = $query
            ? Product::where('name', 'like', "%{$query}%")->get()
            : Product::limit(6)->get(); // Obtener un límite de productos destacados si no hay búsqueda

        // Obtener todas las categorías
        $categories = Category::all();

        // Pasar productos y categorías a la vista
        return view('index', compact('products', 'categories'));
    }
}
