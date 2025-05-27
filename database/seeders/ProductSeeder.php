<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Red Rose Bouquet', 'description' => 'Classic red roses', 'price' => 29.99, 'category_id' => 1, 'featured' => true, 'stock' => 10],
            ['name' => 'Spring Mix Bouquet', 'description' => 'Colorful spring flowers', 'price' => 24.99, 'category_id' => 1, 'featured' => false, 'stock' => 15],
            ['name' => 'Snake Plant', 'description' => 'Low maintenance house plant', 'price' => 19.99, 'category_id' => 2, 'featured' => true, 'stock' => 8],
            ['name' => 'Fiddle Leaf Fig', 'description' => 'Popular indoor tree', 'price' => 49.99, 'category_id' => 2, 'featured' => false, 'stock' => 5],
            ['name' => 'Ceramic Pot White', 'description' => 'Modern white ceramic pot', 'price' => 15.99, 'category_id' => 3, 'featured' => false, 'stock' => 20],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
