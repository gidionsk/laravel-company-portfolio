# Laravel portfolio demo

A production-deployed Laravel 9 portfolio example with public concept case studies and a database-backed admin CMS.

The interface follows the repository's anti-slop design direction in `DESIGN.md`: fictional work is labelled as concept work, invented metrics and testimonials are not shown, motion is minimal, and the visual system is intentionally restrained.

## What is implemented

- Laravel 9 + Blade + Eloquent
- MySQL content storage
- Public homepage, archive, and case-study pages
- `is_concept` flag for honest concept labelling
- Admin authentication
- CRUD for projects, services, testimonials, and site settings
- Contact inbox stored in MySQL
- Image uploads through the configured media disk
- Rate limiting and security headers
- `/health`, `/sitemap.xml`, and `robots.txt`
- Vite frontend build
- Docker + Apache production runtime
- Railway-compatible dynamic port and MySQL references

## Local setup

```powershell
composer install
npm ci
php artisan migrate
npm run build
```

For local development:

```powershell
npm run dev
php artisan serve --host=127.0.0.1 --port=8888
```

## Production update

The anti-slop update adds migrations `2026_09_09_000009` and `2026_09_09_000010`. Keep `RUN_MIGRATIONS=true` on Railway so the concept flag and demo-content cleanup run during deployment.

Do not run the demo seeder on every deployment. After the first seed, use:

```env
RUN_MIGRATIONS=true
RUN_SEEDER=false
PORTFOLIO_SEED_DEMO=false
```

See `PRODUCTION_DEPLOYMENT.md` for the Railway checklist.
