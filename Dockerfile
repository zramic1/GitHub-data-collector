FROM php:8.0.5-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install exif
RUN apk update && apk add \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd