#!/bin/bash
echo "Creating Laravel directories..."

mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo "Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "Directories created successfully!"
