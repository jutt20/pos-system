@echo off
echo ========================================
echo    NEXITEL POS - SPATIE SETUP
echo ========================================

echo Step 1: Clearing all caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo Step 2: Publishing Spatie Permission...
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

echo Step 3: Dropping existing tables...
php artisan migrate:reset --force

echo Step 4: Running fresh migrations...
php artisan migrate --force

echo Step 5: Seeding roles, permissions and sample data...
php artisan db:seed --force

echo Step 6: Clearing caches again...
php artisan config:clear
php artisan cache:clear

echo ========================================
echo   SPATIE PERMISSION SETUP COMPLETE!
echo ========================================
echo.
echo === LOGIN CREDENTIALS ===
echo Super Admin: superadmin / superadmin123 (ALL PERMISSIONS)
echo Admin: admin / password (MOST PERMISSIONS)
echo Manager: manager / password (OPERATIONAL PERMISSIONS)
echo Accountant: accountant / password (BILLING ONLY)
echo Sales: sales / password (CUSTOMER & SALES)
echo Support: support / password (CUSTOMER SUPPORT)
echo.
echo === PERMISSIONS SYSTEM ===
echo - Super Admin: Full system access + settings
echo - Admin: Employee management, all operations
echo - Manager: Operations, reports, no employee management
echo - Accountant: Billing, invoices, reports only
echo - Sales Agent: Customers, activations, invoices
echo - Technical Support: Customer support, activations
echo.
echo URL: http://localhost:8000
echo.
pause
