FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

COPY . .
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]