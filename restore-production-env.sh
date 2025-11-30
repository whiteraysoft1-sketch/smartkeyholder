#!/bin/bash
# Script to restore production .env settings on Hostinger

cat > /home/u933773389/domains/smart-keyholder.click/public_html/.env << 'EOF'
APP_NAME="QR Code App"
APP_ENV=production
APP_KEY=base64:g5g3ASiSWqUUXufhX8/hmFCltkSJiFd6+AlwW9/1/mU=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://smart-keyholder.click

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Database Configuration for Hostinger
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u933773389_smart
DB_USERNAME=u933773389_tag
DB_PASSWORD=Kaggwa25smart

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@smartkeyholder.click
MAIL_PASSWORD=Kaggwa@96
MAIL_ENCRYPTION=""
MAIL_FROM_ADDRESS=noreply@smartkeyholder.click
MAIL_FROM_NAME="QR Code App"

# Flutterwave Payment Configuration
FLUTTERWAVE_PUBLIC_KEY=your_flutterwave_public_key
FLUTTERWAVE_SECRET_KEY=your_flutterwave_secret_key
FLUTTERWAVE_SECRET_HASH=your_flutterwave_secret_hash
FLUTTERWAVE_ENVIRONMENT=live

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# VAPID Keys for PWA Push Notifications
VAPID_PUBLIC_KEY=izCb5pRgksWljhXNSZQA1fRaIl22XejxIkCAfacT6kRwUzYJzrfkHdj8gTQS1EwzzQxs75t2bGA368AeI03azNw=
VAPID_PRIVATE_KEY=z+bk/qZ1WuxdQGrBAQlrnFYuwiSWBcHuzji0uaoxK1A=
VAPID_SUBJECT=mailto:admin@smarttag.com

VITE_APP_NAME="${APP_NAME}"
EOF

echo "✅ Production .env file has been restored!"
echo "🧹 Clearing Laravel caches..."
cd /home/u933773389/domains/smart-keyholder.click/public_html
php artisan config:clear
php artisan cache:clear
echo "✅ Caches cleared. Application should now connect to production database."
