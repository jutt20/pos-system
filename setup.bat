@echo off
echo ========================================
echo    NEXITEL POS SYSTEM - COMPLETE SETUP
echo ========================================
echo.

echo [1/12] Creating required directories...
if not exist "storage\app\public" mkdir "storage\app\public"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"
if not exist "bootstrap\cache" mkdir "bootstrap\cache"
echo ✓ Directories created successfully

echo.
echo [2/12] Installing Composer dependencies...
composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ❌ Composer install failed
    pause
    exit /b 1
)
echo ✓ Composer dependencies installed

echo.
echo [3/12] Installing Laravel Reverb for real-time chat...
composer require laravel/reverb
if %errorlevel% neq 0 (
    echo ❌ Laravel Reverb installation failed
    pause
    exit /b 1
)
echo ✓ Laravel Reverb installed

echo.
echo [4/12] Setting up environment file...
if not exist ".env" (
    copy ".env.example" ".env"
    echo ✓ Environment file created
) else (
    echo ✓ Environment file already exists
)

echo.
echo [5/12] Generating application key...
php artisan key:generate --force
echo ✓ Application key generated

echo.
echo [6/12] Clearing all caches and configurations...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan event:clear
echo ✓ All caches cleared

echo.
echo [7/12] Publishing vendor assets and configurations...
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force
php artisan reverb:install
echo ✓ Vendor assets published

echo.
echo [8/12] Setting up database (fresh migration with fixed foreign keys)...
php artisan migrate:fresh --force
if %errorlevel% neq 0 (
    echo ❌ Migration failed - Database connection issue
    echo Please check your database configuration in .env file
    pause
    exit /b 1
)
echo ✓ Database migrations completed successfully

echo.
echo [9/12] Seeding database with comprehensive sample data...
php artisan db:seed --class=DatabaseSeeder --force
if %errorlevel% neq 0 (
    echo ❌ Database seeding failed
    pause
    exit /b 1
)
echo ✓ Database seeded with sample data

echo.
echo [10/12] Setting up storage links and optimizations...
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
echo ✓ Storage and optimizations completed

echo.
echo [11/12] Setting file permissions...
icacls "storage" /grant Everyone:(OI)(CI)F /T >nul 2>&1
icacls "bootstrap\cache" /grant Everyone:(OI)(CI)F /T >nul 2>&1
echo ✓ File permissions configured

echo.
echo [12/12] Final system verification...
php artisan about --only=environment
echo ✓ System verification completed

echo.
echo ========================================
echo    SETUP COMPLETED SUCCESSFULLY! 🎉
echo ========================================
echo.
echo 🔐 Default Login Credentials:
echo ┌─────────────────────────────────────────────────────┐
echo │ ADMIN PORTAL                                        │
echo │ Username: admin@nexitel.com                        │
echo │ Password: password                                  │
echo │ URL: http://localhost:8000/login                    │
echo ├─────────────────────────────────────────────────────┤
echo │ RETAILER PORTAL                                     │
echo │ Username: retailer@nexitel.com                     │
echo │ Password: password                                  │
echo │ URL: http://localhost:8000/retailer/login           │
echo ├─────────────────────────────────────────────────────┤
echo │ CUSTOMER PORTAL                                     │
echo │ Username: customer@nexitel.com                     │
echo │ Password: password                                  │
echo │ URL: http://localhost:8000/customer/login           │
echo └─────────────────────────────────────────────────────┘
echo.
echo 🚀 NEW FEATURES AVAILABLE:
echo • Online SIM Ordering System with Admin Approval
echo • Real-time Order Tracking (Public: /track/ORDER_NUMBER)
echo • Delivery Service Management with Multiple Carriers
echo • Customer Self-Service Portal with Order History
echo • Real-time Chat System with Laravel Reverb
echo • Advanced Role-Based Access Control
echo • Comprehensive Reporting and Analytics
echo • Mobile-Responsive Design with Animations
echo.
echo 📦 SAMPLE DATA INCLUDED:
echo • 50+ Online SIM Orders with Various Statuses
echo • 5 Delivery Services (UPS, FedEx, USPS, DHL, Local)
echo • Multiple Chat Rooms for Team Communication
echo • Complete SIM Stock with Movement Tracking
echo • Sample Customers, Employees, and Invoices
echo.
echo 🌐 DELIVERY TRACKING:
echo • UPS Ground - 3 days - $8.99 base + $1.50/item
echo • FedEx Express - 2 days - $12.99 base + $2.00/item
echo • USPS Priority - 3 days - $6.99 base + $1.00/item
echo • DHL Express - 1 day - $15.99 base + $2.50/item
echo • Local Courier - Same day - $5.99 base + $0.75/item
echo.
echo Starting development server...
echo Press Ctrl+C to stop the server
echo.
php artisan serve
