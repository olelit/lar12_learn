FROM php:8.1-fpm

COPY /src /var/www
WORKDIR /var/www

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 755 /var/www/storage
RUN npm install -g yarn

ENV COMPOSER_CACHE_DIR=/var/www/.cache/composer
RUN mkdir -p /var/www/.cache/composer && chown -R www-data:www-data /var/www/.cache

RUN git config --global --add safe.directory /var/www/vendor/mad-web/laravel-enum
RUN git config --global --add safe.directory /var/www/vendor/mad-web/laravel-initializer

RUN composer install
#RUN yarn install
#RUN yarn production

CMD ["php-fpm"]