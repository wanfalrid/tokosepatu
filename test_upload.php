<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;
use App\Models\Produk;

echo "Testing storage functionality...\n";

// Test basic storage
$testContent = 'Test content - ' . date('Y-m-d H:i:s');
Storage::disk('public')->put('test_upload.txt', $testContent);

if (Storage::disk('public')->exists('test_upload.txt')) {
    echo "✓ Storage write test: PASSED\n";
    Storage::disk('public')->delete('test_upload.txt');
} else {
    echo "✗ Storage write test: FAILED\n";
}

// Test product images directory
$productImagesDir = 'product_images';
if (!Storage::disk('public')->exists($productImagesDir)) {
    Storage::disk('public')->makeDirectory($productImagesDir);
    echo "✓ Created product_images directory\n";
} else {
    echo "✓ Product images directory exists\n";
}

// Check existing products with images
$productsWithImages = Produk::whereNotNull('gambar')->count();
echo "Products with images in database: {$productsWithImages}\n";

if ($productsWithImages > 0) {
    $firstProduct = Produk::whereNotNull('gambar')->first();
    echo "First product image: {$firstProduct->gambar}\n";
    echo "Image URL: {$firstProduct->image_url}\n";
    
    $imageExists = Storage::disk('public')->exists('product_images/' . $firstProduct->gambar);
    echo "Image file exists in storage: " . ($imageExists ? 'YES' : 'NO') . "\n";
}

// Test symlink
$symlinkPath = public_path('storage');
echo "Symlink path: {$symlinkPath}\n";
echo "Symlink exists: " . (is_link($symlinkPath) ? 'YES' : 'NO') . "\n";

echo "\nTest completed.\n";
