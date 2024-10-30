# Utilise l'image PHP officielle avec Apache
FROM php:7.4-apache 


# Va dans le dossier de travail
WORKDIR /var/www/html/
# Installe les dépendances nécessaires
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    git
# Copie tout composer.qqc
COPY composer.json .

# Change les permissions
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

# Copie le code source
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80

# Démarre le serveur Apache
CMD ["apache2-foreground"]