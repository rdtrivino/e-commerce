<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Mostrar lista de productos (paginados) en el área de administración
    public function index()
    {
        $products = Product::paginate(10); // Paginación de productos

        // Obtener la cantidad de productos en el carrito del usuario autenticado
        $cartCount = Auth::check() ? session()->get('cart', collect())->count() : 0;

        return view('products.index', compact('products', 'cartCount'));
    }

    // Mostrar formulario para crear un nuevo producto
    public function create()
    {
        $categories = Category::all(); // Obtener todas las categorías

        // Obtener la cantidad de productos en el carrito del usuario autenticado
        $cartCount = Auth::check() ? session()->get('cart', collect())->count() : 0;

        return view('products.create', compact('categories', 'cartCount'));
    }

    // Mostrar un producto específico en el área de administración
    public function show(Product $product)
    {
        // Obtener la cantidad de productos en el carrito del usuario autenticado
        $cartCount = Auth::check() ? session()->get('cart', collect())->count() : 0;

        return view('products.show', compact('product', 'cartCount')); // Mostrar vista del producto
    }

    // Mostrar un producto específico al público
    public function showPublic($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Obtener todas las categorías

        // Obtener la cantidad de productos en el carrito del usuario autenticado
        $cartCount = Auth::check() ? session()->get('cart', collect())->count() : 0;

        return view('products.show_public', compact('product', 'categories', 'cartCount'));
    }

    // Almacenar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = new Product($request->except('image_url')); // Crear el nuevo producto

        // Almacenar la imagen si existe
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('public/products'); // Almacenar en el directorio correcto
            $product->image_url = Storage::url($path); // Guardar la URL de la imagen
        }

        $product->save(); // Guardar el producto en la base de datos

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente');
    }

    // Mostrar formulario para editar un producto
    public function edit(Product $product)
    {
        $categories = Category::all(); // Obtener todas las categorías

        // Obtener la cantidad de productos en el carrito del usuario autenticado
        $cartCount = Auth::check() ? session()->get('cart', collect())->count() : 0;

        return view('products.edit', compact('product', 'categories', 'cartCount')); // Mostrar formulario de edición
    }

    // Actualizar un producto existente
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->fill($request->except('image_url')); // Actualizar los campos del producto

        // Almacenar la imagen si existe
        if ($request->hasFile('image_url')) {
            if ($product->image_url) {
                Storage::delete(str_replace('/storage', 'public', $product->image_url)); // Eliminar la imagen antigua si existe
            }

            $path = $request->file('image_url')->store('public/products'); // Almacenar la nueva imagen
            $product->image_url = Storage::url($path); // Actualizar la URL de la imagen
        }

        $product->save(); // Guardar los cambios en la base de datos

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente');
    }

    // Eliminar un producto
    public function destroy(Product $product)
    {
        // Eliminar la imagen si existe
        if ($product->image_url) {
            Storage::delete(str_replace('/storage', 'public', $product->image_url));
        }

        $product->delete(); // Eliminar el producto de la base de datos

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado exitosamente');
    }
}
