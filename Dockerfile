FROM php:8.2-apache
COPY . /var/www/html
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
WORKDIR /var/www/html
# CMD [ "php", "./public/logIn.php" ]
