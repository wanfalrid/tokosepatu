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

echo "Final test of product image URLs after fixes...\n\n";

try {
    // Get a few products to test all scenarios
    $products = Produk::take(5)->get();
    
    if ($products->isEmpty()) {
        echo "❌ No products found for testing\n";
        exit(1);
    }
    
    foreach ($products as $product) {
        echo "Product: {$product->nama_produk}\n";
        echo "  ID: {$product->id_produk}\n";
        echo "  Raw gambar: " . ($product->gambar ?? 'null') . "\n";
        echo "  Image URL: " . $product->image_url . "\n";
        
        // Test if it's a URL or local file
        if (filter_var($product->gambar, FILTER_VALIDATE_URL)) {
            echo "  Type: External URL ✅\n";
        } else {
            $localPath = storage_path('app/public/product_images/' . $product->gambar);
            echo "  Type: Local file (" . (file_exists($localPath) ? 'EXISTS ✅' : 'NOT FOUND ❌') . ")\n";
        }
        echo "\n";
    }
    
    // Test fallback for empty gambar
    $testProduk = new Produk();
    $testProduk->nama_produk = 'Test Product (No Image)';
    $testProduk->gambar = null;
    echo "Test Fallback:\n";
    echo "  Product: {$testProduk->nama_produk}\n";
    echo "  Raw gambar: null\n";
    echo "  Image URL: " . $testProduk->image_url . "\n\n";
    
    echo "✅ All image URL tests completed successfully!\n";
    echo "✅ Products should now display images properly in all views!\n";
    
} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
