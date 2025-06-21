<?php

// Test Midtrans Configuration

echo "=== MIDTRANS CONFIGURATION TEST ===\n";

// Check if .env values are loaded
echo "Server Key: " . env('MIDTRANS_SERVER_KEY') . "\n";
echo "Client Key: " . env('MIDTRANS_CLIENT_KEY') . "\n";

// Check config values
echo "\nConfig Values:\n";
echo "Server Key: " . config('midtrans.serverKey') . "\n";
echo "Client Key: " . config('midtrans.clientKey') . "\n";
echo "Is Production: " . (config('midtrans.isProduction') ? 'true' : 'false') . "\n";
echo "Is Sanitized: " . (config('midtrans.isSanitized') ? 'true' : 'false') . "\n";
echo "Is 3DS: " . (config('midtrans.is3ds') ? 'true' : 'false') . "\n";

// Test MidtransService
try {
    require_once __DIR__ . '/vendor/autoload.php';
    
    $midtransService = new App\Services\MidtransService();
    echo "\n✅ MidtransService created successfully\n";
    echo "Client Key from service: " . $midtransService->getClientKey() . "\n";
    
} catch (Exception $e) {
    echo "\n❌ Error creating MidtransService: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
