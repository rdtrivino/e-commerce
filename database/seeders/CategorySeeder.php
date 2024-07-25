<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Category::create(['name' => 'Electronics']);
        \App\Models\Category::create(['name' => 'Clothing']);
        \App\Models\Category::create(['name' => 'Books']);
    }
}
