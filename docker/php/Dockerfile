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
RUN chown -R www-data:www-data /var/www && chmod -R ug+rw /var/www
RUN npm install -g yarn

ENV COMPOSER_CACHE_DIR=/var/www/.cache/composer
RUN mkdir -p /var/www/.cache/composer && chown -R www-data:www-data /var/www/.cache

RUN git config --global --add safe.directory /var/www/vendor/mad-web/laravel-enum
RUN git config --global --add safe.directory /var/www/vendor/mad-web/laravel-initializer

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN addgroup --gid $GROUP_ID wwwuser && \
    adduser --uid $USER_ID --gid $GROUP_ID --disabled-password wwwuser

USER wwwuser

CMD ["php-fpm"]