# Utilizar la imagen de PHP
FROM php:8.1.10-cli

# Instalar dependencias necesarias
RUN apt-get update && \
    apt-get install -y git zip unzip netcat

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar el controlador MySQL para PHP
RUN docker-php-ext-install pdo_mysql

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar dependencias del proyecto con Composer
RUN composer install --no-interaction --optimize-autoloader
# RUN composer install

# Copiar el script de inicio personalizado
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exponer el puerto 1902
EXPOSE 1902

# Comando para iniciar el servidor PHP
CMD ["docker-entrypoint.sh"]
