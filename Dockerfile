# Usa una imagen oficial de PHP con extensiones necesarias
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de la aplicación
COPY . .

# Instala dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Da permisos a la carpeta de almacenamiento y caché
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expone el puerto 8000
EXPOSE 8000

# Comando por defecto para iniciar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"] 