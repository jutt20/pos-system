@echo off
echo ========================================
echo    NEXITEL POS - FINAL SETUP
echo ========================================
echo.

echo Step 1: Creating directories...
call create-directories.bat

echo.
echo Step 2: Copying environment file...
if not exist ".env" (
    copy ".env.example" ".env"
    echo Environment file created!
) else (
    echo Environment file already exists!
)

echo.
echo Step 3: Generating application key...
php artisan key:generate --force

echo.
echo Step 4: Creating database tables...
php artisan migrate --force

echo.
echo Step 5: Seeding database with sample data...
php artisan db:seed --force

echo.
echo ========================================
echo    SETUP COMPLETE!
echo ========================================
echo.
echo Your POS system is ready!
echo.
echo To start the server:
echo   php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
echo Login credentials:
echo   Username: admin
echo   Password: password
echo.
pause
