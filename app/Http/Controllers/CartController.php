<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validar que el producto ID esté presente en la solicitud
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::find($request->product_id);
        $cart = session()->get('cart', []);

        // Verificar si el producto ya está en el carrito
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // Agregar el producto al carrito
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image_url
            ];
        }

        // Actualizar la sesión con el carrito actualizado
        session()->put('cart', $cart);

        return response()->json(['success' => 'Producto agregado al carrito.']);
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.view', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        // Verificar si el producto está en el carrito
        if (isset($cart[$request->product_id])) {
            // Actualizar la cantidad del producto
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => 'Cantidad del producto actualizada.']);
        }

        return response()->json(['error' => 'Producto no encontrado en el carrito.'], 404);
    }

    public function removeFromCart(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = session()->get('cart', []);

        // Verificar si el producto está en el carrito
        if (isset($cart[$request->product_id])) {
            // Remover el producto del carrito
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            return response()->json(['success' => 'Producto removido del carrito.']);
        }

        return response()->json(['error' => 'Producto no encontrado en el carrito.'], 404);
    }
}
