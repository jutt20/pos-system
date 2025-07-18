@echo off
echo ========================================
echo    NEXITEL POS SYSTEM SETUP
echo ========================================
echo.

echo [1/8] Installing Composer dependencies...
call composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)

echo [2/8] Copying environment file...
if not exist .env (
    copy .env.example .env
    echo Environment file created successfully!
) else (
    echo Environment file already exists, skipping...
)

echo [3/8] Generating application key...
call php artisan key:generate --force
if %errorlevel% neq 0 (
    echo ERROR: Key generation failed!
    pause
    exit /b 1
)

echo [4/8] Creating storage directories...
if not exist "storage\app\public\documents" mkdir "storage\app\public\documents"
if not exist "storage\app\public\invoices" mkdir "storage\app\public\invoices"
if not exist "storage\app\public\exports" mkdir "storage\app\public\exports"
if not exist "storage\logs" mkdir "storage\logs"
echo Storage directories created successfully!

echo [5/8] Setting up database...
call php artisan migrate:fresh --force
if %errorlevel% neq 0 (
    echo ERROR: Database migration failed!
    echo Please check your database configuration in .env file
    pause
    exit /b 1
)

echo [6/8] Seeding database with sample data...
call php artisan db:seed --force
if %errorlevel% neq 0 (
    echo WARNING: Database seeding failed, but installation can continue
)

echo [7/8] Creating storage link...
call php artisan storage:link
if %errorlevel% neq 0 (
    echo WARNING: Storage link creation failed
)

echo [8/8] Clearing caches...
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear
call php artisan route:clear

echo.
echo ========================================
echo    INSTALLATION COMPLETED SUCCESSFULLY!
echo ========================================
echo.
echo Your Nexitel POS System is ready to use!
echo.
echo DEFAULT LOGIN CREDENTIALS:
echo ----------------------------------------
echo Super Admin: superadmin / superadmin123
echo Admin:       admin / password
echo Manager:     manager / password
echo Accountant:  accountant / password
echo Sales:       sales / password
echo Support:     support / password
echo Retailer:    retailer / password
echo ----------------------------------------
echo.
echo FEATURES INCLUDED:
echo - Complete POS System with Role-Based Access
echo - Online SIM Ordering with Delivery Tracking
echo - Customer Management with Document Upload
echo - Invoice Generation with PDF Export
echo - SIM Stock Management with Import/Export
echo - Real-time Chat System
echo - Comprehensive Reporting Dashboard
echo - Multi-Portal Access (Staff/Retailer/Customer)
echo.
echo To start the development server, run:
echo php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
pause
