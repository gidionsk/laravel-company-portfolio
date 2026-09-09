# Production deployment

The current production target is GitHub, Railway, and Railway MySQL.

## Railway application variables

Use the Laravel service Variables tab. The MySQL service in this project is named `MySQL`.

```env
APP_NAME="Portfolio Demo"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:replace-with-real-key
APP_URL=https://your-service.up.railway.app

LOG_CHANNEL=stderr
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=public
PORTFOLIO_MEDIA_DISK=public

RUN_MIGRATIONS=true
RUN_SEEDER=false
PORTFOLIO_SEED_DEMO=false
```

Use a real `APP_KEY`. Generate one locally with:

```powershell
php artisan key:generate --show
```

## Deploy an update

```powershell
git add .
git commit -m "Apply anti-slop portfolio redesign"
git push origin main
```

Railway will build the Docker image and deploy the new revision. The entrypoint runs migrations when `RUN_MIGRATIONS=true`.

## Health check

Set Railway's health-check path to:

```text
/health
```

A healthy response confirms that the application can also reach MySQL.

## Persistent uploads

Mount the web-service volume at:

```text
/var/www/html/storage/app/public
```

Without a persistent volume, locally stored project uploads can disappear when the container is replaced.

## After this redesign

The new migrations:

1. Add `projects.is_concept`.
2. Mark the bundled demo projects as concept case studies.
3. Remove demo client names and metrics from those records.
4. Disable the three old fictional demo testimonials.
5. Rewrite the default service and homepage copy around features that actually exist.

The migrations do not alter unrelated user-created project records.
