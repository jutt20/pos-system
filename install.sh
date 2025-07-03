#!/bin/bash

echo "Setting up Nexitel POS System..."

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database
echo "Please create your database and update .env file with database credentials"
echo "Then run the following commands:"
echo ""
echo "php artisan migrate"
echo "php artisan vendor:publish --provider=\"Spatie\Permission\PermissionServiceProvider\""
echo "php artisan migrate"
echo "php artisan db:seed --class=RolePermissionSeeder"
echo "php artisan storage:link"
echo "php artisan serve"
echo ""
echo "Default admin credentials:"
echo "Username: admin"
echo "Password: password"
