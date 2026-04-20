# оф образ пхп и джинкс
FROM php:8.2-fpm-alpine

# устанавливаем джинкс, sqlite-dev и расширение pdo_sqlite
RUN apk add --no-cache nginx sqlite sqlite-dev \
    && docker-php-ext-install pdo_sqlite \
    && apk del sqlite-dev

# копируем конфиг nginx
COPY nginx/default.conf /etc/nginx/http.d/default.conf

# копируем файлы проекта
COPY . /var/www/html

# удаляем дублирующиеся папки
RUN rm -rf /var/www/html/backend /var/www/html/data

# копируем backend и data отдельно
COPY backend /var/www/backend
COPY data /var/www/data

# копируем кастомный конфиг PHP-FPM (чтобы слушал порт 9000)
COPY php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

# создаем папку для сессий и даём права
RUN mkdir -p /var/www/data/sessions && chown -R www-data:www-data /var/www/data

# ограничиваем память
RUN echo "memory_limit = 64M" >> /usr/local/etc/php/conf.d/memory-limit.ini

EXPOSE 8080
CMD sh -c "php-fpm -D && php /var/www/backend/init_db.php && nginx -g 'daemon off;'"