@echo off
echo ========================================
echo    NEXITEL POS - COMPLETE SETUP
echo ========================================

echo Step 1: Creating necessary directories...
if not exist "bootstrap\cache" mkdir "bootstrap\cache"
if not exist "storage\app" mkdir "storage\app"
if not exist "storage\app\public" mkdir "storage\app\public"
if not exist "storage\framework" mkdir "storage\framework"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"

echo Step 2: Setting permissions...
icacls "bootstrap\cache" /grant Everyone:(OI)(CI)F /T >nul 2>&1
icacls "storage" /grant Everyone:(OI)(CI)F /T >nul 2>&1

echo Step 3: Creating .env file...
if not exist ".env" (
    copy ".env.example" ".env"
    echo Created .env file from example
)

echo Step 4: Installing Composer dependencies...
composer install --no-scripts --optimize-autoloader

echo Step 5: Generating application key...
php artisan key:generate --force

echo Step 6: Running Composer scripts...
composer dump-autoload --optimize

echo Step 7: Clearing configuration...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo Step 8: Publishing Spatie Permission...
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

echo Step 9: Running fresh migrations...
php artisan migrate:fresh --force

echo Step 10: Seeding database...
php artisan db:seed --force

echo Step 11: Creating storage link...
php artisan storage:link

echo Step 12: Final cache clear...
php artisan config:clear
php artisan cache:clear

echo ========================================
echo   NEXITEL POS SETUP COMPLETE!
echo ========================================
echo.
echo === LOGIN CREDENTIALS ===
echo Super Admin: superadmin / superadmin123
echo Admin: admin / password
echo Manager: manager / password
echo Sales: sales / password
echo Cashier: cashier / password
echo Customer: customer@example.com / password
echo Retailer: retailer@example.com / password
echo.
echo === PORTALS ===
echo Admin Portal: http://localhost:8000/dashboard
echo Customer Portal: http://localhost:8000/customer-portal
echo Retailer Portal: http://localhost:8000/retailer
echo.
echo Starting server...
php artisan serve
pause
