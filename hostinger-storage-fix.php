<?php
/**
 * Hostinger Storage Fix Script
 * Run this on your Hostinger server to fix image display issues
 */

echo "<h1>Hostinger Storage Fix</h1>";

// Check current environment
echo "<h2>Current Environment</h2>";
echo "<p><strong>APP_URL:</strong> " . ($_ENV['APP_URL'] ?? getenv('APP_URL') ?? 'Not set') . "</p>";
echo "<p><strong>STORAGE_URL:</strong> " . ($_ENV['STORAGE_URL'] ?? getenv('STORAGE_URL') ?? 'Not set') . "</p>";

// Define paths
$publicPath = __DIR__;
$storagePath = __DIR__ . '/storage';
$storageAppPath = __DIR__ . '/storage/app/public';

echo "<h2>Path Information</h2>";
echo "<p><strong>Public Path:</strong> {$publicPath}</p>";
echo "<p><strong>Storage Path:</strong> {$storagePath}</p>";
echo "<p><strong>Storage App Path:</strong> {$storageAppPath}</p>";

// Check if directories exist
echo "<h2>Directory Status</h2>";
echo "<p><strong>Storage directory:</strong> " . (is_dir($storagePath) ? "✅ Exists" : "❌ Missing") . "</p>";
echo "<p><strong>Storage/app/public:</strong> " . (is_dir($storageAppPath) ? "✅ Exists" : "❌ Missing") . "</p>";

// Create symlink or directory structure
echo "<h2>Creating Storage Access</h2>";

// Remove existing symlink/directory
if (is_link($storagePath)) {
    unlink($storagePath);
    echo "<p>✅ Removed existing symlink</p>";
} elseif (is_dir($storagePath)) {
    echo "<p>📁 Storage directory already exists</p>";
}

// Try to create symlink first
if (symlink('../storage/app/public', $storagePath)) {
    echo "<p>✅ Created symlink: {$storagePath} → ../storage/app/public</p>";
} else {
    // If symlink fails, create directory structure
    echo "<p>⚠️ Symlink failed, creating directory structure</p>";
    
    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0755, true);
    }
    
    $subdirs = ['profile_images', 'background_images', 'gallery_images', 'store_products', 'pwa_icons'];
    foreach ($subdirs as $subdir) {
        $targetDir = $storagePath . '/' . $subdir;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
            echo "<p>📁 Created directory: {$targetDir}</p>";
        }
    }
}

// Test image URLs
echo "<h2>Testing Image URLs</h2>";

// Get server info for URL construction
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$serverName = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'unknown';
$serverUrl = $protocol . '://' . $serverName;

echo "<p><strong>Server URL:</strong> {$serverUrl}</p>";

// Test URLs
$testImages = [
    'profile_images/test.jpg',
    'background_images/test.jpg',
    'gallery_images/test.jpg',
    'store_products/test.jpg'
];

foreach ($testImages as $testImage) {
    $publicUrl = $serverUrl . '/storage/' . $testImage;
    echo "<p><strong>Test URL:</strong> <a href='{$publicUrl}' target='_blank'>{$publicUrl}</a></p>";
}

// Instructions
echo "<h2>Instructions</h2>";
echo "<ol>";
echo "<li>Update your .env file with the correct STORAGE_URL</li>";
echo "<li>Test the URLs above to see if images are accessible</li>";
echo "<li>If images still don't work, check file permissions (chmod 755 for directories, 644 for files)</li>";
echo "<li>Clear Laravel cache: <code>php artisan config:clear && php artisan cache:clear</code></li>";
echo "</ol>";

echo "<h2>Recommended .env Settings</h2>";
echo "<pre>";
echo "APP_URL=https://smart-keyholder.click/public/\n";
echo "STORAGE_URL=https://" . $serverName . "/storage\n";
echo "FILESYSTEM_DISK=public\n";
echo "</pre>";

echo "<p><em>Script completed. Check the test URLs and update your .env file accordingly.</em></p>";
?>