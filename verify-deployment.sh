#!/bin/bash

# Deployment Verification Script
echo "🔍 Verifying deployment setup..."

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel project directory"
    exit 1
fi

echo "✅ In Laravel project directory"

# Check storage link
if [ -L "public/storage" ]; then
    echo "✅ Storage symbolic link exists"
    ls -la public/storage
else
    echo "❌ Storage symbolic link missing"
    echo "Creating storage link..."
    php artisan storage:link
fi

# Check storage directories
echo "📁 Checking storage directories..."
for dir in profile_images background_images gallery_images product_images pwa_icons; do
    if [ -d "storage/app/public/$dir" ]; then
        echo "✅ storage/app/public/$dir exists"
    else
        echo "❌ storage/app/public/$dir missing - creating..."
        mkdir -p "storage/app/public/$dir"
        chmod 755 "storage/app/public/$dir"
    fi
done

# Check permissions
echo "🔐 Checking permissions..."
echo "Storage directory permissions:"
ls -la storage/

echo "Public storage permissions:"
ls -la public/storage 2>/dev/null || echo "Public storage link not found"

# Check environment file
if [ -f ".env" ]; then
    echo "✅ .env file exists"
    echo "Current FILESYSTEM_DISK setting:"
    grep "FILESYSTEM_DISK" .env || echo "FILESYSTEM_DISK not set"
    echo "Current APP_URL setting:"
    grep "APP_URL" .env || echo "APP_URL not set"
else
    echo "❌ .env file missing"
fi

# Test storage functionality
echo "🧪 Testing storage functionality..."
php artisan tinker --execute="
\$disk = Storage::disk('public');
\$disk->put('test-file.txt', 'Test content');
if (\$disk->exists('test-file.txt')) {
    echo 'Storage write test: PASSED\n';
    echo 'File URL: ' . \$disk->url('test-file.txt') . '\n';
    \$disk->delete('test-file.txt');
} else {
    echo 'Storage write test: FAILED\n';
}
"

echo "🏁 Verification complete!"
echo ""
echo "📋 Next steps if issues found:"
echo "1. Run: php artisan storage:link"
echo "2. Set permissions: chmod -R 755 storage public/storage"
echo "3. Check .env FILESYSTEM_DISK=public"
echo "4. Verify APP_URL matches your domain"