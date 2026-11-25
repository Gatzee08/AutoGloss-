<?php

putenv('DB_CONNECTION=sqlite');
$_ENV['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_CONNECTION'] = 'sqlite';

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "\n============================================================\n";
echo "   AUTOGLOSS - PENGUJIAN OTOMATIS WEEK 10: APPLICATION FLOW & REST API\n";
echo "============================================================\n\n";

function makeWeek10Request($app, $method, $uri, $data = [], $headers = []) {
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

// 1. GET /api/products (01 Controller, 02 Routing GET, 04 REST API List, 05 HTTP 200)
echo "[TEST 1] GET /api/products (List all products)...\n";
$res1 = makeWeek10Request($app, 'GET', '/api/products');
if ($res1['status'] === 200 && isset($res1['body']['data']) && is_array($res1['body']['data'])) {
    echo "  -> SUCCESS (HTTP 200 OK) - Total: " . count($res1['body']['data']) . " produk\n";
} else {
    echo "  -> FAILED: " . json_encode($res1) . "\n";
    $allPassed = false;
}

// 2. POST /api/products (02 Routing POST, 03 Validation Valid, 04 REST API Post, 05 HTTP 201)
echo "\n[TEST 2] POST /api/products (Create new product with valid data)...\n";
$newCode = 'PRD-AUTO-' . rand(1000, 9999);
$res2 = makeWeek10Request($app, 'POST', '/api/products', [
    'category_id' => 1,
    'code' => $newCode,
    'name' => 'AutoGloss Fast Drying Clear Coat 1L',
    'sub_category' => 'Clear Coat PU',
    'price' => 160000,
    'stock' => 30,
    'unit' => '1 Liter'
]);

if ($res2['status'] === 201 && isset($res2['body']['data']['id'])) {
    $createdId = $res2['body']['data']['id'];
    echo "  -> SUCCESS (HTTP 201 Created) - ID baru: #{$createdId} ({$newCode})\n";
} else {
    echo "  -> FAILED: " . json_encode($res2) . "\n";
    $allPassed = false;
    $createdId = 1;
}

// 3. POST /api/products (03 Validation Error Required & Max Length, 05 HTTP 422)
echo "\n[TEST 3] POST /api/products (Validation failure test -> Expect 422)...\n";
$res3 = makeWeek10Request($app, 'POST', '/api/products', [
    'description' => 'Data tidak memiliki name, code, category_id, price'
]);

if ($res3['status'] === 422 && isset($res3['body']['errors'])) {
    echo "  -> SUCCESS (HTTP 422 Unprocessable Content)\n";
    echo "  -> Validation Errors: " . implode(', ', array_keys($res3['body']['errors'])) . "\n";
} else {
    echo "  -> FAILED: " . json_encode($res3) . "\n";
    $allPassed = false;
}

// 4. GET /api/products/{id} (04 REST API Detail, 05 HTTP 200)
echo "\n[TEST 4] GET /api/products/{$createdId} (Show single product detail)...\n";
$res4 = makeWeek10Request($app, 'GET', "/api/products/{$createdId}");
if ($res4['status'] === 200 && isset($res4['body']['data']['name'])) {
    echo "  -> SUCCESS (HTTP 200 OK) - Nama: " . $res4['body']['data']['name'] . "\n";
} else {
    echo "  -> FAILED: " . json_encode($res4) . "\n";
    $allPassed = false;
}

// 5. GET /api/products/9999 (05 HTTP 404 Not Found)
echo "\n[TEST 5] GET /api/products/9999 (Not Found test -> Expect 404)...\n";
$res5 = makeWeek10Request($app, 'GET', '/api/products/9999');
if ($res5['status'] === 404) {
    echo "  -> SUCCESS (HTTP 404 Not Found)\n";
    echo "  -> Message: " . ($res5['body']['message'] ?? '') . "\n";
} else {
    echo "  -> FAILED: " . json_encode($res5) . "\n";
    $allPassed = false;
}

// 6. PUT /api/products/{id} (02 Routing PUT, 04 REST API Update, 05 HTTP 200)
echo "\n[TEST 6] PUT /api/products/{$createdId} (Update product price & name)...\n";
$res6 = makeWeek10Request($app, 'PUT', "/api/products/{$createdId}", [
    'category_id' => 1,
    'code' => $newCode,
    'name' => 'AutoGloss Fast Drying Clear Coat 1L (Updated Premium)',
    'price' => 175000,
    'stock' => 45,
    'unit' => '1 Liter'
]);

if ($res6['status'] === 200 && ($res6['body']['data']['price'] ?? 0) == 175000) {
    echo "  -> SUCCESS (HTTP 200 OK) - Harga terupdate: Rp 175.000\n";
} else {
    echo "  -> FAILED: " . json_encode($res6) . "\n";
    $allPassed = false;
}

// 7. DELETE /api/products/{id} (02 Routing DELETE, 04 REST API Delete, 05 HTTP 200)
echo "\n[TEST 7] DELETE /api/products/{$createdId} (Delete product from DB)...\n";
$res7 = makeWeek10Request($app, 'DELETE', "/api/products/{$createdId}");
if ($res7['status'] === 200) {
    echo "  -> SUCCESS (HTTP 200 OK) - " . ($res7['body']['message'] ?? '') . "\n";
} else {
    echo "  -> FAILED: " . json_encode($res7) . "\n";
    $allPassed = false;
}

echo "\n------------------------------------------------------------\n";
if ($allPassed) {
    echo " HASIL AKHIR: 7/7 PENGUJIAN REST API WEEK 10 LULUS (100% PASS)!\n";
    echo " Seluruh 6 Kategori Checklist Pertemuan 10 Terpenuhi Sempurna.\n";
} else {
    echo " HASIL AKHIR: Ada pengujian yang gagal.\n";
}
echo "------------------------------------------------------------\n\n";
