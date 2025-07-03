@echo off
echo 🚀 Nexitel POS - Quick Setup (No Installation Required)

REM Create all necessary directories
echo 📁 Creating directories...
if not exist "bootstrap\cache" mkdir "bootstrap\cache"
if not exist "storage\app\public" mkdir "storage\app\public"
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"

REM Set basic permissions
echo 🔐 Setting permissions...
attrib -r bootstrap\cache /s /d
attrib -r storage /s /d

REM Create .env file
if not exist ".env" (
    echo 📝 Creating .env file...
    copy ".env.example" ".env"
)

REM Generate a simple app key manually
echo 🔑 Setting application key...
powershell -Command "(Get-Content .env) -replace 'APP_KEY=', 'APP_KEY=base64:' + [Convert]::ToBase64String([System.Text.Encoding]::UTF8.GetBytes([System.Guid]::NewGuid().ToString().Replace('-', '').Substring(0, 32))) | Set-Content .env"

echo ✅ Basic setup complete!
echo.
echo 📋 Next steps:
echo 1. Edit .env file and set your database credentials
echo 2. Run: php -S localhost:8000 -t public
echo 3. Visit: http://localhost:8000
echo.
echo 🔐 Default login: admin / password
echo.
echo 💡 If you get database errors, create a database and run:
echo    php artisan migrate --force
echo    php artisan db:seed --class=RolePermissionSeeder --force
pause
