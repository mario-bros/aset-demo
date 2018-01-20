FROM php:7.1-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev libpng-dev \
    zlib1g-dev \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql zip gd