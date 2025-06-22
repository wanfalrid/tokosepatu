<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Sample products
    $products = [
        [
            'id_produk' => 'PRD-001',
            'nama_produk' => 'Nike Air Max 270',
            'deskripsi' => 'Sepatu running dengan teknologi Air Max terbaru untuk kenyamanan maksimal.',
            'harga' => 1899000,
            'stok' => 25,
            'merek' => 'Nike',
            'kategori' => 'Running',
            'warna' => 'Black/White',
            'ukuran' => '40,41,42,43,44',
            'gambar' => null,
            'dibuat_pada' => now(),
        ],
        [
            'id_produk' => 'PRD-002',
            'nama_produk' => 'Adidas Ultraboost 22',
            'deskripsi' => 'Sepatu running premium dengan teknologi Boost untuk responsivitas tinggi.',
            'harga' => 2299000,
            'stok' => 18,
            'merek' => 'Adidas',
            'kategori' => 'Running',
            'warna' => 'Core Black',
            'ukuran' => '39,40,41,42,43',
            'gambar' => null,
            'dibuat_pada' => now(),
        ],
        [
            'id_produk' => 'PRD-003',
            'nama_produk' => 'Converse Chuck Taylor All Star',
            'deskripsi' => 'Sepatu klasik yang timeless dengan desain ikonik.',
            'harga' => 899000,
            'stok' => 35,
            'merek' => 'Converse',
            'kategori' => 'Casual',
            'warna' => 'White',
            'ukuran' => '36,37,38,39,40,41,42',
            'gambar' => null,
            'dibuat_pada' => now(),
        ],
        [
            'id_produk' => 'PRD-004',
            'nama_produk' => 'Vans Old Skool',
            'deskripsi' => 'Sepatu skate klasik dengan stripe samping yang ikonik.',
            'harga' => 1099000,
            'stok' => 22,
            'merek' => 'Vans',
            'kategori' => 'Casual',
            'warna' => 'Black/White',
            'ukuran' => '38,39,40,41,42,43',
            'gambar' => null,
            'dibuat_pada' => now(),
        ],
        [
            'id_produk' => 'PRD-005',
            'nama_produk' => 'Puma RS-X',
            'deskripsi' => 'Sepatu retro futuristik dengan teknologi cushioning modern.',
            'harga' => 1599000,
            'stok' => 15,
            'merek' => 'Puma',
            'kategori' => 'Sneakers',
            'warna' => 'Multi Color',
            'ukuran' => '40,41,42,43',
            'gambar' => null,
            'dibuat_pada' => now(),
        ]
    ];
    
    foreach ($products as $product) {
        $existing = DB::table('produk')->where('id_produk', $product['id_produk'])->first();
        if (!$existing) {
            DB::table('produk')->insert($product);
            echo "Produk {$product['nama_produk']} berhasil ditambahkan!\n";
        } else {
            echo "Produk {$product['nama_produk']} sudah ada.\n";
        }
    }
    
    echo "\nSample produk berhasil dibuat!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
