<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductAndCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Electronics',
            'Books',
            'Clothing',
            'Home & Kitchen',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        $categoryIds = Category::pluck('id')->toArray();


        foreach ($categoryIds as $categoryId) {
            Product::factory()->count(6)->create([
                'category_id' => $categoryId,
            ]);
        }
    }
}

