FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libonig-dev libzip-dev unzip zip git \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
