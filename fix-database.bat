@echo off
echo ========================================
echo    NEXITEL POS - DATABASE FIX
echo ========================================

echo Step 1: Dropping existing tables...
php artisan migrate:reset --force

echo Step 2: Running fresh migrations...
php artisan migrate --force

echo Step 3: Seeding database with Super Admin...
php artisan db:seed --class=QuickSeeder --force

echo ========================================
echo   DATABASE SETUP COMPLETE!
echo ========================================
echo.
echo Super Admin Login: superadmin / superadmin123
echo Admin Login: admin / password
echo Manager Login: manager / password
echo Sales Login: sales / password
echo Cashier Login: cashier / password
echo.
echo URL: http://localhost:8000
echo.
pause
