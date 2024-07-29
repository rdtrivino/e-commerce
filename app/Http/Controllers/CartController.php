<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    // Método para agregar un producto al carrito
    public function add(Request $request)
    {
        $user = $request->user();
        $product = Product::findOrFail($request->input('product_id'));

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return response()->json(['success' => true]);
    }

    // Método para obtener el conteo de productos en el carrito
    public function count(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        $count = $cart ? $cart->items->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }

    // Método para obtener los elementos del carrito
    public function items(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        $items = $cart ? $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'image' => $item->product->image_path,
            ];
        }) : [];

        $total = $items->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return response()->json(['items' => $items, 'total' => $total]);
    }

    // Método para actualizar la cantidad de un producto en el carrito
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $quantityChange = $request->input('quantity_change');

        if ($quantityChange === 'increase') {
            $cartItem->increment('quantity');
        } elseif ($quantityChange === 'decrease') {
            $cartItem->decrement('quantity');

            // Elimina el artículo si la cantidad se reduce a 0 o menos
            if ($cartItem->quantity <= 0) {
                $cartItem->delete();
            }
        }

        return response()->json(['success' => true]);
    }

    // Método para eliminar un producto del carrito
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return response()->json(['success' => true]);
    }

    // Método para vaciar el carrito
    public function clear(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json(['success' => true]);
    }
}
