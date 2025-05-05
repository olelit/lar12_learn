FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip exif gd soap

COPY /src /var/www
WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN npm install -g yarn

RUN mkdir -p storage/logs bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R root:root storage bootstrap/cache


ENV COMPOSER_CACHE_DIR=/var/www/.cache/composer
RUN mkdir -p /var/www/.cache/composer && chmod -R 775 /var/www/.cache && chown -R root:root /var/www/.cache

RUN git config --global --add safe.directory /var/www/vendor/mad-web/laravel-enum && \
    git config --global --add safe.directory /var/www/vendor/mad-web/laravel-initializer

CMD ["php-fpm"]
