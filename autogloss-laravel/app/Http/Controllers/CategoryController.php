<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource (Method Index - Week 9).
     * Eloquent ORM: withCount('products') untuk menghitung relasi.
     */
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage (CRUD - Create).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori "' . $validated['name'] . '" berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage (CRUD - Update).
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori "' . $category->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage (CRUD - Delete).
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori "' . $name . '" beserta produk di dalamnya berhasil dihapus!');
    }
}
