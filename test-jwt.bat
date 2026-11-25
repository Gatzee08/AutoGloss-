@echo off
title AutoGloss - Test JWT Authentication (Week 11)
echo ================================================================
echo    AUTOGLOSS PAINT HUB - TEST JWT AUTHENTICATION (WEEK 11)
echo ================================================================
echo.
cd /d "%~dp0autogloss-laravel"
"D:\xampapp\php\php.exe" test-jwt.php
pause
