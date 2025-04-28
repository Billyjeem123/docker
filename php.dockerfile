FROM php:8.2-fpm-alpine

# Install system dependencies with apk (Alpine Package Keeper)
RUN apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    oniguruma-dev \
    libpq-dev \
    shadow \
    && docker-php-ext-install pdo_mysql zip

# Change user/group ID (if needed)
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Create Laravel storage directories with proper permissions
RUN mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
    && mkdir -p /var/www/html/storage/logs \
    && chmod -R 777 /var/www/html/storage

# install and enamble redis
RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev ${PHPIZE_DEPS}

# Set the working directory
WORKDIR /var/www/html

