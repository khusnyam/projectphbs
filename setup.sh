#!/bin/bash
echo "=== PHBS Application Setup ==="
echo ""
echo "Step 1: Run migrations..."
php artisan migrate --force

echo ""
echo "Step 2: Seed database with users..."
php artisan db:seed --class=UserSeeder

echo ""
echo "Step 3: Clear cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear

echo ""
echo "=== Setup Complete ==="
echo ""
echo "You can now login with:"
echo "Email: dkk.sleman@dinkes.com"
echo "Password: dkk123"
echo ""
echo "Or for Puskesmas:"
echo "Email: gamping1@puskesmas.go.id"
echo "Password: pkm123"
