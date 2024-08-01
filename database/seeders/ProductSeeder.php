<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Obtiene todas las categorías
        $categories = Category::all();

        foreach ($categories as $category) {
            // Crea 5 productos para cada categoría usando la fábrica
            Product::factory()->count(5)->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
