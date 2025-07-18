@echo off
echo Setting up Laravel POS System...

echo Installing Composer dependencies...
composer install

echo Copying environment file...
copy .env.example .env

echo Generating application key...
php artisan key:generate

echo Running database migrations...
php artisan migrate:fresh

echo Seeding database with sample data...
php artisan db:seed

echo Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo Creating storage link...
php artisan storage:link

echo Setup complete!
echo.
echo Default login credentials:
echo Staff: admin / password
echo Retailer: retailer / password  
echo Customer: customer@example.com / password
echo.
echo You can now run: php artisan serve
pause
