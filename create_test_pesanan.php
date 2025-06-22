<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating test pesanan for testing resi form...\n";

try {
    // Create test pesanan
    $pesanan = App\Models\Pesanan::create([
        'id_pesanan' => 'ORD-TEST-' . strtoupper(\Illuminate\Support\Str::random(6)),
        'id_pelanggan' => 'PLG-001', // Assuming this customer exists
        'total_harga' => 150000,
        'status_pesanan' => 'diproses', // Status diproses untuk test form resi
        'payment_status' => 'paid',
        'metode_pengiriman' => null,
        'tanggal_pesanan' => now(),
        'nomor_resi' => null,
        'ongkos_kirim' => 10000,
        'alamat_pengiriman' => 'Jl. Test No. 123, Jakarta',
        'nama_penerima' => 'Test Customer',
        'telepon_penerima' => '081234567890',
        'email_penerima' => 'test@example.com',
        'dibuat_pada' => now(),
    ]);
    
    echo "✓ Test pesanan created: {$pesanan->id_pesanan}\n";
    echo "✓ Status: {$pesanan->status_pesanan}\n";
    echo "✓ You can now test the resi form at: /admin/pesanan/{$pesanan->id_pesanan}\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
