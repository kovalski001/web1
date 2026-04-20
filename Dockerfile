FROM php:8.2-cli-alpine

# Устанавливаем SQLite и расширение PDO
RUN apk add --no-cache sqlite sqlite-dev \
    && docker-php-ext-install pdo_sqlite \
    && apk del sqlite-dev

# Копируем все файлы проекта в рабочую папку
COPY . /var/www/html

# Удаляем дублирующиеся папки (если есть)
RUN rm -rf /var/www/html/backend /var/www/html/data

# Копируем backend и data отдельно
COPY backend /var/www/backend
COPY data /var/www/data

# Создаём папку для сессий и даём права
RUN mkdir -p /var/www/data/sessions && chown -R www-data:www-data /var/www/data

WORKDIR /var/www/html
EXPOSE 8080

# Запускаем встроенный сервер PHP на порту 8080
CMD ["php", "-S", "0.0.0.0:8080"]