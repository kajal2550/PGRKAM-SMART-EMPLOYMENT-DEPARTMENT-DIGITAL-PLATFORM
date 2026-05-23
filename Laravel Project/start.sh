#!/bin/bash
set -e

echo "==> Setting up environment..."

# Create .env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not set
php artisan key:generate --force

# Create SQLite database if not exists
touch database/database.sqlite

# Run migrations
echo "==> Running migrations..."
php artisan migrate --force

# Cache config for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=10000
