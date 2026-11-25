<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ProgramController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - AutoGloss Paint Hub
|--------------------------------------------------------------------------
| Materi Week 10: Application Flow & Full REST API CRUD + Validation + HTTP Status
| Materi Week 11: JWT Authentication (Task 03 - Postman & Insomnia)
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. WEEK 10: FULL REST API RESOURCE (GET, POST, PUT/PATCH, DELETE)
// =========================================================================
// Mencakup: GET list, POST create, GET detail, PUT/PATCH update, DELETE destroy
// Mengimplementasikan Validasi (Required, Max Length, 422 Error) & Status HTTP (200, 201, 404, 422)
Route::apiResource('products', ProductApiController::class);


// =========================================================================
// 2. WEEK 11: AUTHENTICATION (PUBLIC)
// =========================================================================
// POST /api/login - Sesuai Slide 1 Step 01
Route::post('/login', [AuthController::class, 'login'])->name('api.login');


// =========================================================================
// 3. WEEK 11: PROTECTED ROUTES (Memerlukan Bearer Token via jwt.auth)
// =========================================================================
Route::middleware('jwt.auth')->group(function () {

    // GET /api/programs - Sesuai Slide 1 Step 03, 04, 05
    Route::get('/programs', [ProgramController::class, 'index'])->name('api.programs');
    Route::post('/programs', [ProgramController::class, 'store'])->name('api.programs.store');

    // GET /api/user & POST /api/logout
    Route::get('/user', [AuthController::class, 'me'])->name('api.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    // Protected Orders API
    Route::get('/orders', function () {
        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'message' => 'Daftar pesanan berhasil dimuat',
            'data' => Order::with('customer', 'items')->latest()->get()
        ]);
    })->name('api.orders');
});
