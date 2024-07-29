<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
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

        return response()->json(['success' => 'Producto añadido al carrito.']);
    }

    public function count(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        $count = $cart ? $cart->items->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }

    public function items(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        $items = $cart ? $cart->items->map(function ($item) {
            return [
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ];
        }) : [];

        return response()->json(['items' => $items]);
    }
}
