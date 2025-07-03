@echo off
echo Creating Laravel storage directories...

REM Create storage directories
if not exist "storage" mkdir storage
if not exist "storage\app" mkdir storage\app
if not exist "storage\app\public" mkdir storage\app\public
if not exist "storage\framework" mkdir storage\framework
if not exist "storage\framework\cache" mkdir storage\framework\cache
if not exist "storage\framework\cache\data" mkdir storage\framework\cache\data
if not exist "storage\framework\sessions" mkdir storage\framework\sessions
if not exist "storage\framework\views" mkdir storage\framework\views
if not exist "storage\logs" mkdir storage\logs

REM Create bootstrap cache directory
if not exist "bootstrap\cache" mkdir bootstrap\cache

REM Create public storage link directory
if not exist "public\storage" mkdir public\storage

echo Directories created successfully!
echo.
echo Setting permissions...

REM Set permissions (Windows equivalent)
attrib -r storage /s /d
attrib -r bootstrap\cache /s /d

echo Permissions set successfully!
echo.
echo You can now run: php artisan serve
pause
