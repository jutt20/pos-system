@echo off
echo 🔧 Fixing Laravel Permissions and Directories...

REM Create necessary directories
if not exist "bootstrap\cache" mkdir "bootstrap\cache"
if not exist "storage\app" mkdir "storage\app"
if not exist "storage\app\public" mkdir "storage\app\public"
if not exist "storage\framework" mkdir "storage\framework"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"

echo 📁 Created all necessary directories

REM Clear any existing cache files
if exist "bootstrap\cache\*.php" del /Q "bootstrap\cache\*.php"
if exist "storage\framework\cache\data\*" del /Q /S "storage\framework\cache\data\*"

echo 🧹 Cleared cache files

REM Set permissions (Windows equivalent)
icacls "bootstrap\cache" /grant Everyone:(OI)(CI)F /T
icacls "storage" /grant Everyone:(OI)(CI)F /T

echo 🔐 Set permissions

echo ✅ Permissions fixed! Now run: composer install
pause
