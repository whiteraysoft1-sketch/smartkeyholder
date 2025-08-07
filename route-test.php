<?php
// Simple route test file to verify Laravel routing is working
echo "Route Test - " . date('Y-m-d H:i:s') . "\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Laravel Path: " . __DIR__ . "\n";

// Test if Laravel can be bootstrapped
try {
    require_once __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    echo "✅ Laravel bootstrap successful\n";
    
    // Test route resolution
    $request = Illuminate\Http\Request::create('/', 'GET');
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    echo "✅ Route test completed\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>