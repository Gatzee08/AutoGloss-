<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class JwtAuthenticationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Pastikan demo user tersedia
        User::firstOrCreate(['email' => 'user@example.com'], [
            'name' => 'Demo User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        Program::firstOrCreate(['name' => 'Program A'], [
            'name' => 'Program A',
            'description' => 'Test Program A',
        ]);
    }

    /**
     * Step 01: POST /api/login berhasil dan mengembalikan access_token
     */
    public function test_01_login_successful_returns_jwt_token(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'email']
            ])
            ->assertJson([
                'token_type' => 'bearer'
            ]);

        $this->assertNotEmpty($response->json('access_token'));
    }

    /**
     * POST /api/login ditolak jika password salah
     */
    public function test_01_login_invalid_password_returns_401(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthorized'
            ]);
    }

    /**
     * Step 03: GET /api/programs berhasil (200 OK) dengan Bearer Token valid
     */
    public function test_03_get_programs_with_valid_bearer_token(): void
    {
        // Login terlebih dahulu
        $loginRes = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $token = $loginRes->json('access_token');

        // Request ke protected route
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/programs');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name']
                ]
            ]);
    }

    /**
     * Step 04: GET /api/programs tanpa token ditolak (401 Unauthorized)
     */
    public function test_04_get_programs_without_token_returns_401_unauthorized(): void
    {
        $response = $this->getJson('/api/programs');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthorized'
            ]);
    }

    /**
     * Step 05: GET /api/programs dengan token invalid ditolak (401 Token invalid)
     */
    public function test_05_get_programs_with_invalid_token_returns_401_token_invalid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer invalidtoken')
            ->getJson('/api/programs');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Token invalid'
            ]);
    }
}
