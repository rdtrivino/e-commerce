<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
// ProductSeeder.php
public function run()
{
    \App\Models\Product::create([
        'name' => 'Laptop',
        'description' => 'High performance laptop',
        'price' => 999.99,
        'stock' => 10,
        'category_id' => 1
    ]);

    \App\Models\Product::create([
        'name' => 'T-Shirt',
        'description' => 'Cotton T-shirt',
        'price' => 19.99,
        'stock' => 100,
        'category_id' => 2
    ]);
}
}
