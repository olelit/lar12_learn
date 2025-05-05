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
    && docker-php-ext-install pdo pdo_pgsql pgsql zip exif gd soap \
    && npm install -g yarn \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www
WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG USER_ID=1000
ARG GROUP_ID=1000
RUN addgroup --gid ${GROUP_ID} hostgroup \
    && adduser --uid ${USER_ID} --gid ${GROUP_ID} --disabled-password --gecos "" hostuser

ENV COMPOSER_CACHE_DIR=/var/www/.cache/composer
RUN mkdir -p storage/logs bootstrap/cache ${COMPOSER_CACHE_DIR} && \
    chown -R hostuser:hostgroup storage bootstrap/cache ${COMPOSER_CACHE_DIR} && \
    chmod -R 775 storage bootstrap/cache ${COMPOSER_CACHE_DIR}

RUN git config --global --add safe.directory /var/www/vendor/mad-web/laravel-enum && \
    git config --global --add safe.directory /var/www/vendor/mad-web/laravel-initializer

USER hostuser

CMD ["php-fpm"]
