# оф образ пхп и джинкс
FROM php:8.2-fpm-alpine

# устанавливаем джинкс
RUN apk add --no-cache nginx sqlite

# устанавливаем пхп для работы с sqllite
RUN docker-php-ext-install pdo_sqlite

# копируем джинкс
COPY nginx/default.conf /etc/nginx/http.d/default.conf

# копируем файлы проекта
COPY . /var/www/html

# удаляем из /var/www/html папки backend и data, чтобы не дублировать (они будут отдельно)
RUN rm -rf /var/www/html/backend /var/www/html/data

# Копируем backend и data в нужные места
COPY backend /var/www/backend
COPY data /var/www/data

# создаем папку для сессий и даём права
RUN mkdir -p /var/www/data/sessions && chown -R www-data:www-data /var/www/data

# копируем стартовый скрипт
COPY start.sh /start.sh
RUN chmod +x /start.sh

# ограничиваем память для пхп для работы с рэилвэй
RUN echo "memory_limit = 64M" >> /usr/local/etc/php/conf.d/memory-limit.ini

EXPOSE 8080
CMD ["/start.sh"]