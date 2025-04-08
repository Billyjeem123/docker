FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql zip

# solution to permssion isssue it appears that
# Create a user with the same UID as your host user (replace 1000 with your host UID)
ARG USER_ID=1000
ARG GROUP_ID=1000
RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data &&\
    chown -R www-data:www-data /var/www

# Set working directory
WORKDIR /var/www/html

USER www-data