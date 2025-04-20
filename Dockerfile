# Dockerfile
FROM php:8.1-fpm

# Sistem paketleri
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libmcrypt-dev \
    nano

# PHP eklentileri
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer yükle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Proje dizinine geç
WORKDIR /var/www

# Dosyaları container'a kopyala
COPY . .

# Gerekli izinler
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 9000
CMD ["php-fpm"]
