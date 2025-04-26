#!/bin/bash

# Setup Laravel storage directories
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/bootstrap/cache

# Environment setup
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Laravel initialization
php artisan key:generate --force
php artisan config:clear
php artisan config:cache
php artisan migrate --force

# Start services
php-fpm -D
exec nginx -g 'daemon off;'
