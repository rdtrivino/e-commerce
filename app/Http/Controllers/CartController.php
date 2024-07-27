<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $productId)
    {
        // Lógica para agregar el producto al carrito
        $cart = Session::get('cart', []);

        // Verifica si el producto ya está en el carrito
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $product = Product::findOrFail($productId);
            $cart[$productId] = [
                'product' => $product,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Producto agregado al carrito.');
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }
}
