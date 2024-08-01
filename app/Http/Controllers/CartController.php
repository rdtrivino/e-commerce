<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('cart.index')->with('error', 'Producto no encontrado');
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->input('qty', 1),
            'attributes' => ['image' => $product->image_url], // Asegúrate de usar 'image_url' si es el nombre de tu campo
        ]);

        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito');
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $cartItems = Cart::getContent();
        $total = Cart::getTotal();
        $cartCount = Cart::getTotalQuantity();

        return view('cart.index', compact('cartItems', 'total', 'categories', 'cartCount'));
    }

    public function update(Request $request, $id)
    {
        Cart::update($id, [
            'quantity' => $request->input('qty')
        ]);

        return redirect()->route('cart.index')->with('success', 'Cantidad actualizada');
    }

    public function remove($id)
    {
        Cart::remove($id);

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito');
    }

    public function clear()
    {
        Cart::clear();

        return redirect()->route('cart.index')->with('success', 'Carrito vacío');
    }
}
