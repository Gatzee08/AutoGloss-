<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JwtPlaygroundController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Week10Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - AutoGloss Paint Hub
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

// 6. Halaman Interaktif Week 10: Application Flow & REST API CRUD + Validation
Route::get('/week10', [Week10Controller::class, 'index'])->name('week10.flow');

// 7. Halaman Interaktif Pengujian JWT Authentication (Week 11 Task 03)
Route::get('/jwt-testing', [JwtPlaygroundController::class, 'index'])->name('jwt.testing');
