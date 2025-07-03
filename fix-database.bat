@echo off
echo ========================================
echo   FIXING DATABASE ISSUES
echo ========================================

echo Step 1: Dropping existing tables...
php artisan migrate:reset --force

echo Step 2: Running fresh migrations...
php artisan migrate --force

echo Step 3: Seeding database with sample data...
php artisan db:seed --class=QuickSeeder --force

echo Step 4: Clearing all caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo ========================================
echo   DATABASE FIXED SUCCESSFULLY!
echo ========================================
echo.
echo Your POS system is ready!
echo URL: http://localhost:8000
echo Username: admin
echo Password: password
echo.
echo Starting server...
php artisan serve

pause
