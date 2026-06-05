FROM php:8.2-apache

# Installer les extensions nécessaires pour MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer mod_rewrite (si vous utilisez des URLs propres)
RUN a2enmod rewrite

# Copier tout le code source dans le répertoire par défaut d’Apache
COPY . /var/www/html/

# Rendre Apache sensible au port fourni par Render ($PORT)
ENV PORT=8080
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
    && sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Exposer le port dynamique
EXPOSE ${PORT}

# Démarrer Apache au premier plan
CMD ["apache2-foreground"]