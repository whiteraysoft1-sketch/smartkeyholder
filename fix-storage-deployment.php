<?php
/**
 * Storage Link Fix and Verification Script
 * 
 * This script should be run on the production server to ensure:
 * 1. Storage symbolic link is properly created
 * 2. Storage directories exist
 * 3. File permissions are correct
 * 4. Images can be accessed via web
 * 
 * Usage: php fix-storage-deployment.php
 */

// Define paths
$basePath = __DIR__;
$storagePath = $basePath . '/storage/app/public';
$publicStoragePath = $basePath . '/public/storage';

// Color codes for console output
$colors = [
    'reset' => "\033[0m",
    'success' => "\033[32m",
    'error' => "\033[31m",
    'warning' => "\033[33m",
    'info' => "\033[36m",
];

function log_message($type, $message) {
    global $colors;
    $color = $colors[$type] ?? $colors['info'];
    echo $color . $message . $colors['reset'] . "\n";
}

log_message('info', "========================================");
log_message('info', "Storage Link Fix & Verification Script");
log_message('info', "========================================\n");

// Step 1: Check if Laravel artisan exists
log_message('info', "Step 1: Checking Laravel installation...");
if (file_exists($basePath . '/artisan')) {
    log_message('success', "✓ Laravel artisan found");
} else {
    log_message('error', "✗ Laravel artisan not found");
    exit(1);
}

// Step 2: Create storage directories
log_message('info', "\nStep 2: Creating storage directories...");
$directories = [
    'profile_images',
    'background_images',
    'gallery_images',
    'gallery',
    'product_images',
    'store_products',
    'pwa_icons',
    'pwa/icons',
    'pwa/splash',
    'whatsapp_images',
    'installer_uploads',
    'logos',
];

foreach ($directories as $dir) {
    $fullPath = $storagePath . '/' . $dir;
    if (!is_dir($fullPath)) {
        @mkdir($fullPath, 0755, true);
        if (is_dir($fullPath)) {
            log_message('success', "✓ Created: $dir");
        } else {
            log_message('warning', "⚠ Could not create: $dir");
        }
    } else {
        log_message('success', "✓ Already exists: $dir");
    }
}

// Step 3: Remove broken symbolic link if exists
log_message('info', "\nStep 3: Checking storage symbolic link...");
if (is_link($publicStoragePath)) {
    if (!is_dir($publicStoragePath)) {
        log_message('warning', "⚠ Broken symbolic link found, removing...");
        @unlink($publicStoragePath);
        log_message('success', "✓ Removed broken link");
    } else {
        log_message('success', "✓ Symbolic link already exists and is valid");
    }
} elseif (is_dir($publicStoragePath)) {
    log_message('warning', "⚠ Storage directory exists but not as a symbolic link");
    log_message('info', "  Attempting to create symlink via artisan...");
}

// Step 4: Create storage link via artisan
if (!is_link($publicStoragePath) || !is_dir($publicStoragePath)) {
    log_message('info', "\nStep 4: Creating symbolic link using artisan...");
    $output = [];
    $return_var = 0;
    exec("cd " . escapeshellarg($basePath) . " && php artisan storage:link 2>&1", $output, $return_var);
    
    if ($return_var === 0 && is_link($publicStoragePath)) {
        log_message('success', "✓ Symbolic link created successfully");
        log_message('info', implode("\n", $output));
    } else {
        log_message('warning', "⚠ Artisan command may have failed, attempting manual symlink...");
        
        // Manual symlink creation
        $targetPath = '../storage/app/public';
        if (!is_link($publicStoragePath)) {
            @unlink($publicStoragePath);
        }
        
        if (@symlink($targetPath, $publicStoragePath)) {
            log_message('success', "✓ Symbolic link created manually");
        } else {
            log_message('error', "✗ Could not create symbolic link");
            log_message('info', "  Target: $targetPath");
            log_message('info', "  Link: $publicStoragePath");
        }
    }
}

// Step 5: Fix permissions
log_message('info', "\nStep 5: Setting file permissions...");
$paths_to_chmod = [
    $basePath . '/storage',
    $basePath . '/bootstrap/cache',
    $publicStoragePath,
];

foreach ($paths_to_chmod as $path) {
    if (is_dir($path)) {
        @chmod($path, 0755);
        log_message('success', "✓ Set permissions: " . str_replace($basePath, '', $path));
    }
}

// Step 6: Clear caches
log_message('info', "\nStep 6: Clearing caches...");
$cache_commands = [
    'config:clear',
    'cache:clear',
    'view:clear',
];

foreach ($cache_commands as $cmd) {
    exec("cd " . escapeshellarg($basePath) . " && php artisan $cmd 2>&1", $output, $return_var);
    if ($return_var === 0) {
        log_message('success', "✓ Executed: $cmd");
    } else {
        log_message('warning', "⚠ Warning executing: $cmd");
    }
}

// Step 7: Rebuild caches
log_message('info', "\nStep 7: Rebuilding caches...");
$build_commands = [
    'config:cache',
];

foreach ($build_commands as $cmd) {
    exec("cd " . escapeshellarg($basePath) . " && php artisan $cmd 2>&1", $output, $return_var);
    if ($return_var === 0) {
        log_message('success', "✓ Executed: $cmd");
    }
}

// Step 8: Verification
log_message('info', "\nStep 8: Verification...");

$issues = [];

// Check symlink
if (!is_link($publicStoragePath)) {
    $issues[] = "Symbolic link not found at public/storage";
} else {
    log_message('success', "✓ Symbolic link exists");
}

// Check if symlink is valid
if (is_link($publicStoragePath) && !is_dir($publicStoragePath)) {
    $issues[] = "Symbolic link exists but points to invalid location";
} elseif (is_link($publicStoragePath)) {
    log_message('success', "✓ Symbolic link points to valid location");
}

// Check if directories exist
$critical_dirs = ['profile_images', 'gallery_images', 'background_images'];
foreach ($critical_dirs as $dir) {
    $fullPath = $storagePath . '/' . $dir;
    if (!is_dir($fullPath)) {
        $issues[] = "Missing directory: storage/app/public/$dir";
    } else {
        log_message('success', "✓ Directory exists: $dir");
    }
}

// Check permissions
if (!is_writable($storagePath)) {
    $issues[] = "Storage directory is not writable";
} else {
    log_message('success', "✓ Storage directory is writable");
}

// Final summary
log_message('info', "\n========================================");
if (empty($issues)) {
    log_message('success', "✅ All checks passed!");
    log_message('info', "\nStorage configuration is ready for use.");
    log_message('info', "Images should now display correctly.\n");
} else {
    log_message('error', "⚠ Issues found:");
    foreach ($issues as $issue) {
        log_message('error', "  • $issue");
    }
    log_message('info', "\nPlease address these issues manually.\n");
}

// Display storage structure
log_message('info', "\nStorage Structure:");
log_message('info', "==================");
if (is_dir($storagePath)) {
    $dirs = @scandir($storagePath);
    if ($dirs) {
        foreach ($dirs as $item) {
            if ($item !== '.' && $item !== '..' && is_dir($storagePath . '/' . $item)) {
                log_message('info', "  📁 $item/");
            }
        }
    }
}

log_message('info', "\nFor image access in your application:");
log_message('info', "  Profile Images: /storage/profile_images/filename");
log_message('info', "  Gallery Images: /storage/gallery_images/filename");
log_message('info', "  Background Images: /storage/background_images/filename\n");

?>
