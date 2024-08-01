<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 1000), // Precio entre 5 y 1000
            'stock' => $this->faker->numberBetween(1, 100), // Stock entre 1 y 100
            'category_id' => Category::inRandomOrder()->first()->id, // Categoría aleatoria
        ];
    }
}

