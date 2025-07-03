#!/bin/bash

echo "🚀 Setting up Nexitel POS System..."

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer first."
    exit 1
fi

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.1 or higher."
    exit 1
fi

echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "📝 Setting up environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Environment file created. Please update database credentials in .env"
else
    echo "⚠️  Environment file already exists."
fi

echo "🔑 Generating application key..."
php artisan key:generate

echo "📊 Publishing Spatie Permission migrations..."
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

echo "🗄️  Running database migrations..."
read -p "Have you configured your database in .env? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate
    echo "🌱 Seeding roles and permissions..."
    php artisan db:seed --class=RolePermissionSeeder
else
    echo "⚠️  Please configure your database in .env and run:"
    echo "   php artisan migrate"
    echo "   php artisan db:seed --class=RolePermissionSeeder"
fi

echo "🔗 Creating storage link..."
php artisan storage:link

echo "🧹 Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "🎉 Nexitel POS System setup complete!"
echo ""
echo "📋 Next steps:"
echo "1. Configure your database in .env file"
echo "2. Run: php artisan migrate"
echo "3. Run: php artisan db:seed --class=RolePermissionSeeder"
echo "4. Start the server: php artisan serve"
echo ""
echo "🔐 Default admin credentials:"
echo "   Username: admin"
echo "   Password: password"
echo ""
echo "🌐 Access the application at: http://localhost:8000"
