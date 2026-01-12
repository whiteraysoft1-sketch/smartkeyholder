<?php
/**
 * Fix storage symlinks for hosted environment
 * Run this script on the server to ensure images display correctly
 */

// Set proper paths
$publicStoragePath = __DIR__ . '/storage';
$storagePublicPath = __DIR__ . '/storage/app/public';

// Remove existing symlink if it exists
if (is_link($publicStoragePath)) {
    unlink($publicStoragePath);
    echo "Removed existing symlink.\n";
}

// Create storage directories if they don't exist
$directories = [
    $storagePublicPath,
    $storagePublicPath . '/profile_images',
    $storagePublicPath . '/background_images',
    $storagePublicPath . '/gallery_images',
    $storagePublicPath . '/store_products',
    $storagePublicPath . '/pwa_icons',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: {$dir}\n";
    }
}

// Create the symlink
if (symlink($storagePublicPath, $publicStoragePath)) {
    echo "Storage symlink created successfully!\n";
    echo "From: {$publicStoragePath}\n";
    echo "To: {$storagePublicPath}\n";
} else {
    echo "Failed to create storage symlink.\n";
    
    // Try alternative method - copy files
    echo "Attempting to create directory structure...\n";
    if (!is_dir($publicStoragePath)) {
        mkdir($publicStoragePath, 0755, true);
    }
    
    // Create subdirectories
    $subdirs = ['profile_images', 'background_images', 'gallery_images', 'store_products', 'pwa_icons'];
    foreach ($subdirs as $subdir) {
        $targetDir = $publicStoragePath . '/' . $subdir;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
            echo "Created public directory: {$targetDir}\n";
        }
    }
}

// Set permissions
chmod($publicStoragePath, 0755);
echo "Set permissions for storage directory.\n";

// Test image URLs
echo "\nTesting storage URL generation:\n";
$testPath = 'profile_images/test.jpg';
$storageUrl = (isset($_ENV['STORAGE_URL']) ? $_ENV['STORAGE_URL'] : 'https://smart-keyholder.click/storage') . '/' . $testPath;
echo "Storage URL would be: {$storageUrl}\n";

echo "\nStorage setup complete!\n";
?>