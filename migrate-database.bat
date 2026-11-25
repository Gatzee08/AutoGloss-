@echo off
title AutoGloss - Database Migration & Seeding
echo ================================================================
echo        MIGRASI & SEEDING DATABASE AUTOGLOSS PAINT HUB
echo ================================================================
echo Catatan: Pastikan modul MySQL pada XAMPP Control Panel sudah aktif (Running)
echo jika menggunakan koneksi MySQL.
echo.
cd /d "%~dp0autogloss-laravel"
"D:\xampapp\php\php.exe" artisan migrate:fresh --seed
echo.
echo Selesai!
pause

