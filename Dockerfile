FROM php:8.0-apache

# Instala extensiones necesarias para PHP (ajusta según tus necesidades)
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copia los archivos de tu aplicación al directorio raíz de Apache
COPY . /var/www/html

# Establece permisos (ajusta según tu aplicación)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Habilita el módulo de reescritura de Apache si es necesario
RUN a2enmod rewrite

# Expone el puerto 80 para acceder al contenedor
EXPOSE 80
