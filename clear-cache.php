<?php
/**
 * Clear Laravel Caches
 * Access via: https://smart-keyholder.click/clear-cache.php
 */

// Set the base path
$basePath = __DIR__;

// Load Laravel
require_once $basePath . '/bootstrap/app.php';

$app = require_once $basePath . '/bootstrap/app.php';

// Get the Artisan kernel
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

echo "<pre>";
echo "🧹 Clearing Laravel Caches...\n\n";

// Clear route cache
echo "1️⃣ Clearing route cache...\n";
$kernel->call('route:clear');
echo "✅ Route cache cleared\n\n";

// Clear config cache
echo "2️⃣ Clearing config cache...\n";
$kernel->call('config:clear');
echo "✅ Config cache cleared\n\n";

// Clear view cache
echo "3️⃣ Clearing view cache...\n";
$kernel->call('view:clear');
echo "✅ View cache cleared\n\n";

// Clear general cache
echo "4️⃣ Clearing general cache...\n";
$kernel->call('cache:clear');
echo "✅ General cache cleared\n\n";

// Optimize
echo "5️⃣ Optimizing application...\n";
$kernel->call('optimize');
echo "✅ Application optimized\n\n";

echo "✅ All caches cleared successfully!\n";
echo "</pre>";
echo "<h2>Now try visiting <a href='https://smart-keyholder.click/'>https://smart-keyholder.click/</a></h2>";
?>
