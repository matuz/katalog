FROM php:latest

WORKDIR /var/www

RUN apt-get update && apt-get -y --force-yes install git unzip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

COPY composer.json /var/www/composer.json
COPY composer.lock /var/www/composer.lock

RUN php composer.phar install

COPY . /var/www

WORKDIR /var/www/web
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000"] 
