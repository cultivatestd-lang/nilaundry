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
RUN composer install --no-dev --optimize-autoloader
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs

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

RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache database

EXPOSE 80
CMD ["apache2-foreground"]
