#!/bin/sh
set -eu

PORT="${PORT:-8080}"

# Railway / managed MySQL compatibility when reference variables are exposed.
if [ -z "${DB_HOST:-}" ] && [ -n "${MYSQLHOST:-}" ]; then export DB_HOST="$MYSQLHOST"; fi
if [ -z "${DB_PORT:-}" ] && [ -n "${MYSQLPORT:-}" ]; then export DB_PORT="$MYSQLPORT"; fi
if [ -z "${DB_DATABASE:-}" ] && [ -n "${MYSQLDATABASE:-}" ]; then export DB_DATABASE="$MYSQLDATABASE"; fi
if [ -z "${DB_USERNAME:-}" ] && [ -n "${MYSQLUSER:-}" ]; then export DB_USERNAME="$MYSQLUSER"; fi
if [ -z "${DB_PASSWORD:-}" ] && [ -n "${MYSQLPASSWORD:-}" ]; then export DB_PASSWORD="$MYSQLPASSWORD"; fi

sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

php artisan storage:link >/dev/null 2>&1 || true

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

if [ "${RUN_SEEDER:-false}" = "true" ]; then
    php artisan db:seed --force
fi

php artisan optimize

exec "$@"
