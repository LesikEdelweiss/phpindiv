FROM php:8.2-apache

# Устанавливаем расширения для MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Включаем rewrite (на будущее, если захочешь ЧПУ)
RUN a2enmod rewrite

# Указываем рабочую директорию
WORKDIR /var/www/html