#!/bin/sh

# ถ้าไม่มี .env ให้ copy จาก .env.example
if [ ! -f .env ]; then
    echo ".env not found. Copying from .env.example..."
    cp .env.example .env
fi

# generate key ถ้า APP_KEY ยังว่าง
if [ -z "$(grep ^APP_KEY= .env | cut -d '=' -f2)" ]; then
    echo "Generating app key..."
    php artisan key:generate
fi

# ทำ cache config
php artisan config:cache

# start nginx และ php-fpm
nginx && php-fpm
