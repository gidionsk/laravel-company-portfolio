FROM composer:2 AS php-deps
WORKDIR /app
COPY . .
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

FROM node:22-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi
COPY . .
RUN npm run build

FROM php:8.2-apache-bookworm AS runtime

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" \
        intl \
        mbstring \
        pdo_mysql \
        opcache \
        zip \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .
COPY --from=php-deps /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build
COPY docker/php.ini /usr/local/etc/php/conf.d/99-portfolio.ini
COPY docker/apache-portfolio.conf /etc/apache2/conf-available/portfolio.conf
COPY docker/entrypoint.sh /usr/local/bin/portfolio-entrypoint

RUN a2enconf portfolio \
    && chmod +x /usr/local/bin/portfolio-entrypoint \
    && sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=8080

EXPOSE 8080
ENTRYPOINT ["portfolio-entrypoint"]
CMD ["apache2-foreground"]
