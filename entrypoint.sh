#!/bin/bash

# Setup Laravel storage directories
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Environment setup
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Laravel initialization
php artisan key:generate --force
php artisan config:clear
php artisan config:cache
php artisan migrate --force

# Ensure correct permissions for PHP-FPM socket
touch /var/run/php-fpm.sock
chown www-data:www-data /var/run/php-fpm.sock
chmod 0660 /var/run/php-fpm.sock

# Start PHP-FPM
php-fpm -D

# Start Nginx
exec nginx -g 'daemon off;'
