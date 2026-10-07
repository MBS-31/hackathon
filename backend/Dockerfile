# =============================================================================
# CRM Backend — Dockerfile
# PHP 8.3 + Laravel — Production-ready multi-stage build
# =============================================================================

# ---------------------------------------------------------------------------
# Stage 1: Composer dependency installer
# ---------------------------------------------------------------------------
FROM composer:2.7 AS composer-stage

WORKDIR /app

COPY composer.json composer.loc[k] ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --no-interaction \
    --ignore-platform-reqs \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize --no-dev

# ---------------------------------------------------------------------------
# Stage 2: Final runtime image
# ---------------------------------------------------------------------------
FROM php:8.3-fpm-alpine AS runtime

LABEL maintainer="CRM Team" \
      description="Open-Source CRM Backend — PHP 8.3 + Laravel" \
      version="1.0.0"

# ---- System dependencies ----
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpq-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    linux-headers \
    shadow \
    nginx \
    supervisor \
    # Health-check tools
    postgresql-client

# ---- PHP extensions ----
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    zip \
    opcache \
    intl \
    bcmath \
    pcntl

# ---- Opcache tuning (production defaults) ----
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.save_comments=1'; \
    echo 'opcache.fast_shutdown=1'; \
} > /usr/local/etc/php/conf.d/opcache.ini

# ---- PHP-FPM pool config ----
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/php.ini       /usr/local/etc/php/conf.d/app.ini

# ---- Nginx config ----
COPY docker/nginx/nginx.conf     /etc/nginx/nginx.conf
COPY docker/nginx/default.conf   /etc/nginx/http.d/default.conf

# ---- Supervisor ----
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ---- Application ----
WORKDIR /var/www/html

COPY . .
COPY --from=composer-stage /app/vendor ./vendor

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ---- Entrypoint ----
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
    CMD curl -f http://localhost:8000/api/health || exit 1

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
