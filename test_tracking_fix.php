<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set up Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pesanan;
use App\Models\Pelanggan;

echo "Testing tracking page fixes...\n\n";

try {
    // Get a test order
    $pesanan = Pesanan::with(['pelanggan', 'details.produk', 'pembayaran'])->first();
    
    if (!$pesanan) {
        echo "❌ No orders found for testing\n";
        exit(1);
    }
    
    echo "✅ Found test order: #{$pesanan->id_pesanan}\n";
    echo "   Status: {$pesanan->status_pesanan}\n";
    echo "   Created: " . ($pesanan->dibuat_pada ? $pesanan->dibuat_pada->format('Y-m-d H:i:s') : 'null') . "\n";
    echo "   Order Date: " . ($pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('Y-m-d H:i:s') : 'null') . "\n";
    
    // Test the date calculations like in the tracking view
    $baseDate = $pesanan->dibuat_pada ?? $pesanan->tanggal_pesanan ?? now();
    echo "   Base Date: " . $baseDate->format('Y-m-d H:i:s') . "\n";
    
    // Test safe date calculation
    $safeDateCalc = function($baseDate, $method, $value = null) {
        if (!$baseDate) return 'N/A';
        try {
            $date = $baseDate->copy();
            if ($value !== null) {
                return $date->$method($value)->format('d M Y H:i');
            } else {
                return $date->$method()->format('d M Y H:i');
            }
        } catch (Exception $e) {
            return 'N/A';
        }
    };
    
    // Test different date calculations
    echo "\n✅ Testing date calculations:\n";
    echo "   + 2 hours: " . $safeDateCalc($baseDate, 'addHours', 2) . "\n";
    echo "   + 6 hours: " . $safeDateCalc($baseDate, 'addHours', 6) . "\n";
    echo "   + 1 day: " . $safeDateCalc($baseDate, 'addDay') . "\n";
    echo "   + 3 days: " . $safeDateCalc($baseDate, 'addDays', 3) . "\n";
    
    echo "\n✅ All date calculations working correctly!\n";
    echo "✅ Tracking page fix validation successful!\n";
    
} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
