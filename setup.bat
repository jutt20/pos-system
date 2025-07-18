@echo off
echo ========================================
echo    NEXITEL POS SYSTEM - COMPLETE SETUP
echo ========================================
echo.

echo [1/8] Creating required directories...
if not exist "storage\app\public" mkdir "storage\app\public"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"
if not exist "bootstrap\cache" mkdir "bootstrap\cache"
echo ✓ Directories created successfully

echo.
echo [2/8] Installing Composer dependencies...
composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ❌ Composer install failed
    pause
    exit /b 1
)
echo ✓ Composer dependencies installed

echo.
echo [3/8] Setting up environment file...
if not exist ".env" (
    copy ".env.example" ".env"
    echo ✓ Environment file created
) else (
    echo ✓ Environment file already exists
)

echo.
echo [4/8] Generating application key...
php artisan key:generate --force
echo ✓ Application key generated

echo.
echo [5/8] Setting up database and running migrations...
php artisan migrate:fresh --force
if %errorlevel% neq 0 (
    echo ❌ Migration failed
    pause
    exit /b 1
)
echo ✓ Database migrations completed

echo.
echo [6/8] Seeding database with sample data...
php artisan db:seed --class=DatabaseSeeder --force
if %errorlevel% neq 0 (
    echo ❌ Database seeding failed
    pause
    exit /b 1
)
echo ✓ Database seeded successfully

echo.
echo [7/8] Setting up storage and cache...
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ✓ Storage and cache configured

echo.
echo [8/8] Setting file permissions...
icacls "storage" /grant Everyone:(OI)(CI)F /T >nul 2>&1
icacls "bootstrap\cache" /grant Everyone:(OI)(CI)F /T >nul 2>&1
echo ✓ File permissions set

echo.
echo ========================================
echo    SETUP COMPLETED SUCCESSFULLY! 🎉
echo ========================================
echo.
echo Default Login Credentials:
echo ┌─────────────────────────────────────┐
echo │ ADMIN PORTAL                        │
echo │ Username: admin                     │
echo │ Password: password                  │
echo │ URL: http://localhost:8000/login    │
echo ├─────────────────────────────────────┤
echo │ RETAILER PORTAL                     │
echo │ Username: retailer                  │
echo │ Password: password                  │
echo │ URL: http://localhost:8000/retailer/login │
echo ├─────────────────────────────────────┤
echo │ CUSTOMER PORTAL                     │
echo │ Username: customer                  │
echo │ Password: password                  │
echo │ URL: http://localhost:8000/customer/login │
echo └─────────────────────────────────────┘
echo.
echo Starting development server...
echo Press Ctrl+C to stop the server
echo.
php artisan serve
