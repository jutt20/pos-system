@echo off
echo ========================================
echo    NEXITEL POS - DATABASE FIX
echo ========================================

echo Step 1: Dropping existing tables...
php artisan migrate:reset --force

echo Step 2: Running fresh migrations...
php artisan migrate --force

echo Step 3: Seeding database...
php artisan db:seed --class=QuickSeeder --force

echo ========================================
echo    DATABASE FIXED!
echo ========================================
echo Your POS system is ready!
echo URL: http://localhost:8000
echo Username: admin
echo Password: password
echo ========================================

pause
