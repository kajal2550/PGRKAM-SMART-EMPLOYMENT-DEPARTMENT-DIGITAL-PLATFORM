FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libpng-dev libonig-dev libxml2-dev libsqlite3-dev curl \
    && docker-php-ext-install zip pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chmod -R 775 storage bootstrap/cache \
    && mkdir -p database \
    && touch database/database.sqlite \
    && chmod 664 database/database.sqlite

EXPOSE 10000

CMD ["sh", "-c", "cp .env.example .env && printf '\\nDB_CONNECTION=sqlite\\nDB_DATABASE=/app/database/database.sqlite\\nSESSION_DRIVER=file\\nCACHE_STORE=file\\nQUEUE_CONNECTION=sync\\n' >> .env && mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data storage/logs && touch /app/database/database.sqlite && chmod -R 775 storage bootstrap/cache && php artisan config:clear && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=10000"]
