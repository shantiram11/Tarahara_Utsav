#!/usr/bin/env pwsh
$phpPath = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$projectPath = "C:\laragon\www\Tarahara Utsav\Tarahara_Utsav"

Set-Location $projectPath

Write-Host "Running Laravel Unit Tests..." -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

& $phpPath artisan test --testdox

Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "Tests Complete!" -ForegroundColor Green
