FROM php:7.4-cli

ENV DIRPATH /var/www/html

COPY src ${DIRPATH}
COPY --from=composer:1.10 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
        libicu-dev \
    && docker-php-ext-install intl \
    && composer install -d ${DIRPATH}

EXPOSE 80

WORKDIR ${DIRPATH}

CMD php -S 0.0.0.0:80 index.php
