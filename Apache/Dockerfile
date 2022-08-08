FROM php:8.0-apache
RUN a2enmod rewrite
RUN apt-get update && apt-get install iputils-ping -y
RUN apt install unzip
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli 
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql 

RUN apachectl restart
WORKDIR /var/www/html
# RUN composer install