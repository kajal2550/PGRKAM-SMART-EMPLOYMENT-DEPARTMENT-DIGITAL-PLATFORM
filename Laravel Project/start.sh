#!/bin/bash
set -e

echo "==> Current directory: $(pwd)"
echo "==> PHP version: $(php -v | head -1)"

# Create .env from example if not exists
if [ ! -f .env ]; then
    echo "==> .env not found, copying from .env.example..."
    cp .env.example .env
else
    echo "==> .env already exists"
fi

# Append SQLite overrides (always force these for Render)
echo "" >> .env
echo "DB_CONNECTION=sqlite" >> .env
echo "DB_DATABASE=/app/database/database.sqlite" >> .env
echo "SESSION_DRIVER=file" >> .env
echo "CACHE_STORE=file" >> .env
echo "QUEUE_CONNECTION=sync" >> .env
echo "ASSET_URL=" >> .env

echo "==> .env contents (DB lines):"
grep -E "^DB_|^SESSION_|^CACHE_|^APP_" .env || true

# Create storage directories
echo "==> Creating storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
mkdir -p database

# Create SQLite file
echo "==> Creating SQLite database file..."
touch /app/database/database.sqlite
touch database/database.sqlite
chmod 664 /app/database/database.sqlite
chmod 664 database/database.sqlite
echo "==> SQLite file created: $(ls -la database/database.sqlite)"

# Set permissions
chmod -R 775 storage bootstrap/cache

# Clear all caches
echo "==> Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "==> Running migrations..."
php artisan migrate --force

# Cache for performance
echo "==> Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> All done! Starting Laravel server on port 10000..."
php artisan serve --host=0.0.0.0 --port=10000
