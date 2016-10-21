FROM php:latest

WORKDIR /var/www

COPY composer.json /var/www/composer.json
COPY composer.lock /var/www/composer.lock

RUN composer install

COPY . /var/www

WORKDIR /var/www/web
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000"] 
