#!/bin/bash

echo "🔧 Fixing Laravel Permissions and Directories..."

# Create all necessary directories
mkdir -p bootstrap/cache
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

echo "📁 Created all necessary directories"

# Clear any existing problematic cache
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

echo "🧹 Cleared cache files"

# Set proper permissions
chmod -R 775 bootstrap/cache
chmod -R 775 storage
chown -R www-data:www-data bootstrap/cache storage 2>/dev/null || true

echo "🔐 Set permissions"

echo "✅ Permissions fixed! Now run: composer install"
