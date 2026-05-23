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

RUN printf 'APP_NAME=PGRKAM\n' > .env && \
    printf 'APP_ENV=production\n' >> .env && \
    printf 'APP_KEY=base64:BAeLMPYz1p4TyNGUmyaECJ6JqDdpeq1iqX4pwA3PEww=\n' >> .env && \
    printf 'APP_DEBUG=false\n' >> .env && \
    printf 'APP_URL=https://pgrkam-portal.onrender.com\n' >> .env && \
    printf 'DB_CONNECTION=sqlite\n' >> .env && \
    printf 'DB_DATABASE=/app/database/database.sqlite\n' >> .env && \
    printf 'SESSION_DRIVER=file\n' >> .env && \
    printf 'SESSION_LIFETIME=120\n' >> .env && \
    printf 'CACHE_STORE=file\n' >> .env && \
    printf 'QUEUE_CONNECTION=sync\n' >> .env && \
    printf 'LOG_CHANNEL=stack\n' >> .env && \
    printf 'LOG_LEVEL=error\n' >> .env && \
    printf 'FILESYSTEM_DISK=local\n' >> .env && \
    printf 'MAIL_MAILER=log\n' >> .env

RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data storage/logs

RUN php artisan migrate --force --seed

RUN php artisan route:cache && \
    php artisan view:cache

EXPOSE 10000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
