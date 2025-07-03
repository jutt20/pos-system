@echo off
echo ========================================
echo    NEXITEL POS SYSTEM - FINAL SETUP
echo ========================================
echo.

echo Step 1: Creating directories...
call create-directories.bat

echo.
echo Step 2: Setting up environment...
if not exist .env (
    copy .env.example .env
    echo Environment file created.
) else (
    echo Environment file already exists.
)

echo.
echo Step 3: Generating application key...
php artisan key:generate --force

echo.
echo Step 4: Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo Step 5: Running migrations...
php artisan migrate --force

echo.
echo Step 6: Seeding database...
php artisan db:seed --force

echo.
echo ========================================
echo    SETUP COMPLETE!
echo ========================================
echo.
echo Your POS system is ready!
echo.
echo Login Details:
echo Username: admin
echo Password: password
echo.
echo To start the server, run:
echo php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
pause
