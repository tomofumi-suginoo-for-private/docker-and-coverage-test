FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libonig-dev git unzip zip \
  && docker-php-ext-install pdo_mysql mysqli
RUN pecl install xdebug && \
  docker-php-ext-enable xdebug

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

COPY ./config/php/php.ini /usr/local/etc/php/
WORKDIR /var/www/html
ENV XDEBUG_MODE=coverage