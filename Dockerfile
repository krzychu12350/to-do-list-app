FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    vim \
    libzip-dev \
    libssl-dev \
    default-mysql-client \
    supervisor \
    cron \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl opcache gd

# Removed Redis extension installation
# RUN pecl install redis && docker-php-ext-enable redis

# Copy custom PHP config
COPY ./docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Set working directory
WORKDIR /var/www/html

# Copy composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy app code (except ignored files)
COPY . .

# Prevent symlink issue on Windows
RUN rm -rf public/storage || true

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Create Laravel required directories
RUN mkdir -p storage/framework/{views,sessions,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Set permissions for Laravel
RUN chown -R www-data:www-data . \
    && chmod -R 755 .

# Recreate symlink for public storage
RUN php artisan storage:link || true

# Laravel setup (migrate, cache, optimize)
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan view:clear \
    && php artisan route:clear \
    && php artisan optimize \
    && php artisan migrate --force || true

EXPOSE 9000
CMD ["php-fpm"]
