<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

use App\Models\Pesanan;

echo "Testing Pesanan model field access...\n";

try {
    $pesanan = Pesanan::first();
    
    if ($pesanan) {
        echo "Found pesanan: " . $pesanan->id_pesanan . "\n";
        echo "Field dibuat_pada: " . $pesanan->dibuat_pada . "\n";
        echo "Type: " . gettype($pesanan->dibuat_pada) . "\n";
        
        if ($pesanan->dibuat_pada instanceof \Illuminate\Support\Carbon) {
            echo "Is Carbon instance: YES\n";
            echo "Formatted: " . $pesanan->dibuat_pada->format('d M Y, H:i') . "\n";
        } else {
            echo "Is Carbon instance: NO\n";
            if ($pesanan->dibuat_pada) {
                echo "Fallback format: " . date('d M Y, H:i', strtotime($pesanan->dibuat_pada)) . "\n";
            }
        }
    } else {
        echo "No orders found in database\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
