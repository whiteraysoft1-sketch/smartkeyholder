#!/bin/bash

# Navigate to project directory
cd /home/u933773389/domains/smart-keyholder.click/public_html

echo "=== Running Production Migration ==="
echo "This will add business information fields to user_profiles table"
echo "This is SAFE - it only adds new columns, won't delete any data"
echo ""

# Run the specific migration for business fields
php artisan migrate --force

echo ""
echo "=== Migration Complete ==="
echo "Business fields added successfully!"
echo ""

# Clear all caches
echo "Clearing caches..."
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear

echo ""
echo "=== All Done! ==="
echo "Your hosted site now has business information fields"
