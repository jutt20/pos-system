@echo off
echo Creating required directories...

mkdir storage\app 2>nul
mkdir storage\app\public 2>nul
mkdir storage\framework 2>nul
mkdir storage\framework\cache 2>nul
mkdir storage\framework\cache\data 2>nul
mkdir storage\framework\sessions 2>nul
mkdir storage\framework\views 2>nul
mkdir storage\logs 2>nul
mkdir bootstrap\cache 2>nul

echo Directories created successfully!
pause
