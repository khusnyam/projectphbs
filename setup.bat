@echo off
color 0A
title PHBS Application - Fresh Setup
cls

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║         Fresh Start Setup - PHBS Application              ║
echo ╚════════════════════════════════════════════════════════════╝
echo.
echo.

echo 📌 Step 1: Reset Database (Hapus semua data lama)...
php artisan migrate:reset --force --no-interaction
echo ✅ Database reset completed
echo.

echo 📌 Step 2: Run Fresh Migrations...
php artisan migrate --force --no-interaction
echo ✅ Migrations completed
echo.

echo 📌 Step 3: Seed Database (Insert user data)...
php artisan db:seed --class=RoleSeeder --no-interaction
php artisan db:seed --class=UserSeeder --no-interaction
echo ✅ Seeding completed
echo.

echo 📌 Step 4: Clear Cache...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo ✅ Cache cleared
echo.

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║                  ✅ SETUP COMPLETED!                      ║
echo ╚════════════════════════════════════════════════════════════╝
echo.
echo.
echo 🔐 LOGIN CREDENTIALS:
echo.
echo 👤 DINKES (Admin):
echo    Email:    dkk.sleman@dinkes.com
echo    Password: dkk123
echo.
echo 🏥 PUSKESMAS:
echo    Email:    gamping1@puskesmas.go.id
echo    Password: pkm123
echo.
echo 🌐 Next Steps:
echo    1. Make sure Laravel is running (php artisan serve)
echo    2. Open http://localhost/login in browser
echo    3. Login with credentials above
echo.
pause
