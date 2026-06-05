FROM php:8.2-apache

# Installer les extensions PostgreSQL ET MySQL (pour compatibilité)
RUN docker-php-ext-install mysqli pdo_mysql pdo_pgsql pgsql

# Activer mod_rewrite (si besoin)
RUN a2enmod rewrite

# Copier tout le code source
COPY . /var/www/html/

# Rendre Apache sensible au port fourni par Render ($PORT)
ENV PORT=8080
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
    && sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

EXPOSE ${PORT}
CMD ["apache2-foreground"]