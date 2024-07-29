<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product; 

class UserDashboardController extends Controller
{
    public function index()
    {
        // Obtén el usuario autenticado
        $user = Auth::user();

        // Obtén las categorías y sus productos
        $categories = Category::with('products')->get();

        // Obtén todos los productos (o puedes aplicar un filtro si es necesario)
        $products = Product::all();

        // Pasa el usuario, las categorías y los productos a la vista
        return view('users.dashboard', compact('user', 'categories', 'products'));
    }
}
