#!/bin/bash

# Pastikan permission folder storage aman
chmod -R 775 /var/www/storage /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Menjalankan optimasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Menjalankan migrasi database otomatis saat deploy
php artisan migrate --force

# Mulai PHP-FPM di background
php-fpm -D

# Mulai Nginx di foreground
nginx -g "daemon off;"
