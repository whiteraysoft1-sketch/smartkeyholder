<?php
/**
 * Debug Image URLs - Test script for hosted environment
 * Upload this file to your server and run it to test image URL generation
 */

// Bootstrap Laravel (adjust path if needed)
require_once __DIR__ . '/bootstrap/app.php';

$app = \Illuminate\Foundation\Application::getInstance();
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "<h1>Image URL Debug Test</h1>";

// Test environment detection
echo "<h2>Environment Information</h2>";
echo "<p><strong>APP_URL:</strong> " . config('app.url') . "</p>";
echo "<p><strong>STORAGE_URL:</strong> " . env('STORAGE_URL', 'Not set') . "</p>";
echo "<p><strong>Environment:</strong> " . app()->environment() . "</p>";
echo "<p><strong>Is Hosted:</strong> " . (\App\Helpers\StorageHelper::isHostedEnvironment() ? 'Yes' : 'No') . "</p>";
echo "<p><strong>Storage Base URL:</strong> " . \App\Helpers\StorageHelper::getStorageBaseUrl() . "</p>";

// Test sample image URLs
echo "<h2>Sample Image URL Generation</h2>";

$testImages = [
    'profile_images/1764960164_IMG_2332.jpeg',
    'background_images/1764957081_bg_IMG_2330.jpeg', 
    'gallery_images/1764956271_IMG_1856.jpeg',
    'store_products/1764957622_IMG_2337.jpeg'
];

foreach ($testImages as $testImage) {
    $parts = explode('/', $testImage);
    $folder = $parts[0];
    $filename = $parts[1];
    
    $url = \App\Helpers\StorageHelper::getImageUrl($testImage);
    echo "<p><strong>{$testImage}:</strong><br>";
    echo "Generated URL: <a href='{$url}' target='_blank'>{$url}</a><br>";
    
    // Check if file exists
    $filePath = storage_path('app/public/' . $testImage);
    $fileExists = file_exists($filePath);
    echo "File exists: " . ($fileExists ? "✅ Yes" : "❌ No") . "<br>";
    
    if ($fileExists) {
        echo "File size: " . number_format(filesize($filePath) / 1024, 2) . " KB<br>";
    }
    echo "</p>";
}

// Test with actual database records
echo "<h2>Database Records Test</h2>";

try {
    // Test user profile
    $profile = \App\Models\UserProfile::whereNotNull('profile_image')->first();
    if ($profile) {
        echo "<p><strong>Profile Image Test:</strong><br>";
        echo "Profile Image Path: " . $profile->profile_image . "<br>";
        echo "Generated URL: <a href='" . $profile->full_profile_image_url . "' target='_blank'>" . $profile->full_profile_image_url . "</a></p>";
    }
    
    // Test gallery item
    $galleryItem = \App\Models\GalleryItem::whereNotNull('image_path')->first();
    if ($galleryItem) {
        echo "<p><strong>Gallery Image Test:</strong><br>";
        echo "Gallery Image Path: " . $galleryItem->image_path . "<br>";
        echo "Generated URL: <a href='" . $galleryItem->full_image_url . "' target='_blank'>" . $galleryItem->full_image_url . "</a></p>";
    }
    
    // Test store product
    $product = \App\Models\StoreProduct::whereNotNull('image')->first();
    if ($product) {
        echo "<p><strong>Store Product Image Test:</strong><br>";
        echo "Product Image Path: " . $product->image . "<br>";
        echo "Generated URL: <a href='" . $product->image_url . "' target='_blank'>" . $product->image_url . "</a></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
}

// Test storage directory structure
echo "<h2>Storage Directory Structure</h2>";
$storagePublicPath = storage_path('app/public');
$publicStoragePath = public_path('storage');

echo "<p><strong>Storage Path:</strong> {$storagePublicPath} - " . (is_dir($storagePublicPath) ? "✅ Exists" : "❌ Missing") . "</p>";
echo "<p><strong>Public Symlink:</strong> {$publicStoragePath} - " . (is_link($publicStoragePath) ? "✅ Symlink" : (is_dir($publicStoragePath) ? "📁 Directory" : "❌ Missing")) . "</p>";

if (is_link($publicStoragePath)) {
    echo "<p><strong>Symlink Target:</strong> " . readlink($publicStoragePath) . "</p>";
}

// List storage subdirectories
$subdirs = ['profile_images', 'background_images', 'gallery_images', 'store_products'];
foreach ($subdirs as $subdir) {
    $fullPath = $storagePublicPath . '/' . $subdir;
    $publicPath = $publicStoragePath . '/' . $subdir;
    echo "<p><strong>{$subdir}:</strong><br>";
    echo "Storage: " . (is_dir($fullPath) ? "✅ Exists" : "❌ Missing") . "<br>";
    echo "Public: " . (is_dir($publicPath) ? "✅ Accessible" : "❌ Not accessible") . "</p>";
}

echo "<hr><p><em>Debug completed. Check the generated URLs and file accessibility.</em></p>";
?>