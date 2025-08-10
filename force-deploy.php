<?php
// Force Deployment Script
// Run this on your server to manually trigger deployment steps

echo "🚀 Force Deployment Script\n";
echo "========================\n\n";

// Change to the correct directory
$deployPath = '/home/u574849695/domains/smart-keyholder.click/public_html';
if (is_dir($deployPath)) {
    chdir($deployPath);
    echo "✅ Changed to deployment directory: $deployPath\n";
} else {
    echo "❌ Deployment directory not found: $deployPath\n";
    echo "Current directory: " . getcwd() . "\n";
}

// Function to run command and show output
function runCommand($command, $description) {
    echo "\n🔧 $description\n";
    echo "Command: $command\n";
    
    $output = [];
    $returnCode = 0;
    exec($command . ' 2>&1', $output, $returnCode);
    
    foreach ($output as $line) {
        echo "   $line\n";
    }
    
    if ($returnCode === 0) {
        echo "✅ Success\n";
    } else {
        echo "❌ Failed (Return code: $returnCode)\n";
    }
    
    return $returnCode === 0;
}

// Step 1: Check git status
runCommand('git status', 'Checking Git Status');

// Step 2: Force pull latest changes
runCommand('git fetch origin', 'Fetching latest changes');
runCommand('git reset --hard origin/master', 'Force reset to latest master');

// Step 3: Check if files were updated
echo "\n📁 Checking key files:\n";
$files = [
    'resources/views/vcardTemplates/vcard_car_dealer.blade.php',
    'resources/views/vcardTemplates/vcard_phone_store.blade.php',
    'deployment-check.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $lastModified = date('Y-m-d H:i:s', filemtime($file));
        echo "✅ $file (Modified: $lastModified)\n";
    } else {
        echo "❌ $file (Missing)\n";
    }
}

// Step 4: Clear all caches
runCommand('php artisan config:clear', 'Clearing config cache');
runCommand('php artisan view:clear', 'Clearing view cache');
runCommand('php artisan route:clear', 'Clearing route cache');
runCommand('php artisan cache:clear', 'Clearing application cache');

// Step 5: Remove compiled files
echo "\n🗑️ Removing compiled files:\n";
$filesToRemove = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes-v7.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/packages.php'
];

foreach ($filesToRemove as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "✅ Removed: $file\n";
    } else {
        echo "ℹ️ Not found: $file\n";
    }
}

// Step 6: Rebuild caches
runCommand('php artisan config:cache', 'Rebuilding config cache');
runCommand('php artisan route:cache', 'Rebuilding route cache');
runCommand('php artisan view:cache', 'Rebuilding view cache');

// Step 7: Check final status
echo "\n📊 Final Status Check:\n";
echo "Current time: " . date('Y-m-d H:i:s') . "\n";
echo "PHP Version: " . phpversion() . "\n";

// Check if Our Car Shop was removed
$carDealerFile = 'resources/views/vcardTemplates/vcard_car_dealer.blade.php';
if (file_exists($carDealerFile)) {
    $content = file_get_contents($carDealerFile);
    if (strpos($content, 'Our Car Shop') === false) {
        echo "✅ Update verified: 'Our Car Shop' section removed\n";
    } else {
        echo "❌ Update issue: 'Our Car Shop' section still present\n";
    }
}

echo "\n🎉 Force deployment completed!\n";
echo "Visit your site to check if changes are now visible.\n";
?>