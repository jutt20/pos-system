@echo off
echo ========================================
echo    NEXITEL POS - COMPLETE DATABASE SETUP
echo ========================================

echo Step 1: Dropping existing tables...
php artisan migrate:reset --force

echo Step 2: Running fresh migrations...
php artisan migrate --force

echo Step 3: Seeding database with complete sample data...
php artisan db:seed --class=QuickSeeder --force

echo Step 4: Clearing all caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo ========================================
echo   COMPLETE DATABASE SETUP FINISHED!
echo ========================================
echo.
echo === LOGIN CREDENTIALS ===
echo Super Admin: superadmin / superadmin123
echo Admin: admin / password
echo Manager: manager / password
echo Sales: sales / password
echo Cashier: cashier / password
echo.
echo === SAMPLE DATA CREATED ===
echo - 5 Employees with different roles
echo - 3 Customers with assignments
echo - 3 Invoices with items
echo - 3 Activations with different statuses
echo - 3 SIM Orders with different statuses
echo.
echo URL: http://localhost:8000
echo.
echo Starting server...
php artisan serve

pause
