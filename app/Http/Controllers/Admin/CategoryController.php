<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('created_at', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000'
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $category->load('products');
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000'
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category that contains products. Please move or delete all products first.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}