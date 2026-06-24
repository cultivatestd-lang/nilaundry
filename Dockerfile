FROM php:8.4-apache-bookworm AS build

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev curl \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install zip pdo_sqlite

# Node.js for asset building
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Build assets
RUN composer install --no-dev --optimize-autoloader && \
    npm ci && npm run build && \
    php artisan optimize

# --- Production image ---
FROM php:8.4-apache-bookworm

RUN apt-get update && apt-get install -y \
    libsqlite3-0 \
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
