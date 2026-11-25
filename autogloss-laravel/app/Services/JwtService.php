<?php

namespace App\Services;

use App\Models\User;

class JwtService
{
    protected string $secret;
    protected string $algo;

    public function __construct()
    {
        $this->secret = config('app.jwt_secret') 
            ?: env('JWT_SECRET') 
            ?: (config('app.key') ?: 'AutoGlossSuperSecretKeyWeek11JwtAuthentication2026');
        $this->algo = 'sha256';
    }

    /**
     * Generate standard JWT Token (HS256)
     */
    public function generateToken(User $user, int $ttl = 3600): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $issuedAt = time();
        $expire = $issuedAt + $ttl;

        $payload = [
            'iss' => 'autogloss-api',
            'iat' => $issuedAt,
            'exp' => $expire,
            'sub' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ];

        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac($this->algo, $base64UrlHeader . '.' . $base64UrlPayload, $this->secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    /**
     * Validate JWT Token string
     *
     * @return array{valid: bool, payload?: array, error?: string}
     */
    public function validateToken(?string $token): array
    {
        if (empty($token)) {
            return ['valid' => false, 'error' => 'Unauthorized'];
        }

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return ['valid' => false, 'error' => 'Token invalid'];
        }

        [$headerB64, $payloadB64, $signatureB64] = $parts;

        // Verify Signature
        $expectedSignature = hash_hmac($this->algo, $headerB64 . '.' . $payloadB64, $this->secret, true);
        $expectedSignatureB64 = $this->base64UrlEncode($expectedSignature);

        if (!hash_equals($expectedSignatureB64, $signatureB64)) {
            return ['valid' => false, 'error' => 'Token invalid'];
        }

        // Decode Payload
        $payloadJson = $this->base64UrlDecode($payloadB64);
        $payload = json_decode($payloadJson, true);

        if (!is_array($payload)) {
            return ['valid' => false, 'error' => 'Token invalid'];
        }

        // Verify Expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return ['valid' => false, 'error' => 'Token invalid'];
        }

        return [
            'valid' => true,
            'payload' => $payload,
        ];
    }

    /**
     * Base64 URL safe encode
     */
    public function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Base64 URL safe decode
     */
    public function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
