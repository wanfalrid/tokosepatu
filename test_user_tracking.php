<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://localhost:8000',
    'timeout' => 30.0,
]);

try {
    // Test dengan pesanan ID yang ada (harus dari user yang login)
    $pesananId = 'PSN-8DYASRNG'; // ID pesanan dengan status 'diproses'
    
    echo "Testing User Tracking Endpoint...\n";
    echo "Pesanan ID: $pesananId\n\n";
    
    // Note: Endpoint ini memerlukan autentikasi user
    // Dalam production, harus ada session/cookie auth
    
    // Test endpoint tracking API
    $response = $client->get("/auth/orders/$pesananId/track", [
        'headers' => [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ],
        'http_errors' => false
    ]);
    
    $statusCode = $response->getStatusCode();
    $body = $response->getBody()->getContents();
    $contentType = $response->getHeaderLine('Content-Type');
    
    echo "Status Code: $statusCode\n";
    echo "Content-Type: $contentType\n";
    echo "Response Body:\n";
    echo $body . "\n";
    
    // Cek apakah response adalah JSON
    $data = json_decode($body, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "\n✅ Response is valid JSON\n";
        if (isset($data['success'])) {
            echo "Success: " . ($data['success'] ? 'true' : 'false') . "\n";
        }
        if (isset($data['message'])) {
            echo "Message: " . $data['message'] . "\n";
        }
    } else {
        echo "\n❌ Response is NOT valid JSON\n";
        echo "JSON Error: " . json_last_error_msg() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "CATATAN: Endpoint ini memerlukan autentikasi user.\n";
echo "Untuk test lengkap, perlu login sebagai customer terlebih dahulu.\n";
