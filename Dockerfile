FROM php:5.6-apache
RUN docker-php-ext-install mysql
COPY src/ /var/www/html/
