#!/bin/bash
set -e

echo "==> Current directory: $(pwd)"
echo "==> PHP version: $(php -v | head -1)"

if [ ! -f .env ]; then
    echo "==> .env not found, copying from .env.example..."
    cp .env.example .env
else
    echo "==> .env already exists"
fi

echo "" >> .env
echo "DB_CONNECTION=sqlite" >> .env
echo "DB_DATABASE=/app/database/database.sqlite" >> .env
echo "SESSION_DRIVER=file" >> .env
echo "CACHE_STORE=file" >> .env
echo "QUEUE_CONNECTION=sync" >> .env

echo "==> Creating storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
mkdir -p database

echo "==> Creating SQLite database file..."
touch /app/database/database.sqlite
touch database/database.sqlite
chmod 664 /app/database/database.sqlite
chmod 664 database/database.sqlite

chmod -R 775 storage bootstrap/cache

echo "==> Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting Laravel server on port 10000..."
php artisan serve --host=0.0.0.0 --port=10000