#!/bin/bash

# Hostinger Storage Symlink Fix Script
# Run this manually on Hostinger to ensure storage symlink is properly created

DEPLOY_PATH="/home/u933773389/domains/smart-keyholder.click/public_html"

echo "🔧 Fixing Storage Symlink on Hostinger..."
echo "📁 Path: $DEPLOY_PATH"

# Navigate to project
cd $DEPLOY_PATH || { echo "❌ Failed to navigate to $DEPLOY_PATH"; exit 1; }

# Remove any broken symlink
echo "🗑️  Removing old symlink..."
rm -f public/storage 2>/dev/null || true

# Create directories if they don't exist
echo "📁 Creating storage directories..."
mkdir -p storage/app/public/profile_images
mkdir -p storage/app/public/background_images
mkdir -p storage/app/public/gallery_images
mkdir -p storage/app/public/product_images
mkdir -p storage/app/public/store_products
mkdir -p storage/app/public/logos
mkdir -p storage/app/public/pwa_icons
mkdir -p storage/app/public/whatsapp_images

# Set permissions on storage directory
echo "🔐 Setting permissions..."
chmod -R 775 storage
chmod -R 755 public

# Try artisan storage:link first
echo "🔗 Attempting storage:link via artisan..."
php artisan storage:link

# Verify or manually create symlink
if [ ! -L "public/storage" ]; then
    echo "⚠️  Artisan symlink failed, creating manually..."
    ln -s ../storage/app/public public/storage
fi

# Final verification
echo "✅ Verifying symlink..."
if [ -L "public/storage" ]; then
    echo "✅ SUCCESS! Storage symlink created at:"
    ls -la public/storage
else
    echo "❌ FAILED! Symlink could not be created"
    exit 1
fi

# Set final permissions
chmod -R 755 public/storage
chmod -R 755 storage/app/public

echo "✅ Storage symlink setup complete!"
echo "Images uploaded will now display at: https://smart-keyholder.click/storage/"
