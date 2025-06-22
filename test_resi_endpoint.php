<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://localhost:8000',
    'timeout' => 30.0,
]);

try {    // Test dengan pesanan ID yang ada
    $pesananId = 'PSN-8DYASRNG'; // ID pesanan dengan status 'diproses'
    
    echo "Testing Resi Update Endpoint...\n";
    echo "Pesanan ID: $pesananId\n\n";
    
    // Buat request POST ke endpoint resi
    $response = $client->post("/admin/pesanan/$pesananId/resi", [
        'form_params' => [
            'courier' => 'jne',
            'awb' => 'JNE123456789TEST'
        ],
        'headers' => [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ],
        'http_errors' => false // Tidak throw exception untuk status error
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
