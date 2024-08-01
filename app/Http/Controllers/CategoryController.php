<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        $category = null;
        $products = collect(); // Usamos collect() para inicializar como una colección vacía

        if ($categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $products = $category->products; // Obtener productos de la categoría seleccionada
            } else {
                // Manejar el caso en que la categoría no existe, si es necesario
                $products = collect(); // Asegurarse de que $products sea una colección vacía si no hay categoría
            }
        } else {
            // Si no hay categoría seleccionada, puedes elegir mostrar todos los productos, o bien, dejar vacío
            // Ejemplo: $products = Product::all(); si quieres mostrar todos los productos
        }

        $categories = Category::all(); // Obtener todas las categorías para el dropdown

        return view('index', compact('categories', 'products', 'category'));
    }
    public function create()
    {
        return view('categories.create');
    }

    // Guarda una nueva categoría en la base de datos
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index');
    }

    // Muestra una categoría específica junto con sus productos
    public function show(Category $category)
    {
        $products = $category->products;
        return view('index', compact('category', 'products'));
    }

    // Muestra el formulario para editar una categoría existente
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Actualiza una categoría existente en la base de datos
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index');
    }

    // Elimina una categoría existente de la base de datos
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }

    // Muestra los productos de una categoría específica
    public function showCategoryProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products;

        return view('category.products', compact('category', 'products'));
    }

    // Obtiene los productos de una categoría específica y los devuelve en formato JSON
    public function getProducts(Category $category)
    {
        return response()->json([
            'category' => $category,
            'products' => $category->products,
        ]);
    }
}
