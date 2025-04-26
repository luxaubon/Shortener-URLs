#!/bin/bash

# ตรวจสอบและสร้าง directories ที่จำเป็น
mkdir -p storage/framework/{sessions,views,cache}

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

# ทำ cache config และ migration
php artisan config:clear
php artisan config:cache
php artisan migrate --force

# ตรวจสอบว่า nginx พร้อมทำงาน
if [ ! -d "/run/nginx" ]; then
    mkdir -p /run/nginx
fi

# start nginx และ php-fpm
php-fpm -D && nginx -g 'daemon off;'
