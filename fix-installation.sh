#!/bin/bash

echo "🔧 Fixing Nexitel POS Installation Issues..."

# Make artisan executable
chmod +x artisan

# Clear any cached config that might be causing issues
if [ -f "bootstrap/cache/config.php" ]; then
    rm bootstrap/cache/config.php
    echo "✅ Cleared config cache"
fi

if [ -f "bootstrap/cache/services.php" ]; then
    rm bootstrap/cache/services.php
    echo "✅ Cleared services cache"
fi

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

# Install composer dependencies without scripts first
echo "📦 Installing Composer dependencies..."
composer install --no-scripts --no-dev --optimize-autoloader

# Generate app key if not exists
if ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate --force
    echo "🔑 Generated application key"
fi

# Now run the scripts
echo "🔄 Running post-install scripts..."
composer dump-autoload --optimize

# Publish Spatie Permission
echo "📊 Publishing Spatie Permission..."
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

echo ""
echo "🎉 Installation fixed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Configure your database in .env file"
echo "2. Run: php artisan migrate"
echo "3. Run: php artisan db:seed --class=RolePermissionSeeder"
echo "4. Start server: php artisan serve"
echo ""
echo "🔐 Default login: admin / password"
