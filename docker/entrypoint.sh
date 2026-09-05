#!/bin/sh
set -eu

PORT="${PORT:-8080}"

# Railway / managed MySQL compatibility
if [ -z "${DB_HOST:-}" ] && [ -n "${MYSQLHOST:-}" ]; then
    export DB_HOST="$MYSQLHOST"
fi

if [ -z "${DB_PORT:-}" ] && [ -n "${MYSQLPORT:-}" ]; then
    export DB_PORT="$MYSQLPORT"
fi

if [ -z "${DB_DATABASE:-}" ] && [ -n "${MYSQLDATABASE:-}" ]; then
    export DB_DATABASE="$MYSQLDATABASE"
fi

if [ -z "${DB_USERNAME:-}" ] && [ -n "${MYSQLUSER:-}" ]; then
    export DB_USERNAME="$MYSQLUSER"
fi

if [ -z "${DB_PASSWORD:-}" ] && [ -n "${MYSQLPASSWORD:-}" ]; then
    export DB_PASSWORD="$MYSQLPASSWORD"
fi


# =========================================================
# Railway dynamic port
# =========================================================

sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf

sed -ri \
    "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf


# =========================================================
# Laravel writable directories
# =========================================================

mkdir -p \
    storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

php artisan storage:link >/dev/null 2>&1 || true

echo "Clearing Laravel configuration cache..."
php artisan config:clear

# =========================================================
# Database
# =========================================================

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

if [ "${RUN_SEEDER:-false}" = "true" ]; then
    php artisan db:seed --force
fi


# =========================================================
# Laravel optimization
# =========================================================

php artisan optimize


# =========================================================
# Apache MPM fix
# Railway may expose more than one enabled MPM.
# mod_php must use mpm_prefork.
# =========================================================

echo "Fixing Apache MPM configuration..."

a2dismod -f mpm_event >/dev/null 2>&1 || true
a2dismod -f mpm_worker >/dev/null 2>&1 || true

rm -f \
    /etc/apache2/mods-enabled/mpm_event.load \
    /etc/apache2/mods-enabled/mpm_event.conf \
    /etc/apache2/mods-enabled/mpm_worker.load \
    /etc/apache2/mods-enabled/mpm_worker.conf

a2enmod mpm_prefork >/dev/null 2>&1 || true

echo "Apache MPM configuration:"
ls -la /etc/apache2/mods-enabled/mpm_* 2>/dev/null || true

echo "Testing Apache configuration..."
apache2ctl configtest


# =========================================================
# Start container command
# =========================================================

exec "$@"
