FROM php:7.4-apache

RUN docker-php-ext-install mysqli

COPY ./php_application /var/www/html/

EXPOSE 80