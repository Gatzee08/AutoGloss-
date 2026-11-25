<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\JwtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * POST /api/login - Otentikasi Pengguna & Pembuatan JWT Token
     * Sesuai alur Task 03 Slide 1 Step 01
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        // Verifikasi kredensial
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Pembuatan JWT
        $token = $this->jwtService->generateToken($user);

        // Respons JSON sesuai standar Postman / Insomnia di materi slide
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ], 200);
    }

    /**
     * GET /api/user - Mendapatkan data pengguna yang sedang login (Protected)
     */
    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user()
        ], 200);
    }

    /**
     * POST /api/logout - Logout sesi API
     */
    public function logout()
    {
        return response()->json([
            'message' => 'Logout berhasil'
        ], 200);
    }
}
