@echo off
echo 🚀 Complete Nexitel POS Setup for Windows...

REM Step 1: Fix permissions
call fix-permissions.bat

REM Step 2: Clear composer cache
echo 🧹 Clearing Composer cache...
composer clear-cache

REM Step 3: Install dependencies without scripts first
echo 📦 Installing Composer dependencies...
composer install --no-scripts --no-dev --optimize-autoloader

REM Step 4: Create .env if it doesn't exist
if not exist ".env" (
    copy ".env.example" ".env"
    echo 📝 Created .env file
)

REM Step 5: Generate application key
echo 🔑 Generating application key...
php artisan key:generate --force

REM Step 6: Run composer scripts now
echo 🔄 Running Composer scripts...
composer dump-autoload --optimize

REM Step 7: Clear and cache config
echo ⚙️ Clearing configuration...
php artisan config:clear

REM Step 8: Publish Spatie Permission
echo 📊 Publishing Spatie Permission...
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

echo.
echo 🎉 Setup complete!
echo.
echo 📋 Next steps:
echo 1. Configure your database in .env file
echo 2. Run: php artisan migrate
echo 3. Run: php artisan db:seed --class=RolePermissionSeeder
echo 4. Run: php artisan storage:link
echo 5. Run: php artisan serve
echo.
echo 🔐 Default login: admin / password
pause
