<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->paginate(15);
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
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'display_order' => $request->display_order ?? 0,
            'is_active' => $request->input('is_active', 0) == 1,
        ];

        if ($request->hasFile('icon_url')) {
            $data['icon_url'] = $request->file('icon_url')->store('category-icons', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'display_order' => $request->display_order ?? 0,
            'is_active' => $request->input('is_active', 0) == 1,
        ];

        if ($request->hasFile('icon_url')) {
            if ($category->icon_url) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->icon_url);
            }
            $data['icon_url'] = $request->file('icon_url')->store('category-icons', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->icon_url) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($category->icon_url);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
