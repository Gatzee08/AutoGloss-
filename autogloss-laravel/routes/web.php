<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - AutoGloss Paint Hub (Materi Week 9: CRUD + ORM)
|--------------------------------------------------------------------------
*/

// 1. Dashboard / Beranda Utama (Method Index)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Resource Route Produk (CRUD Lengkap: Index, Create, Store, Show, Edit, Update, Destroy)
Route::resource('products', ProductController::class);

// 3. Resource Route Kategori (CRUD Lengkap)
Route::resource('categories', CategoryController::class);

// 4. Resource Route Pelanggan (CRUD Lengkap)
Route::resource('customers', CustomerController::class);

// 5. Resource Route Pesanan & Verifikasi Pembayaran
Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);
Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

// 6. Endpoint REST API Produk (Kompatibel dengan fetch() Frontend SPA sebelumnya)
Route::get('/api/products', function () {
    $products = \App\Models\Product::with('category')->get();
    return response()->json([
        'status' => 'success',
        'statusCode' => 200,
        'message' => 'REST API AutoGloss Laravel ORM: Data produk berhasil dimuat',
        'total' => $products->count(),
        'data' => $products
    ]);
});
