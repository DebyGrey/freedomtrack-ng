#!/usr/bin/env bash
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

# echo "Publishing cloudinary provider..."
# php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"
