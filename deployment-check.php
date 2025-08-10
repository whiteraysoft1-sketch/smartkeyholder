<?php
// Deployment Check File
// This file helps verify if the latest deployment was successful

echo "<!DOCTYPE html>";
echo "<html><head><title>Deployment Check</title></head><body>";
echo "<h1>🚀 Smart Keyholder Deployment Status</h1>";
echo "<p><strong>Last Updated:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Server Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";

// Check if Laravel is working
if (file_exists('artisan')) {
    echo "<p>✅ <strong>Laravel:</strong> artisan file found</p>";
} else {
    echo "<p>❌ <strong>Laravel:</strong> artisan file not found</p>";
}

// Check if .env exists
if (file_exists('.env')) {
    echo "<p>✅ <strong>Environment:</strong> .env file exists</p>";
} else {
    echo "<p>❌ <strong>Environment:</strong> .env file missing</p>";
}

// Check storage link
if (is_link('public/storage')) {
    echo "<p>✅ <strong>Storage:</strong> Symbolic link exists</p>";
} else {
    echo "<p>❌ <strong>Storage:</strong> Symbolic link missing</p>";
}

// Check recent template files
$templateFiles = [
    'resources/views/vcardTemplates/vcard_car_dealer.blade.php',
    'resources/views/vcardTemplates/vcard_phone_store.blade.php',
    'resources/views/vcardTemplates/vcard_universal_business.blade.php'
];

echo "<h2>📁 Template Files Status:</h2>";
foreach ($templateFiles as $file) {
    if (file_exists($file)) {
        $lastModified = date('Y-m-d H:i:s', filemtime($file));
        echo "<p>✅ <strong>$file:</strong> Exists (Modified: $lastModified)</p>";
    } else {
        echo "<p>❌ <strong>$file:</strong> Missing</p>";
    }
}

// Check if Our Car Shop section was removed
$carDealerFile = 'resources/views/vcardTemplates/vcard_car_dealer.blade.php';
if (file_exists($carDealerFile)) {
    $content = file_get_contents($carDealerFile);
    if (strpos($content, 'Our Car Shop') === false) {
        echo "<p>✅ <strong>Update Verified:</strong> 'Our Car Shop' section successfully removed</p>";
    } else {
        echo "<p>❌ <strong>Update Issue:</strong> 'Our Car Shop' section still present</p>";
    }
}

echo "<h2>🔧 Git Information:</h2>";
if (file_exists('.git/HEAD')) {
    $head = trim(file_get_contents('.git/HEAD'));
    echo "<p><strong>Current Branch:</strong> " . str_replace('ref: refs/heads/', '', $head) . "</p>";
}

echo "<p><strong>Expected Latest Commit:</strong> 97060c0</p>";
echo "<p><strong>Test File Created:</strong> " . __FILE__ . "</p>";
echo "</body></html>";
?>