FROM php:7.4-fpm

# Install php extensions
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-intall -j$(nproc) gd