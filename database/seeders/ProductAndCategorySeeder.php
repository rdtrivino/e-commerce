<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductAndCategorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Crear categorías
        $categories = [
            'Electronics',
            'Books',
            'Clothing',
            'Home & Kitchen',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Obtener IDs de categorías
        $categoryIds = Category::pluck('id')->toArray();

        // Crear productos aleatorios para cada categoría
        foreach ($categoryIds as $categoryId) {
            for ($i = 0; $i < 6; $i++) {
                Product::create([
                    'name' => $faker->word,
                    'description' => $faker->sentence,
                    'price' => $faker->randomFloat(2, 5, 1000), // Precio entre 5 y 1000
                    'stock' => $faker->numberBetween(1, 100), // Stock entre 1 y 100
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
