#!/bin/bash

# Storage Fix Script for Smart Key Holder
# Run this script on your server to fix storage issues

echo "🔧 Fixing storage issues..."

# Navigate to project directory
cd domains/smart-keyholder.click/public_html

# Remove existing storage link if it exists
if [ -L "public/storage" ]; then
    echo "Removing existing storage link..."
    rm public/storage
fi

# Create fresh storage symbolic link
echo "Creating storage symbolic link..."
php artisan storage:link

# Create necessary storage directories
echo "Creating storage directories..."
mkdir -p storage/app/public/profile_images
mkdir -p storage/app/public/background_images
mkdir -p storage/app/public/gallery_images
mkdir -p storage/app/public/product_images
mkdir -p storage/app/public/pwa_icons
mkdir -p storage/app/public/whatsapp_images

# Set proper permissions
echo "Setting permissions..."
chmod -R 755 storage
chmod -R 755 public/storage
chmod -R 755 storage/app/public

# Clear and rebuild caches
echo "Clearing caches..."
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Storage fix completed!"
echo ""
echo "📋 Verification steps:"
echo "1. Check if public/storage link exists: ls -la public/storage"
echo "2. Check storage directories: ls -la storage/app/public/"
echo "3. Test image upload functionality"