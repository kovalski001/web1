# оф образ пхп и джинкс
FROM php:8.2-fpm-alpine

# устанавливаем джинкс
RUN apk add --no-cache nginx sqlite

# устанавливаем пхп для работы с sqllite
RUN docker-php-ext-install pdo_sqlite

# копируем джинкс
COPY nginx/default.conf /etc/nginx/http.d/default.conf

# копируем файлы проекта
COPY public /var/www/html
COPY backend /var/www/backend
COPY data /var/www/data

# создаем папку для сессий и даём права
RUN mkdir -p /var/www/data/sessions && chown -R www-data:www-data /var/www/data

# скрипт для запуска джинкса и пхп
COPY <<EOF /start.sh
#!/bin/sh
php-fpm -D
nginx -g "daemon off;"
EOF

RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]