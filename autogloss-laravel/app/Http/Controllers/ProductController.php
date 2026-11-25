<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource (Method Index - Week 9).
     * Memanfaatkan Eloquent ORM: Eager Loading relasi kategori, filter & pencarian.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Pencarian berdasarkan nama produk atau kode produk
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('sub_category', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter promo
        if ($request->filled('is_promo')) {
            $query->where('is_promo', true);
        }

        $products = $query->latest()->paginate(8)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage (CRUD - Create).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:products,code',
            'name' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|url',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $validated['is_promo'] = $request->has('is_promo') || (!empty($validated['discount_percent']) && $validated['discount_percent'] > 0);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk cat "' . $validated['name'] . '" berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage (CRUD - Update).
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|url',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $validated['is_promo'] = $request->has('is_promo') || (!empty($validated['discount_percent']) && $validated['discount_percent'] > 0);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Data produk "' . $product->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage (CRUD - Delete).
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk "' . $name . '" berhasil dihapus dari database!');
    }
}
