<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set up Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Produk;

echo "Testing product image URLs...\n\n";

try {
    // Get a few products to test
    $products = Produk::take(3)->get();
    
    if ($products->isEmpty()) {
        echo "❌ No products found for testing\n";
        exit(1);
    }
    
    foreach ($products as $product) {
        echo "Product: {$product->nama_produk}\n";
        echo "  ID: {$product->id_produk}\n";
        echo "  Raw gambar: " . ($product->gambar ?? 'null') . "\n";
        echo "  Image URL: " . ($product->image_url ?? 'null') . "\n";
        echo "  File exists: " . (file_exists(storage_path('app/public/product_images/' . $product->gambar)) ? 'YES' : 'NO') . "\n";
        echo "  Expected path: " . storage_path('app/public/product_images/' . $product->gambar) . "\n";
        echo "  Public URL: " . asset('storage/product_images/' . $product->gambar) . "\n";
        echo "\n";
    }
    
    echo "✅ Image URL testing completed!\n";
    
} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
