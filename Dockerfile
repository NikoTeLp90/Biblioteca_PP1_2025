# Imagen base PHP 8.2 con Apache
FROM php:8.2-apache

# Habilitar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite (si lo necesitas)
RUN a2enmod rewrite

# Copiar código al DocumentRoot
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# Copiar el entrypoint desde la raíz (antes intentaba desde docker/entrypoint.sh)
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 10000

CMD ["/entrypoint.sh"]