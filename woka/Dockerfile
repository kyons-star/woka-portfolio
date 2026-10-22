FROM php:8.4-fpm-bookworm AS php-base

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu72 libpq5 libzip4 \
        libicu-dev libpq-dev libzip-dev unzip \
    && docker-php-ext-install -j"$(nproc)" intl opcache pdo_pgsql zip \
    && apt-get purge -y --auto-remove libicu-dev libpq-dev libzip-dev unzip \
    && rm -rf /var/lib/apt/lists/*

FROM php-base AS dependencies

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --no-scripts \
        --no-autoloader \
    && composer dump-autoload \
        --no-dev \
        --classmap-authoritative \
        --no-interaction

FROM node:22-bookworm-slim AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

FROM php-base AS production

RUN apt-get update \
    && apt-get install -y --no-install-recommends nginx supervisor \
    && rm -f /etc/nginx/sites-enabled/default \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

RUN sed -i 's/^;clear_env = no/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

COPY . .
COPY --from=dependencies /var/www/html/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/php/production.ini /usr/local/etc/php/conf.d/zz-production.ini
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/woka-entrypoint

RUN chmod 0755 /usr/local/bin/woka-entrypoint \
    && mkdir -p \
        storage/app/private \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

ENV PORT=10000

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/woka-entrypoint"]
