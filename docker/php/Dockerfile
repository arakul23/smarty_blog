FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json ./
RUN npm install --no-audit --no-fund

COPY src/frontend/css ./src/frontend/css
RUN npm run build:css

FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY --from=assets /app/src/frontend/css/app.css /var/www/html/src/frontend/css/app.css

COPY ./docker/php/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["php-fpm"]
