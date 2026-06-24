FROM php:8.4-apache-bookworm AS build

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev curl libsqlite3-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install zip pdo_sqlite && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install dependencies (assets are pre-built, committed to git)
# Env vars needed for config:cache (matches render.yaml values)
ENV APP_KEY=base64:D3OUJ8QLQqtU9Wjs4/j5KXSrxnyl4JysnOVKLShsD54=
ENV APP_ENV=production APP_DEBUG=false DB_CONNECTION=sqlite
ENV SESSION_DRIVER=file CACHE_STORE=file QUEUE_CONNECTION=sync
ENV LOG_LEVEL=error
RUN composer install --no-dev --optimize-autoloader
RUN mkdir -p storage/framework/{cache/data,sessions,views} storage/logs && \
    php artisan config:cache && \
    php artisan event:cache && \
    php artisan route:cache

# --- Production image ---
FROM php:8.4-apache-bookworm

RUN apt-get update && apt-get install -y libsqlite3-dev sqlite3 \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_sqlite && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd
RUN a2enmod rewrite

# Apache doc root ke public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i 's|/var/www/html|${APACHE_DOCUMENT_ROOT}|g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf 2>/dev/null || true

WORKDIR /var/www/html
COPY --from=build /app /var/www/html

RUN mkdir -p storage/framework/{cache/data,sessions,views} storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache database

EXPOSE 80
CMD ["apache2-foreground"]
