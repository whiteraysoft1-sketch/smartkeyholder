# Storage Troubleshooting Guide

## Common Storage Issues After Deployment

### Problem: Images not displaying after deployment
This typically happens when the storage symbolic link is missing or broken.

### Root Causes:
1. Missing `php artisan storage:link` command in deployment
2. Incorrect file permissions
3. Missing storage directories
4. Wrong filesystem configuration

## Quick Fix Commands

### 1. Manual Fix on Server
```bash
# SSH into your server and run:
cd domains/smart-keyholder.click/public_html

# Remove existing broken link
rm -f public/storage

# Create fresh storage link
php artisan storage:link

# Create directories
mkdir -p storage/app/public/{profile_images,background_images,gallery_images,product_images,pwa_icons,whatsapp_images}

# Set permissions
chmod -R 755 storage public/storage storage/app/public
```

### 2. Using the Fix Script
```bash
# Make script executable
chmod +x fix-storage.sh

# Run the script
./fix-storage.sh
```

## Verification Steps

### 1. Check Storage Link
```bash
ls -la public/storage
# Should show: public/storage -> ../storage/app/public
```

### 2. Check Storage Directories
```bash
ls -la storage/app/public/
# Should show directories: profile_images, background_images, etc.
```

### 3. Test File Upload
- Try uploading a profile image
- Check if it appears correctly
- Verify the URL structure

## Environment Configuration

### Production Settings
Ensure your `.env` file has:
```env
FILESYSTEM_DISK=public
APP_URL=https://your-domain.com
```

### File Permissions
```bash
# Storage directories
chmod -R 755 storage/
chmod -R 755 public/storage/

# Bootstrap cache
chmod -R 755 bootstrap/cache/
```

## Common File Paths

### Profile Images
- Storage: `storage/app/public/profile_images/`
- URL: `https://your-domain.com/storage/profile_images/filename.jpg`

### Background Images
- Storage: `storage/app/public/background_images/`
- URL: `https://your-domain.com/storage/background_images/filename.jpg`

### Gallery Images
- Storage: `storage/app/public/gallery_images/`
- URL: `https://your-domain.com/storage/gallery_images/filename.jpg`

### PWA Icons
- Storage: `storage/app/public/pwa_icons/`
- URL: `https://your-domain.com/storage/pwa_icons/filename.png`

## Debugging Tips

### 1. Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

### 2. Test Storage Disk
```php
// In tinker or a test route
Storage::disk('public')->put('test.txt', 'Hello World');
Storage::disk('public')->exists('test.txt');
Storage::disk('public')->url('test.txt');
```

### 3. Verify URL Generation
```php
// Check if URLs are generated correctly
$profile = UserProfile::first();
echo $profile->profile_image_url;
```

## Prevention

### Updated Deployment Script
The deployment script now includes:
- `php artisan storage:link`
- Directory creation
- Permission setting
- Cache clearing

### Regular Maintenance
- Monitor storage usage
- Check file permissions after server updates
- Verify symbolic links after deployments

## Support

If issues persist:
1. Check server error logs
2. Verify hosting provider file system permissions
3. Contact hosting support for symbolic link issues
4. Consider using cloud storage (S3) for production