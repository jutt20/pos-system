#!/bin/bash

echo "🔧 Fixing Laravel 10 Nexitel POS Installation..."

# Remove Laravel 11 specific files
rm -f bootstrap/providers.php

# Make artisan executable
chmod +x artisan

# Clear any problematic cache
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# Create necessary directories
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo "📁 Created necessary directories"

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "🔐 Set proper permissions"

# Check if .env exists
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "📝 Created .env file"
fi

# Clear composer cache and reinstall
echo "🧹 Clearing Composer cache..."
composer clear-cache

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-scripts --optimize-autoloader

# Generate app key
echo "🔑 Generating application key..."
php artisan key:generate --force

# Clear and cache config
echo "⚙️ Clearing configuration cache..."
php artisan config:clear
php artisan config:cache

# Publish Spatie Permission
echo "📊 Publishing Spatie Permission..."
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

echo ""
echo "🎉 Laravel 10 installation fixed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Configure your database in .env file"
echo "2. Run: php artisan migrate"
echo "3. Run: php artisan db:seed --class=RolePermissionSeeder"
echo "4. Start server: php artisan serve"
echo ""
echo "🔐 Default login: admin / password"
