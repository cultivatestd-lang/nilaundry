#!/bin/bash
DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$DIR"

echo "Menyiapkan database SQLite..."
touch database/database.sqlite
php artisan migrate --force 2>/dev/null

echo "Menjalankan server..."
php artisan serve --host=127.0.0.1 --port=8000 &
LARAVEL_PID=$!

npm run dev -- --host 127.0.0.1 &
VITE_PID=$!

echo ""
echo "==================================="
echo "  Ni Laundry App"
echo "==================================="
echo "  App:  http://127.0.0.1:8000"
echo "  Vite: http://127.0.0.1:5173"
echo "==================================="
echo "  Admin: /admin/login"
echo "  User:  admin / admin"
echo "==================================="
echo ""
echo "Tekan [Enter] untuk menghentikan semua server"
read -r

kill $LARAVEL_PID $VITE_PID 2>/dev/null
echo "Server dihentikan."
