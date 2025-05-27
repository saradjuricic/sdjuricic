<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Bouquets', 'description' => 'Beautiful flower bouquets']);
        Category::create(['name' => 'House Plants', 'description' => 'Indoor plants for your home']);
        Category::create(['name' => 'Pots', 'description' => 'Decorative pots and planters']);
        Category::create(['name' => 'Accessories', 'description' => 'Garden tools and accessories']);
        Category::create(['name' => 'Seasonal', 'description' => 'Seasonal arrangements']);
    }
}
