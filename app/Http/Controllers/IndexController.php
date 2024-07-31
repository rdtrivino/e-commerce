<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el ID de la categoría y la consulta de búsqueda desde la solicitud
        $categoryId = $request->input('category_id');
        $query = $request->input('query');

        // Obtener todas las categorías
        $categories = Category::all();

        // Construir la consulta de productos
        $productsQuery = Product::query();

        if ($query) {
            // Filtrar productos por nombre o descripción si hay una consulta de búsqueda
            $productsQuery->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
        }

        if ($categoryId) {
            // Filtrar productos por categoría si se ha seleccionado una categoría
            $productsQuery->where('category_id', $categoryId);
        }

        // Obtener los productos
        $products = $productsQuery->get();

        // Obtener el conteo del carrito
        $cartCount = Cart::getTotalQuantity();

        // Pasar variables a la vista
        return view('index', [
            'products' => $products,
            'categories' => $categories,
            'categoryId' => $categoryId,
            'query' => $query,
            'cartCount' => $cartCount, // Asegúrate de pasar esta variable
        ]);
    }
}
