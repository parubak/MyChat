FROM php:8.0.10-fpm-alpine3.13

RUN docker-php-ext-install mysqli pdo pdo_mysql