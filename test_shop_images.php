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

echo "Testing shop page image accessibility...\n\n";

try {
    // Get products with local images
    $products = Produk::whereNotNull('gambar')
        ->where('gambar', 'not like', 'http%')
        ->take(3)
        ->get();
    
    if ($products->isEmpty()) {
        echo "❌ No products with local images found\n";
        exit(1);
    }
    
    foreach ($products as $product) {
        echo "Testing Product: {$product->nama_produk}\n";
        echo "  Raw gambar: {$product->gambar}\n";
        echo "  Image URL: {$product->image_url}\n";
        
        // Check file existence in storage
        $storagePath = storage_path('app/public/product_images/' . $product->gambar);
        $publicPath = public_path('storage/product_images/' . $product->gambar);
        
        echo "  Storage path: " . ($storagePath) . "\n";
        echo "  Public path: " . ($publicPath) . "\n";
        echo "  Storage exists: " . (file_exists($storagePath) ? 'YES ✅' : 'NO ❌') . "\n";
        echo "  Public exists: " . (file_exists($publicPath) ? 'YES ✅' : 'NO ❌') . "\n";
        
        // Check symlink
        if (is_link(public_path('storage'))) {
            echo "  Symlink exists: YES ✅\n";
            echo "  Symlink target: " . readlink(public_path('storage')) . "\n";
        } else {
            echo "  Symlink exists: NO ❌\n";
        }
        
        echo "\n";
    }
    
    // Check Laravel app configuration
    echo "Laravel Configuration:\n";
    echo "  APP_URL: " . config('app.url') . "\n";
    echo "  Asset URL: " . asset('storage/product_images/test.jpg') . "\n";
    echo "  Public path: " . public_path() . "\n";
    echo "  Storage path: " . storage_path() . "\n";
    
    echo "\n✅ Image accessibility test completed!\n";
    
} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
