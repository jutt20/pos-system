@echo off
echo Creating Laravel POS System...

REM Create necessary directories
mkdir storage\app\public 2>nul
mkdir storage\framework\cache\data 2>nul
mkdir storage\framework\sessions 2>nul
mkdir storage\framework\views 2>nul
mkdir storage\logs 2>nul
mkdir bootstrap\cache 2>nul

REM Set permissions (Windows)
attrib -r storage /s /d
attrib -r bootstrap\cache /s /d

REM Copy environment file
if not exist .env (
    copy .env.example .env
)

REM Clear any cached config
php artisan config:clear 2>nul
php artisan cache:clear 2>nul
php artisan view:clear 2>nul

REM Generate application key
php artisan key:generate --force

REM Run migrations
php artisan migrate:fresh --force

REM Seed database
php artisan db:seed --class=QuickSeeder --force

echo.
echo ========================================
echo   Laravel POS System Setup Complete!
echo ========================================
echo.
echo URL: http://localhost:8000
echo Username: admin
echo Password: password
echo.
echo Run: php artisan serve
echo.
pause
