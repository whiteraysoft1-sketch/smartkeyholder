# Image Storage Fix - Deployment Guide

## Problem
Images are not displaying on the deployed project. This is typically caused by a missing or broken storage symbolic link between the public folder and the storage folder.

## Root Causes
1. Storage symbolic link (`public/storage`) was not created during deployment
2. Symbolic link became broken after server updates
3. Incorrect `APP_URL` or `ASSET_URL` in `.env` configuration
4. File permissions preventing access to stored images

## Solution Overview

### Quick Fix - Automatic Script
We've provided an automated fix script that handles everything:

```bash
cd domains/smart-keyholder.click/public_html
php fix-storage-deployment.php
```

This script will:
✓ Create all necessary storage directories
✓ Create/repair the storage symbolic link
✓ Set correct file permissions
✓ Clear caches to reflect changes
✓ Verify everything is working

### How Images Are Stored and Accessed

#### Image Storage Flow
1. User uploads image through the form
2. Image is stored in `storage/app/public/{type}/` directory
3. File path is saved to database
4. Application generates URL via Storage facade

#### Image Display Flow
1. Database returns stored file path (e.g., `profile_images/filename.jpg`)
2. Laravel Storage generates full URL: `/storage/profile_images/filename.jpg`
3. Browser requests image from `/storage/...`
4. Symbolic link redirects to `storage/app/public/...`
5. Web server serves the image file

### Directory Structure

```
project-root/
├── public/
│   └── storage → ../storage/app/public (symbolic link)
└── storage/app/public/
    ├── profile_images/        # User profile pictures
    ├── background_images/     # User background images
    ├── gallery_images/        # Gallery items
    ├── gallery/              # Alternative gallery path
    ├── product_images/       # Store product images
    ├── store_products/       # Alternative product path
    ├── pwa_icons/           # PWA icons
    │   ├── icons/
    │   └── splash/
    ├── whatsapp_images/     # WhatsApp business images
    ├── installer_uploads/   # Uploaded packages
    └── logos/               # Store logos
```

## Environment Configuration

### Required .env Variables
```env
# Application URL - MUST match your domain
APP_URL=https://yourdomain.com
# OR for alternate domain
ASSET_URL=https://yourdomain.com/storage

# File system configuration
FILESYSTEM_DISK=public

# Database settings (as already configured)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Common Deployment URLs
For Hostinger with cPanel at `145.223.108.4:65002`:
```env
APP_URL=http://145.223.108.4:65002
# OR if custom domain is set up:
APP_URL=https://smartkeyholder.click
```

## Detailed Fix Steps (Manual)

If the automatic script doesn't work, follow these manual steps:

### Step 1: SSH into Your Server
```bash
ssh -p 65002 u244291586@145.223.108.4
cd domains/smartkeyholder.click/public_html
# or
cd public_html
```

### Step 2: Create Storage Directories
```bash
mkdir -p storage/app/public/profile_images
mkdir -p storage/app/public/background_images
mkdir -p storage/app/public/gallery_images
mkdir -p storage/app/public/gallery
mkdir -p storage/app/public/product_images
mkdir -p storage/app/public/store_products
mkdir -p storage/app/public/pwa_icons/icons
mkdir -p storage/app/public/pwa_icons/splash
mkdir -p storage/app/public/whatsapp_images
mkdir -p storage/app/public/installer_uploads
mkdir -p storage/app/public/logos
```

### Step 3: Create Symbolic Link
```bash
# Remove broken link if exists
rm -f public/storage

# Create new symbolic link
php artisan storage:link

# If artisan fails, create manually:
ln -s ../storage/app/public public/storage
```

### Step 4: Set Permissions
```bash
chmod -R 755 storage/
chmod -R 755 public/storage/
chmod -R 755 bootstrap/cache/
```

### Step 5: Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan config:cache
```

## Verification Checklist

### ✓ Check Symbolic Link
```bash
ls -la public/storage
# Should show: public/storage -> ../storage/app/public
```

### ✓ Check Storage Directories
```bash
ls -la storage/app/public/
# Should list all the directories created above
```

### ✓ Test File Permissions
```bash
touch storage/app/public/test.txt
rm storage/app/public/test.txt
# Should work without permission errors
```

### ✓ Test Image Access
1. Log in to the application
2. Upload a profile image
3. Open browser DevTools (F12)
4. Go to Network tab
5. Check if the image file is requested with correct path
6. Verify response status is 200 (success)

### ✓ Check URLs in Browser Console
```javascript
// Open browser console and check these:
console.log(document.querySelector('img[alt="Profile Photo"]').src);
// Should show something like:
// https://yourdomain.com/storage/profile_images/1234567890_profile.jpg
```

## Image URL Examples

After proper setup, image URLs should look like:

### Profile Images
```
URL: https://yourdomain.com/storage/profile_images/1234567890_john.jpg
File: storage/app/public/profile_images/1234567890_john.jpg
```

### Background Images
```
URL: https://yourdomain.com/storage/background_images/1234567890_bg_beach.jpg
File: storage/app/public/background_images/1234567890_bg_beach.jpg
```

### Gallery Images
```
URL: https://yourdomain.com/storage/gallery_images/gallery_photo.jpg
File: storage/app/public/gallery_images/gallery_photo.jpg
```

### PWA Icons
```
URL: https://yourdomain.com/storage/pwa_icons/icons/icon-192.png
File: storage/app/public/pwa_icons/icons/icon-192.png
```

## Troubleshooting

### Images Still Not Showing?

#### 1. Check Network Request
- Open DevTools → Network tab
- Look for image requests
- If 404 error: The symbolic link is broken
- If 403 error: Permission issue

#### 2. Verify Symlink
```bash
readlink public/storage
# Should show: ../storage/app/public
```

#### 3. Check File Actually Exists
```bash
# Check if the file exists on disk
ls -la storage/app/public/profile_images/
```

#### 4. Verify APP_URL
```php
// In Laravel tinker:
php artisan tinker
> config('app.url')
// Should show your correct domain
```

#### 5. Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
# Look for any errors about storage or file operations
```

#### 6. Test Storage Facade
```bash
php artisan tinker
> Storage::disk('public')->url('profile_images/test.jpg')
// Should return correct URL with your domain
```

## Automatic Deployment Integration

For future deployments, include these steps in your deployment script:

```bash
#!/bin/bash

# ... existing deployment steps ...

# Fix storage after deployment
php fix-storage-deployment.php

# Or use artisan directly
php artisan storage:link

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan config:cache
```

## GitHub Actions Deployment

If using GitHub Actions, add this to your workflow:

```yaml
- name: Setup Storage
  run: |
    php artisan storage:link
    mkdir -p storage/app/public/{profile_images,background_images,gallery_images,product_images}
    chmod -R 755 storage

- name: Clear Caches
  run: |
    php artisan cache:clear
    php artisan config:cache
```

## Support Resources

### Laravel Storage Documentation
- [Laravel Filesystem Docs](https://laravel.com/docs/filesystem)
- [Storage Configuration](https://laravel.com/docs/configuration#file-storage)

### Common Issues
- Symbolic links not supported on Windows - use File instead
- Some hosting providers don't allow symbolic links - use cloud storage (S3)
- File permissions issues - contact hosting provider

## Next Steps

1. Run the fix script: `php fix-storage-deployment.php`
2. Verify using the checklist above
3. Test uploading images through the application
4. Monitor storage usage and clean up old files regularly
5. Consider implementing cloud storage (S3) for production

---

**Last Updated:** November 30, 2025
**Version:** 1.0
