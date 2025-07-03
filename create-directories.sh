#!/bin/bash

echo "Creating Laravel storage directories..."

# Create storage directories
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Create bootstrap cache directory
mkdir -p bootstrap/cache

# Create public storage link directory
mkdir -p public/storage

echo "Directories created successfully!"
echo ""
echo "Setting permissions..."

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "Permissions set successfully!"
echo ""
echo "You can now run: php artisan serve"
