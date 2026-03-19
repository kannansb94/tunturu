<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('library.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('library.admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        } else {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['slug']);
        }

        Category::create($validated);

        return redirect()->route('library.admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('library.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        } else {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['slug']);
        }

        $oldName = $category->name;
        $category->update($validated);

        if ($oldName !== $category->name) {
            \App\Models\Book::where('category', $oldName)->update(['category' => $category->name]);
        }

        return redirect()->route('library.admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $oldName = $category->name;
        $category->delete();

        // Assign books to 'Other' if their category is deleted (or just leave them, but 'Other' is safer for counts)
        \App\Models\Book::where('category', $oldName)->update(['category' => 'Other']);

        return redirect()->route('library.admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
