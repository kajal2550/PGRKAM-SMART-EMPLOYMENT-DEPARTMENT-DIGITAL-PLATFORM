#!/bin/bash
set -e

echo "==> Setting up environment..."

# Create .env from example if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Force overwrite DB and session settings for Render (SQLite)
cat >> .env << 'EOF'

# Render overrides
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
EOF

# Create SQLite database file
mkdir -p /app/database
touch /app/database/database.sqlite
chmod 664 /app/database/database.sqlite

# Create storage directories
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
chmod -R 775 storage bootstrap/cache

# Clear old cache
php artisan config:clear
php artisan cache:clear

# Run migrations
echo "==> Running migrations..."
php artisan migrate --force

# Cache for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting Laravel server on port 10000..."
php artisan serve --host=0.0.0.0 --port=10000
