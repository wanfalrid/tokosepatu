<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Produk model and DetailPesanan relationship...\n";

try {
    // Test 1: Get first produk
    $produk = App\Models\Produk::first();
    
    if ($produk) {
        echo "✓ Found produk: {$produk->nama_produk}\n";
        
        // Test 2: Test detailPesanan relationship with new query
        $details = $produk->detailPesanan()->orderBy('id_detail_pesanan', 'desc')->take(5)->get();
        echo "✓ Detail pesanan count: {$details->count()}\n";
        
        // Test 3: Test with pesanan relationship
        $detailsWithPesanan = $produk->detailPesanan()->with('pesanan.pelanggan')->orderBy('id_detail_pesanan', 'desc')->take(5)->get();
        echo "✓ Detail pesanan with pesanan count: {$detailsWithPesanan->count()}\n";
        
        // Test 4: Test accessing properties safely
        foreach ($detailsWithPesanan as $detail) {
            echo "  - Detail ID: {$detail->id_detail_pesanan}";
            if ($detail->pesanan) {
                echo " | Pesanan: {$detail->pesanan->id_pesanan}";
                if ($detail->pesanan->tanggal_pesanan) {
                    echo " | Date: {$detail->pesanan->tanggal_pesanan->format('Y-m-d')}";
                }
            }
            echo "\n";
        }
        
        echo "✓ All tests passed! No more created_at errors.\n";
        
    } else {
        echo "No produk found in database.\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
