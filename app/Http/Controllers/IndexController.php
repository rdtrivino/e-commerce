<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $products = $query
            ? Product::where('name', 'like', "%{$query}%")->get()
            : Product::limit(6)->get(); // Obtener un límite de productos destacados si no hay búsqueda

        return view('index', compact('products'));
    }
}
