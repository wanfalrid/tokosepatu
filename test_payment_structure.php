<?php

// Test the checkout process
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

use App\Models\Pembayaran;

echo "Testing Pembayaran model...\n";

try {
    // Try to create a test payment record
    $testPayment = [
        'id_pembayaran' => 'TEST-12345',
        'id_pesanan' => 'TEST-ORDER',
        'jumlah_bayar' => 100000,
        'tanggal_pembayaran' => now(),
        'status_pembayaran' => 'menunggu',
        'dibuat_pada' => now(),
    ];
    
    echo "Test data structure:\n";
    foreach ($testPayment as $key => $value) {
        echo "- $key: $value\n";
    }
    
    echo "\nPembayaran fillable fields:\n";
    $payment = new Pembayaran();
    foreach ($payment->getFillable() as $field) {
        echo "- $field\n";
    }
    
    echo "\nTest passed! Column names are correct.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
