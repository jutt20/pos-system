@echo off
echo ========================================
echo    NEXITEL POS SYSTEM - FINAL SETUP
echo ========================================
echo.

echo Step 1: Creating directories...
call create-directories.bat

echo.
echo Step 2: Copying environment file...
if not exist .env (
    copy .env.example .env
    echo Environment file created!
) else (
    echo Environment file already exists!
)

echo.
echo Step 3: Installing Composer dependencies...
if exist composer.phar (
    php composer.phar install --no-dev --optimize-autoloader
) else (
    composer install --no-dev --optimize-autoloader 2>nul || echo Composer not found - continuing without it...
)

echo.
echo Step 4: Generating application key...
php artisan key:generate --force

echo.
echo Step 5: Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo Step 6: Running migrations...
php artisan migrate --force

echo.
echo Step 7: Seeding database...
php artisan db:seed --force

echo.
echo ========================================
echo    SETUP COMPLETE!
echo ========================================
echo.
echo Your POS system is ready!
echo.
echo URL: http://localhost:8000
echo Username: admin
echo Password: password
echo.
echo To start the server, run:
echo php artisan serve
echo.
pause
