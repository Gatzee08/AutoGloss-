<?php

putenv('DB_CONNECTION=sqlite');
$_ENV['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_CONNECTION'] = 'sqlite';

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

echo "\n============================================================\n";
echo "   AUTOGLOSS - PENGUJIAN OTOMATIS JWT AUTHENTICATION (WEEK 11)\n";
echo "============================================================\n\n";

function makeApiRequest($app, $method, $uri, $data = [], $headers = []) {
    $server = [
        'REQUEST_METHOD' => $method,
        'HTTP_ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json',
    ];

    foreach ($headers as $key => $val) {
        $server['HTTP_' . strtoupper(str_replace('-', '_', $key))] = $val;
    }

    $content = !empty($data) ? json_encode($data) : null;
    $request = Request::create($uri, $method, [], [], [], $server, $content);
    $response = $app->handle($request);
    $status = $response->getStatusCode();
    $body = json_decode($response->getContent(), true);

    return ['status' => $status, 'body' => $body];
}

$allPassed = true;

// 1. STEP 01: POST /api/login
echo "[TEST 1] POST /api/login (Valid Credentials)...\n";
$loginRes = makeApiRequest($app, 'POST', '/api/login', [
    'email' => 'user@example.com',
    'password' => 'password'
]);

if ($loginRes['status'] === 200 && !empty($loginRes['body']['access_token']) && $loginRes['body']['token_type'] === 'bearer') {
    echo "  -> SUCCESS (HTTP 200 OK)\n";
    echo "  -> Token Type: " . $loginRes['body']['token_type'] . "\n";
    echo "  -> Access Token: " . substr($loginRes['body']['access_token'], 0, 35) . "...\n";
    $token = $loginRes['body']['access_token'];
} else {
    echo "  -> FAILED: " . json_encode($loginRes) . "\n";
    $allPassed = false;
    $token = null;
}

// 2. STEP 03: GET /api/programs dengan Valid Bearer Token
echo "\n[TEST 2] GET /api/programs (With Valid Bearer Token)...\n";
$progRes = makeApiRequest($app, 'GET', '/api/programs', [], [
    'Authorization' => 'Bearer ' . $token
]);

if ($progRes['status'] === 200 && isset($progRes['body']['data']) && is_array($progRes['body']['data'])) {
    echo "  -> SUCCESS (HTTP 200 OK)\n";
    echo "  -> Data: " . json_encode($progRes['body']['data']) . "\n";
} else {
    echo "  -> FAILED: " . json_encode($progRes) . "\n";
    $allPassed = false;
}

// 3. STEP 04: GET /api/programs tanpa token (Remove Token)
echo "\n[TEST 3] GET /api/programs (Without Token -> Expect 401 Unauthorized)...\n";
$noTokenRes = makeApiRequest($app, 'GET', '/api/programs');

if ($noTokenRes['status'] === 401 && ($noTokenRes['body']['message'] ?? '') === 'Unauthorized') {
    echo "  -> SUCCESS (HTTP 401 Unauthorized)\n";
    echo "  -> Message: " . $noTokenRes['body']['message'] . "\n";
} else {
    echo "  -> FAILED: " . json_encode($noTokenRes) . "\n";
    $allPassed = false;
}

// 4. STEP 05: GET /api/programs dengan token invalid
echo "\n[TEST 4] GET /api/programs (With Invalid Token -> Expect 401 Token invalid)...\n";
$invalidRes = makeApiRequest($app, 'GET', '/api/programs', [], [
    'Authorization' => 'Bearer invalidtoken'
]);

if ($invalidRes['status'] === 401 && ($invalidRes['body']['message'] ?? '') === 'Token invalid') {
    echo "  -> SUCCESS (HTTP 401 Unauthorized)\n";
    echo "  -> Message: " . $invalidRes['body']['message'] . "\n";
} else {
    echo "  -> FAILED: " . json_encode($invalidRes) . "\n";
    $allPassed = false;
}

// 5. POST /api/login password salah
echo "\n[TEST 5] POST /api/login (Wrong Password -> Expect 401 Unauthorized)...\n";
$wrongLogin = makeApiRequest($app, 'POST', '/api/login', [
    'email' => 'user@example.com',
    'password' => 'wrongpassword'
]);

if ($wrongLogin['status'] === 401) {
    echo "  -> SUCCESS (HTTP 401 Unauthorized)\n";
    echo "  -> Message: " . ($wrongLogin['body']['message'] ?? '') . "\n";
} else {
    echo "  -> FAILED: " . json_encode($wrongLogin) . "\n";
    $allPassed = false;
}

echo "\n------------------------------------------------------------\n";
if ($allPassed) {
    echo " HASIL AKHIR: 5/5 PENGUJIAN LULUS DENGAN SEMPURNA! (100% PASS)\n";
    echo " Sesuai 100% dengan Task 03 Slide 1 & Completion Checklist Slide 2.\n";
} else {
    echo " HASIL AKHIR: Ada pengujian yang gagal.\n";
}
echo "------------------------------------------------------------\n\n";
