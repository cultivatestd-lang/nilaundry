FROM php:8.4-apache-bookworm AS build

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev curl libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install zip pdo_sqlite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install dependencies (assets are pre-built, committed to git)
ENV APP_DEBUG=true
RUN composer install --no-dev --optimize-autoloader
RUN php artisan optimize

# --- Production image ---
FROM php:8.4-apache-bookworm

RUN apt-get update && apt-get install -y libsqlite3-dev sqlite3 \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_sqlite
RUN a2enmod rewrite

# Apache doc root ke public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i 's|/var/www/html|${APACHE_DOCUMENT_ROOT}|g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf 2>/dev/null || true

WORKDIR /var/www/html
COPY --from=build /app /var/www/html

RUN chown -R www-data:www-data storage bootstrap/cache database

EXPOSE 80
CMD ["apache2-foreground"]
