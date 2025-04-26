FROM php:8.1-fpm

# ติดตั้ง dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# สร้างและกำหนดสิทธิ์ directories ที่จำเป็น
RUN mkdir -p /run/nginx \
    && mkdir -p /var/log/nginx /var/cache/nginx \
    && chown -R www-data:www-data /var/log/nginx /var/cache/nginx /run/nginx

# ตั้งค่า PHP และ environment variables
ENV PHP_OPCACHE_ENABLE=1 \
    PHP_OPCACHE_ENABLE_CLI=1 \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=1 \
    PHP_OPCACHE_REVALIDATE_FREQ=0

# ติดตั้ง Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# ตั้งค่า working directory
WORKDIR /var/www/html

# คัดลอกไฟล์ทั้งหมดไปยัง container
COPY . .

# ติดตั้ง dependencies ของ Laravel และ optimize
RUN composer install --no-dev --optimize-autoloader --no-scripts \
    && mkdir -p storage/framework/{sessions,views,cache} \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# คัดลอก nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

# คัดลอก entrypoint และให้สิทธิ์
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# เปลี่ยน user เป็น www-data
USER www-data

EXPOSE 80

# ตั้งค่า entrypoint
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]