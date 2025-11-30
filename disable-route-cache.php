<?php

// Disable route caching permanently by removing route cache files
$bootstrapCache = __DIR__ . '/bootstrap/cache';
$files = glob($bootstrapCache . '/routes-*.php');

foreach ($files as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Deleted: $file\n";
    }
}

echo "Route cache disabled successfully!\n";
echo "Run this after every deployment if routes show HEAD only error.\n";
