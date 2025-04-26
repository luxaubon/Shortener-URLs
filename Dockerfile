# Use PHP 8.2 FPM Alpine as base image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    git

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip bcmath

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Configure nginx
COPY nginx.conf /etc/nginx/http.d/default.conf

# Expose port 80
EXPOSE 80

# Start script
CMD ["sh", "-c", "\
    cp .env.example .env && \
    php artisan key:generate && \
    php artisan config:cache && \
    nginx && \
    php-fpm \
"]
