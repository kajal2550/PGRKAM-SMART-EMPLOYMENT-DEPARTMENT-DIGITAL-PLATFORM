#!/bin/bash
set -e

echo "==> Setting up environment..."

# Create .env from example if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Force SQLite settings in .env
grep -q "^DB_CONNECTION=" .env && sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env || echo "DB_CONNECTION=sqlite" >> .env
grep -q "^DB_DATABASE=" .env && sed -i 's|^DB_DATABASE=.*|DB_DATABASE=/app/database/database.sqlite|' .env || echo "DB_DATABASE=/app/database/database.sqlite" >> .env
grep -q "^SESSION_DRIVER=" .env && sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=cookie/' .env || echo "SESSION_DRIVER=cookie" >> .env
grep -q "^CACHE_STORE=" .env && sed -i 's/^CACHE_STORE=.*/CACHE_STORE=array/' .env || echo "CACHE_STORE=array" >> .env
grep -q "^QUEUE_CONNECTION=" .env && sed -i 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' .env || echo "QUEUE_CONNECTION=sync" >> .env

# Create SQLite database file
mkdir -p /app/database
touch /app/database/database.sqlite
chmod 664 /app/database/database.sqlite

# Generate app key if not set
php artisan key:generate --force

# Run migrations
echo "==> Running migrations..."
php artisan migrate --force

# Clear and cache config
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting Laravel server on port 10000..."
php artisan serve --host=0.0.0.0 --port=10000
