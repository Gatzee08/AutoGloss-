@echo off
title AutoGloss Paint Hub - Laravel 11 Server
echo ================================================================
echo        AUTOGLOSS PAINT HUB - LARAVEL CRUD + ELOQUENT ORM
echo ================================================================
echo Direktori: %~dp0autogloss-laravel
echo PHP: D:\xampapp\php\php.exe
echo.
echo Menjalankan Laravel Artisan Serve...
echo Buka di browser: http://127.0.0.1:8000
echo Tekan CTRL + C untuk menghentikan server.
echo ================================================================
echo.
cd /d "%~dp0autogloss-laravel"
"D:\xampapp\php\php.exe" artisan serve --port=8000
pause

