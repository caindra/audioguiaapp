# Dockerfile para PHP
FROM php:8.1-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    openssl \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Habilitar mod_rewrite y SSL
RUN a2enmod rewrite ssl

# Copiar y ejecutar el script de generación de SSL
COPY docker/apache/generate-ssl.sh /etc/apache2/
RUN chmod +x /etc/apache2/generate-ssl.sh && /etc/apache2/generate-ssl.sh

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el código de la aplicación
COPY . /var/www/html

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Instalar dependencias de Composer
RUN composer install --no-scripts --no-autoloader
RUN composer dump-autoload --optimize

EXPOSE 80 443
CMD ["apache2-foreground"]
