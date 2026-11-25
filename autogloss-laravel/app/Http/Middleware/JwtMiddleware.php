<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    protected JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle an incoming request for JWT Authentication.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Periksa header Authorization Bearer Token
        $token = $request->bearerToken();

        // Jika header Authorization tidak ada sama sekali atau kosong
        if (empty($token)) {
            // Periksa juga jika ada header Authorization non-bearer atau kosong
            $authHeader = $request->header('Authorization');
            if (empty($authHeader)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Jika ada format selain "Bearer <token>"
            if (!str_starts_with($authHeader, 'Bearer ')) {
                return response()->json([
                    'message' => 'Token invalid'
                ], 401);
            }

            $token = trim(substr($authHeader, 7));
            if (empty($token)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        }

        // 2. Validasi Token JWT
        $validation = $this->jwtService->validateToken($token);

        if (!$validation['valid']) {
            return response()->json([
                'message' => 'Token invalid'
            ], 401);
        }

        // 3. Ambil data user dari payload JWT
        $userId = $validation['payload']['sub'] ?? null;
        $user = $userId ? User::find($userId) : null;

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        // 4. Set konteks autentikasi
        Auth::setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
