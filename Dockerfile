FROM php:8.1-fpm

# ติดตั้ง dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# ติดตั้ง Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# ตั้งค่า working directory
WORKDIR /var/www/html

# คัดลอกไฟล์ทั้งหมดไปยัง container
COPY . .

# คัดลอกไฟล์ nginx.conf
COPY nginx.conf /etc/nginx/conf.d/default.conf

# ติดตั้ง dependencies ของ Laravel
RUN composer install --no-dev --optimize-autoloader

# ให้สิทธิ์กับ storage และ bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# คัดลอก entrypoint.sh
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# ตั้งค่า entrypoint
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]