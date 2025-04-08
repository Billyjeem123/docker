#!/bin/sh

# Fix permissions after volume mount
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Then run php-fpm
exec php-fpm
