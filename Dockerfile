# PHP 8.2 kullanmak için resmi PHP 8.2 imajını kullanıyoruz
FROM php:8.2-fpm

# Sistem güncellemeleri ve gerekli bağımlılıkların yüklenmesi
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    git \
    unzip \
    && docker-php-ext-install pdo_mysql zip gd exif pcntl


# Composer'ı indirip kuruyoruz
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Laravel uygulamanızı kopyalıyoruz
WORKDIR /var/www
COPY . .

# Laravel için dosya izinlerini ayarlıyoruz
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN git config --global --add safe.directory /var/www

# Bağımlılıkları kuruyoruz
RUN composer install --no-dev --optimize-autoloader

# .env dosyasını kopyalıyoruz
COPY .env.example .env

# PHP-FPM'i başlatıyoruz
CMD ["php-fpm"]

EXPOSE 9000
