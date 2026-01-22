FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
  git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo_mysql zip gd opcache \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Drush удобнее запускать из vendor/bin, но пусть будет норм PATH
ENV PATH="/var/www/html/vendor/bin:${PATH}"

WORKDIR /var/www/html
