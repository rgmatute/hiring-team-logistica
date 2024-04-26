#!/bin/bash

# Esperar hasta que MySQL esté disponible
while ! nc -z products-db 3306; do
    sleep 1
done

# Ejecutar migraciones y seeders
php artisan migrate --force
php artisan db:seed --force

# Iniciar el servidor PHP
php -S 0.0.0.0:1902 -t public
