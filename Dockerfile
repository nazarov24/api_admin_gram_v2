# Используем официальный образ PHP с поддержкой FPM
FROM php:8.2-fpm

# Устанавливаем системные зависимости и расширения PHP для Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libpq-dev \
    libexif-dev \  
    && docker-php-ext-install pdo pdo_pgsql exif  # Устанавливаем расширение exif

# Устанавливаем и настраиваем расширение GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Копируем файлы проекта в контейнер
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install --optimize-autoloader --no-dev

# Устанавливаем правильные права и владельцев для storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Открываем порт 9000 для PHP-FPM
EXPOSE 9000

# Запускаем PHP-FPM
CMD ["php-fpm"]
