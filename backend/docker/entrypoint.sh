#!/bin/bash
# =============================================================================
# Docker Entrypoint — CRM Backend
# Runs on every container start before the CMD is executed.
# =============================================================================

set -e

echo "=================================================="
echo " CRM Backend — Starting up"
echo " Environment: ${APP_ENV:-local}"
echo " Date: $(date -u +%Y-%m-%dT%H:%M:%SZ)"
echo "=================================================="

# ---- Wait for PostgreSQL to be ready ----
echo "[entrypoint] Waiting for PostgreSQL at ${DATABASE_HOST:-crm-db}:${DATABASE_PORT:-5432}..."
until pg_isready -h "${DATABASE_HOST:-crm-db}" -p "${DATABASE_PORT:-5432}" -U "${DATABASE_USER:-crm_user}" > /dev/null 2>&1; do
    echo "[entrypoint] PostgreSQL not ready yet — retrying in 2s..."
    sleep 2
done
echo "[entrypoint] PostgreSQL is ready."

# ---- Ensure storage directories exist ----
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/{cache,sessions,views}
mkdir -p /var/www/html/bootstrap/cache

# ---- Set permissions ----
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ---- Cache configuration (production only) ----
if [ "${APP_ENV}" = "production" ]; then
    echo "[entrypoint] Caching configuration for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "[entrypoint] Configuration cached."
fi

# ---- Run migrations (auto-migrate on startup) ----
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "[entrypoint] Running database migrations..."
    php artisan migrate --force --no-interaction
    echo "[entrypoint] Migrations complete."
fi

echo "[entrypoint] CRM Backend initialization complete."
echo "[entrypoint] Starting Supervisor (Nginx + PHP-FPM)..."

exec "$@"
