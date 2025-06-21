<?php

use App\Services\MidtransService;

// Test data for snap token
$testOrder = [
    'order_id' => 'TEST-ORDER-' . time(),
    'total_amount' => 100000,
    'customer' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'phone' => '+6281234567890',
        'address' => 'Jl. Test No. 123, Jakarta',
    ],
    'items' => [
        [
            'id' => 'ITEM1',
            'price' => 50000,
            'quantity' => 2,
            'name' => 'Test Product',
        ]
    ]
];

echo "Testing Midtrans Snap Token Creation...\n";

try {
    $midtransService = new MidtransService();
    echo "MidtransService created successfully\n";
    
    $snapToken = $midtransService->createSnapToken($testOrder);
    echo "SUCCESS: Snap token created: " . $snapToken . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
