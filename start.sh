#!/usr/bin/env bash
set -e

cd /var/www/html

echo "Starting container setup..."

echo "Clearing composer cache..."
composer clear-cache

echo "Installing dependencies..."
composer install --no-dev

echo "Generating application key..."
php artisan key:generate

echo "Running database migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo "Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Starting php-fpm..."
php-fpm
