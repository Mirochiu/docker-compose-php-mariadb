FROM php:7.4-apache

RUN apt-get update
RUN docker-php-ext-install -j$(nproc) mysqli
EXPOSE 80