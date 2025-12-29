<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
    
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::insert([
            ['name' => 'Laptops', 'slug' => 'laptops', 'is_active' => true],
            ['name' => 'Smartphones', 'slug' => 'smartphones', 'is_active' => true],
            ['name' => 'Accessories', 'slug' => 'accessories', 'is_active' => true],
        ]);

    }
}
