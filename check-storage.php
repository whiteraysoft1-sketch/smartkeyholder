<?php
// Emergency script to check and fix storage symlink on Hostinger
// Upload this file to your public_html directory and run it via browser

$deployPath = '/home/u933773389/domains/smart-keyholder.click/public_html';
$storagePath = $deployPath . '/storage/app/public';
$symlinkPath = $deployPath . '/public/storage';

echo "<h2>Storage Diagnostic Tool</h2>";
echo "<hr>";

// Check if storage directory exists
echo "<h3>1. Checking storage directory</h3>";
if (is_dir($storagePath)) {
    echo "✅ Storage directory exists: $storagePath<br>";
    $files = scandir($storagePath);
    echo "📁 Subdirectories: " . implode(', ', array_diff($files, ['.', '..'])) . "<br>";
} else {
    echo "❌ Storage directory NOT found: $storagePath<br>";
}

// Check if public/storage symlink exists
echo "<h3>2. Checking public/storage symlink</h3>";
if (file_exists($symlinkPath)) {
    if (is_link($symlinkPath)) {
        $target = readlink($symlinkPath);
        echo "🔗 Symlink exists<br>";
        echo "📍 Points to: $target<br>";
        
        if ($target === $storagePath) {
            echo "✅ Symlink points to correct location<br>";
        } else {
            echo "⚠️ Symlink points to WRONG location<br>";
            echo "Expected: $storagePath<br>";
            echo "Actual: $target<br>";
        }
    } else {
        echo "⚠️ public/storage exists but is NOT a symlink (it's a directory)<br>";
    }
} else {
    echo "❌ Symlink does NOT exist: $symlinkPath<br>";
}

// Check uploaded images
echo "<h3>3. Checking for uploaded images</h3>";
$imageDirs = ['profile_images', 'background_images', 'gallery_images', 'product_images'];
foreach ($imageDirs as $dir) {
    $dirPath = $storagePath . '/' . $dir;
    if (is_dir($dirPath)) {
        $count = count(array_diff(scandir($dirPath), ['.', '..']));
        echo "📂 $dir: $count files<br>";
    } else {
        echo "📂 $dir: directory not found<br>";
    }
}

// Fix attempt
echo "<h3>4. Attempting to fix symlink</h3>";
if (file_exists($symlinkPath) && !is_link($symlinkPath)) {
    echo "🗑️ Removing old public/storage directory...<br>";
    exec("rm -rf $symlinkPath", $output1, $result1);
    echo ($result1 === 0) ? "✅ Removed<br>" : "❌ Failed to remove<br>";
}

if (!file_exists($symlinkPath)) {
    echo "🔧 Creating new symlink...<br>";
    $result = @symlink($storagePath, $symlinkPath);
    if ($result) {
        echo "✅ Symlink created successfully!<br>";
    } else {
        echo "❌ Failed to create symlink. Trying alternative method...<br>";
        exec("ln -s $storagePath $symlinkPath 2>&1", $output2, $result2);
        if ($result2 === 0) {
            echo "✅ Symlink created via shell command!<br>";
        } else {
            echo "❌ Shell command also failed: " . implode("\n", $output2) . "<br>";
        }
    }
}

// Final verification
echo "<h3>5. Final Verification</h3>";
if (is_link($symlinkPath)) {
    echo "✅ Symlink is now working!<br>";
    echo "🔗 " . readlink($symlinkPath) . " → $storagePath<br>";
} else {
    echo "❌ Symlink still not working. Manual intervention needed.<br>";
}

echo "<hr>";
echo "<p><strong>Next steps:</strong></p>";
echo "<ul>";
echo "<li>If images were deleted, you'll need to re-upload them through the dashboard</li>";
echo "<li>Delete this file after checking (for security)</li>";
echo "</ul>";
