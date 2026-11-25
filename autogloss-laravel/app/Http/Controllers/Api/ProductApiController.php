<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    /**
     * 04 REST API - GET API (List Produk)
     * HTTP 200 OK
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $products = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'message' => 'Daftar produk berhasil diambil',
            'total' => $products->count(),
            'data' => $products
        ], 200);
    }

    /**
     * 04 REST API - POST API (Create Produk Baru dengan Validasi)
     * HTTP 201 Created atau HTTP 422 Unprocessable Content
     */
    public function store(Request $request)
    {
        // 03 Validation: Required & Max Length
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:products,code',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sub_category' => 'nullable|string|max:100',
            'stock' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|string',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh melebihi 255 karakter.',
            'code.required' => 'Kode produk wajib diisi.',
            'code.max' => 'Kode produk tidak boleh melebihi 50 karakter.',
            'code.unique' => 'Kode produk sudah digunakan.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'statusCode' => 422,
                'message' => 'Validasi data produk gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['stock'] = $data['stock'] ?? 10;
        $data['unit'] = $data['unit'] ?? '1 Liter';
        $data['rating'] = 5.0;
        $data['sold_count'] = 0;

        $product = Product::create($data);
        $product->load('category');

        return response()->json([
            'status' => 'success',
            'statusCode' => 201,
            'message' => 'Produk baru berhasil disimpan ke database',
            'data' => $product
        ], 201);
    }

    /**
     * 04 REST API - GET Detail (Show Produk berdasarkan ID)
     * HTTP 200 OK atau HTTP 404 Not Found
     */
    public function show(string $id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'statusCode' => 404,
                'message' => "Produk dengan ID {$id} tidak ditemukan"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'message' => 'Detail produk berhasil diambil',
            'data' => $product
        ], 200);
    }

    /**
     * 04 REST API - UPDATE API (PUT / PATCH Produk)
     * HTTP 200 OK, 404 Not Found, atau 422 Validation Error
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'statusCode' => 404,
                'message' => "Produk dengan ID {$id} tidak ditemukan"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:products,code,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sub_category' => 'nullable|string|max:100',
            'stock' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|string',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh melebihi 255 karakter.',
            'code.required' => 'Kode produk wajib diisi.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'price.required' => 'Harga produk wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'statusCode' => 422,
                'message' => 'Validasi data pembaruan produk gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($validator->validated());
        $product->load('category');

        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'message' => 'Data produk berhasil diperbarui',
            'data' => $product
        ], 200);
    }

    /**
     * 04 REST API - DELETE API (Hapus Produk)
     * HTTP 200 OK atau HTTP 404 Not Found
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'statusCode' => 404,
                'message' => "Produk dengan ID {$id} tidak ditemukan"
            ], 404);
        }

        $productName = $product->name;
        $product->delete();

        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'message' => "Produk '{$productName}' berhasil dihapus dari database"
        ], 200);
    }
}
