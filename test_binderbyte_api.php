<?php

require_once 'vendor/autoload.php';

echo "Testing BinderByte API integration...\n";

try {
    $client = new \GuzzleHttp\Client();
    $apiKey = '74c214db8373a74d99c63c1ec1404fefde45ab9325f2193b4da5686190e788f3';
    
    // Test API dengan sample tracking number
    $response = $client->get('https://api.binderbyte.com/v1/track', [
        'query' => [
            'api_key' => $apiKey,
            'courier' => 'spx',
            'awb' => 'SPXID048949914625'
        ],
        'timeout' => 30,
        'headers' => [
            'Accept' => 'application/json',
            'User-Agent' => 'TokoSepatu/1.0'
        ]
    ]);
    
    $data = json_decode($response->getBody(), true);
    
    echo "✓ API Response Status: " . $data['status'] . "\n";
    echo "✓ API Response Message: " . $data['message'] . "\n";
    
    if ($data['status'] == 200 && isset($data['data'])) {
        echo "✓ Tracking data available:\n";
        echo "  - AWB: " . ($data['data']['summary']['awb'] ?? 'N/A') . "\n";
        echo "  - Status: " . ($data['data']['summary']['status'] ?? 'N/A') . "\n";
        echo "  - Courier: " . ($data['data']['summary']['courier'] ?? 'N/A') . "\n";
        echo "  - Date: " . ($data['data']['summary']['date'] ?? 'N/A') . "\n";
        echo "  - History items: " . count($data['data']['history'] ?? []) . "\n";
    }
    
    echo "✓ BinderByte API integration test successful!\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
