#!/usr/bin/env bash
echo "can you see me..."

php artisan migrate --force
php-fpm

set -e  # stop script if any command fails

echo "Clearing composer cache..."
composer clear-cache

echo "Running composer"

composer install --no-dev --working-dir=/var/www/html

php artisan key:generate

echo "Running migrations..."
php artisan migrate --force
php artisan db:seed --force

echo "Clearing config cache..."
php artisan config:clear

echo "Clearing routes cache..."
php artisan route:clear

echo "Clearing view cache..."
php artisan view:clear
