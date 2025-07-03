@echo off
echo Creating Laravel directories...

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
echo.
echo Creating .gitignore files...

echo * > storage\app\.gitignore
echo !public/ >> storage\app\.gitignore
echo !.gitignore >> storage\app\.gitignore

echo * > storage\app\public\.gitignore
echo !.gitignore >> storage\app\public\.gitignore

echo * > storage\framework\.gitignore
echo !cache/ >> storage\framework\.gitignore
echo !sessions/ >> storage\framework\.gitignore
echo !views/ >> storage\framework\.gitignore
echo !.gitignore >> storage\framework\.gitignore

echo * > storage\framework\cache\.gitignore
echo !data/ >> storage\framework\cache\.gitignore
echo !.gitignore >> storage\framework\cache\.gitignore

echo * > storage\framework\cache\data\.gitignore
echo !.gitignore >> storage\framework\cache\data\.gitignore

echo * > storage\framework\sessions\.gitignore
echo !.gitignore >> storage\framework\sessions\.gitignore

echo * > storage\framework\views\.gitignore
echo !.gitignore >> storage\framework\views\.gitignore

echo * > storage\logs\.gitignore
echo !.gitignore >> storage\logs\.gitignore

echo * > bootstrap\cache\.gitignore
echo !.gitignore >> bootstrap\cache\.gitignore

echo .gitignore files created successfully!
echo.
echo Setting permissions...

attrib -r storage /s /d 2>nul
attrib -r bootstrap\cache /s /d 2>nul

echo Setup complete!
pause
