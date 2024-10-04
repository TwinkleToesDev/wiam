# Используем официальный образ PHP с FPM
FROM php:8.3-fpm

# Устанавливаем необходимые системные пакеты и расширения PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем файлы приложения в контейнер
COPY . /var/www/html

# Устанавливаем зависимости приложения
RUN composer install

# Устанавливаем права доступа (опционально)
RUN chown -R www-data:www-data /var/www/html

#  Запускам миграции
RUN chown php yii migrate

# Открываем порт 9000 для PHP-FPM
EXPOSE 9000

# Запускаем PHP-FPM
CMD ["php-fpm"]
