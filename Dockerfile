# Imagen base de PHP 8.1 y Apache
FROM php:8.1-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto
COPY . /var/www/html/

# Configura Apache
RUN a2enmod rewrite
RUN service apache2 restart

# Ejecuta el comando para iniciar Apache
CMD ["apachectl", "-D", "FOREGROUND"]
