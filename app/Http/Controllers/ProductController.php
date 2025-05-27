<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)->take(6)->get();
        return view('home', compact('featuredProducts'));
    }

    public function catalog()
    {
        $products = Product::with('category')->paginate(9);
        $categories = Category::all();
        return view('products.catalog', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
