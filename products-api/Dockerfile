# Utilizar la imagen de PHP
FROM php:7.4-cli

# Instalar dependencias necesarias
RUN apt-get update && \
    apt-get install -y git zip unzip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar dependencias del proyecto con Composer
RUN composer install --no-interaction --optimize-autoloader

# Ejecutar migraciones y seeders
RUN php artisan migrate --force && \
    php artisan db:seed --force

# Exponer el puerto 1902
EXPOSE 1902

# Comando para iniciar el servidor PHP
CMD ["php", "-S", "0.0.0.0:1902", "-t", "public"]
