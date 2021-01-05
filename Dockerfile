#FROM newdeveloper/apache-php
FROM php:7.3-apache-stretch
RUN apt-get update && apt-get install -y libpng-dev zip unzip wget zlib1g-dev libicu-dev libzip-dev
RUN docker-php-ext-install mysqli pdo_mysql zip exif
RUN apt-get install -y \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev
RUN docker-php-ext-install gd
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-install bcmath

COPY --from=composer:1.9 /usr/bin/composer /usr/bin/composer

# copy app in full
WORKDIR /var/www/html/
COPY . /var/www/html/
COPY default.conf /etc/apache2/sites-available/000-default.conf
COPY default.conf /etc/apache2/sites-enabled/000-default.conf
# install dependencies
RUN composer install
EXPOSE 80


RUN chmod 777 -R /var/www/html/storage/ && \
  #  echo "Listen 8080" >> /etc/apache2/ports.conf && \
    echo CustomLog "/dev/stdout" access_log && \
    chown -R www-data:www-data /var/www/html/ && \
    a2enmod rewrite
#COPY .env /var/www/html/.env.