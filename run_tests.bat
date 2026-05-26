@echo off
cd /d "c:\laragon\www\Tarahara Utsav\Tarahara_Utsav"
set PHP=C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe
echo Running Unit Tests...
echo.
%PHP% vendor/bin/phpunit --testdox
pause
