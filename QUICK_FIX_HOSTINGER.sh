#!/bin/bash

# Quick Image Fix Script for Hostinger Server
# Copy and paste these commands directly into your SSH terminal

# Navigate to project
cd domains/smartkeyholder.click/public_html

# Method 1: Use the automated PHP fix script (RECOMMENDED)
echo "Running automated fix script..."
php fix-storage-deployment.php

# If the above doesn't work, use Method 2 below:

# Method 2: Manual commands (fallback)
# Uncomment and run if Method 1 doesn't work completely

# Create directories
# mkdir -p storage/app/public/profile_images
# mkdir -p storage/app/public/background_images
# mkdir -p storage/app/public/gallery_images
# mkdir -p storage/app/public/gallery
# mkdir -p storage/app/public/product_images
# mkdir -p storage/app/public/store_products
# mkdir -p storage/app/public/pwa_icons/icons
# mkdir -p storage/app/public/pwa_icons/splash
# mkdir -p storage/app/public/whatsapp_images
# mkdir -p storage/app/public/installer_uploads
# mkdir -p storage/app/public/logos

# Create symlink
# rm -f public/storage
# php artisan storage:link

# Fix permissions
# chmod -R 755 storage/
# chmod -R 755 public/storage/
# chmod -R 755 bootstrap/cache/

# Clear caches
# php artisan cache:clear
# php artisan config:clear
# php artisan view:clear
# php artisan config:cache

# Verification Commands
echo ""
echo "=== VERIFICATION COMMANDS ==="
echo ""
echo "1. Check symbolic link:"
ls -la public/storage

echo ""
echo "2. Check storage directories:"
ls -la storage/app/public/ | head -20

echo ""
echo "3. Check permissions:"
ls -la storage/ | grep app

echo ""
echo "4. Test image URL generation (copy and run in PHP Artisan Tinker):"
echo "   php artisan tinker"
echo "   Storage::disk('public')->url('profile_images/test.jpg')"
echo "   Exit with: exit"
