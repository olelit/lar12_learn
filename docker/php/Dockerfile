FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY /src /var/www

RUN chown -R www-data:www-data /var/www/storage

RUN composer install --no-interaction --optimize-autoloader --no-dev

CMD ["php-fpm"]