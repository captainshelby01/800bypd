FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_sqlite \
        bcmath \
        zip \
        intl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/views storage/framework/sessions storage/framework/cache storage/app/public/products storage/app/public/bundles storage/app/public/receipts
RUN cp -r public/images/products/* storage/app/public/products/ 2>/dev/null || true
RUN php artisan storage:link || true
RUN chmod -R 777 storage bootstrap/cache

CMD php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan storage:link || true && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}