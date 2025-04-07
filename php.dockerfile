FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY ./src /var/www/html

# Set correct permissions for Laravel
#RUN chown -R www-data:www-data /var/www/html \
#    && chmod -R 755 /var/www/html \
#    && find /var/www/html/storage -type d -exec chmod 775 {} \; \
#    && find /var/www/html/storage -type f -exec chmod 664 {} \; \
#    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
