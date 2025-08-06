# Production Deployment Guide

## Server Details
- **Host:** 145.223.108.4
- **Port:** 65002
- **Username:** u244291586
- **Database:** u244291586_smart_db

## Deployment Checklist

### 1. Environment Configuration
- [x] Update APP_URL to production URL: `http://145.223.108.4:65002`
- [x] Set APP_ENV to `production`
- [x] Set APP_DEBUG to `false`
- [x] Configure database credentials
- [x] Set FILESYSTEM_DISK to `public`

### 2. Storage Configuration
- [x] Create storage symbolic link: `php artisan storage:link`
- [x] Verify storage directories exist and are writable:
  - storage/app/public/profile_images/
  - storage/app/public/gallery/
  - storage/app/public/background_images/
  - storage/app/public/logos/
  - storage/app/public/pwa_icons/
  - storage/app/public/store_products/

### 3. Cache and Optimization
- [x] Clear configuration cache: `php artisan config:clear`
- [x] Cache configuration: `php artisan config:cache`
- [x] Clear route cache: `php artisan route:clear`
- [x] Clear view cache: `php artisan view:clear`

### 4. Additional Steps for Production
Run these commands on the production server:

```bash
# Optimize for production
php artisan optimize

# Cache routes (optional, only if no closures in routes)
php artisan route:cache

# Cache views
php artisan view:cache
```

### 5. File Permissions
Ensure these directories are writable:
- storage/
- bootstrap/cache/
- public/storage/

### 6. Testing Image URLs
After deployment, test image access by visiting:
- http://145.223.108.4:65002/test-storage.php

### 7. Common Issues and Solutions

#### Images not showing:
1. Check if storage link exists: `ls -la public/storage`
2. Verify APP_URL is correct in .env
3. Clear all caches
4. Check file permissions

#### Database connection issues:
1. Verify database credentials in .env
2. Ensure database exists on server
3. Run migrations if needed: `php artisan migrate`

### 8. Environment Variables Summary
```
APP_ENV=production
APP_DEBUG=false
APP_URL=http://145.223.108.4:65002
FILESYSTEM_DISK=public
DB_HOST=localhost
DB_DATABASE=u244291586_smart_db
DB_USERNAME=u244291586
DB_PASSWORD=Kaggwa@96
```

## Post-Deployment Verification
1. Visit the application URL
2. Check that images load correctly
3. Test user registration/login
4. Verify QR code generation works
5. Test file uploads (profile images, gallery items)