<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Muestra todas las categorías
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Muestra el formulario para crear una nueva categoría
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
        $products = $category->products; // Asumiendo que tienes una relación de productos en tu modelo Category
        return view('categories.show', compact('category', 'products'));
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

    // Obtiene los productos de una categoría específica y los devuelve en formato JSON
    public function getProducts(Category $category)
    {
        return response()->json([
            'category' => $category,
            'products' => $category->products,
        ]);
    }

    // Cambia la categoría actual y devuelve los productos correspondientes
    public function change(Request $request)
    {
        $categoryId = $request->input('category_id');
        $category = Category::find($categoryId);

        if ($category) {
            $products = $category->products;
            return view('categories.show', compact('category', 'products'));
        }

        return redirect()->route('categories.index')->with('error', 'Categoría no encontrada.');
    }
}
