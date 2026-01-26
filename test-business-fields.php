<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $columns = Illuminate\Support\Facades\Schema::getColumnListing('user_profiles');
    
    $businessFields = ['business_name', 'business_phone', 'business_email', 'business_address'];
    
    echo "=== User Profiles Table Columns ===\n";
    echo "Total columns: " . count($columns) . "\n\n";
    
    echo "Business-related columns:\n";
    foreach ($businessFields as $field) {
        $exists = in_array($field, $columns);
        echo "  - $field: " . ($exists ? "✓ EXISTS" : "✗ MISSING") . "\n";
    }
    
    echo "\n=== All columns in user_profiles ===\n";
    foreach ($columns as $column) {
        echo "  - $column\n";
    }
    
    echo "\n=== Test PASSED ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
