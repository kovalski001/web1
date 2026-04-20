FROM php:8.2-cli-alpine

RUN apk add --no-cache sqlite sqlite-dev \
    && docker-php-ext-install pdo_sqlite \
    && apk del sqlite-dev

COPY . /var/www/html
RUN rm -rf /var/www/html/backend /var/www/html/data
COPY backend /var/www/backend
COPY data /var/www/data

RUN mkdir -p /var/www/data/sessions && chown -R www-data:www-data /var/www/data

WORKDIR /var/www/html
EXPOSE 8080

# инициализация БД при старте (чтобы точно создалась)
RUN php /var/www/backend/init_db.php

CMD ["php", "-S", "0.0.0.0:8080"]
