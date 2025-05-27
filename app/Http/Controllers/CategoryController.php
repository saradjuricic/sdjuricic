<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // Load products for this category
        $category->load('products');
        
        return view('categories.show', compact('category'));
    }
}