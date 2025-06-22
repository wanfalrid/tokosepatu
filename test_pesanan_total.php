<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Pesanan model and calculations...\n";

try {
    // Test first pesanan
    $pesanan = App\Models\Pesanan::with(['detailPesanan.produk', 'pembayaran'])->first();
    
    if ($pesanan) {
        echo "✓ Found pesanan: {$pesanan->id_pesanan}\n";
        echo "  - total_harga (DB): " . ($pesanan->total_harga ?? 'NULL') . "\n";
        echo "  - ongkos_kirim: " . ($pesanan->ongkos_kirim ?? 'NULL') . "\n";
        echo "  - detail count: {$pesanan->detailPesanan->count()}\n";
        
        $calculatedSubtotal = 0;
        foreach ($pesanan->detailPesanan as $detail) {
            $subtotal = $detail->subtotal;
            $calculatedSubtotal += $subtotal;
            echo "    * {$detail->jumlah} x {$detail->harga_satuan} = {$subtotal}\n";
        }
        
        echo "  - calculated subtotal: {$calculatedSubtotal}\n";
        echo "  - detailPesanan->sum('subtotal'): " . $pesanan->detailPesanan->sum('subtotal') . "\n";
        
        if ($pesanan->pembayaran) {
            echo "  - pembayaran exists: YES\n";
            echo "  - jumlah_bayar: " . ($pesanan->pembayaran->jumlah_bayar ?? 'NULL') . "\n";
        } else {
            echo "  - pembayaran exists: NO\n";
        }
        
        echo "✓ All calculations completed successfully!\n";
        
    } else {
        echo "No pesanan found in database.\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
