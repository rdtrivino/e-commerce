<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = new Product($request->all());

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('public/images');
            $product->image_url = Storage::url($path);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    public function showPublic($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $cartCount = $this->getCartCount();

        return view('products.show_public', compact('product', 'categories', 'cartCount'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->fill($request->all());

        if ($request->hasFile('image_url')) {
            if ($product->image_url) {
                Storage::delete(str_replace('/storage', 'public', $product->image_url));
            }

            $path = $request->file('image_url')->store('public/images');
            $product->image_url = Storage::url($path);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        if ($product->image_url) {
            Storage::delete(str_replace('/storage', 'public', $product->image_url));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
    }

    private function getCartCount()
    {
        return Cart::getTotalQuantity();
    }
}
