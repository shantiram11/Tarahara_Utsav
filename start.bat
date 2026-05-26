@echo off
setlocal enabledelayedexpansion
cd /d "c:\Users\user\Downloads\Tarahara Utsav\Tarahara_Utsav"
set PHP="C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"

echo [*] Checking Laravel Installation...
%PHP% artisan --version

echo [*] Generating Application Key...
%PHP% artisan key:generate --force 2>nul

echo [*] Running migrations...
%PHP% artisan migrate --force 2>nul

echo.
echo [*] Starting Laravel development server...
echo [*] Project will be available at http://127.0.0.1:8000
echo [*] Press Ctrl+C to stop the server
echo.

%PHP% artisan serve --host=127.0.0.1 --port=8000
