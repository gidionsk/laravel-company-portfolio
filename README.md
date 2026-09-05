# Company Portfolio V4 — Production Ready

V4 mempertahankan tampilan **Premium Studio Edition** dari V3 dan fokus pada hal yang benar-benar dibutuhkan sebelum website dipublikasikan. Tidak ada penambahan branding/logo khusus.

## Yang ditambahkan di V4

- Production security headers.
- Rate limit untuk login admin dan contact form.
- Honeypot anti-spam pada contact form.
- `/health` endpoint yang mengecek aplikasi + database.
- `sitemap.xml`, `robots.txt`, canonical URL, Open Graph, dan Twitter card metadata.
- Database indexes untuk query public/admin yang sering dipakai.
- Media storage tidak lagi hard-coded ke disk `public`; bisa dipindah ke persistent disk atau S3-compatible storage lewat env.
- Seeder production tidak lagi boleh memakai password default.
- Docker production image: PHP 8.4 + Apache + OPcache + Vite production build.
- Runtime migration/seed flags untuk deployment pertama.
- Environment template production.
- Feature tests dan GitHub Actions CI.

## Upgrade dari V3

Copy **isi folder V4** ke root Laravel kamu, misalnya:

```text
D:\Project\Company Profile
```

Merge/replace file yang sama. Jangan copy menjadi subfolder baru.

Kemudian:

```powershell
php artisan optimize:clear
php artisan migrate
npm install
npm run build
php artisan test
```

Untuk local development tetap jalankan:

```powershell
npm run dev
```

Terminal kedua:

```powershell
php artisan serve --host=127.0.0.1 --port=8888
```

## Production checklist

Sebelum deploy:

```powershell
php artisan key:generate --show
```

Simpan hasilnya sebagai `APP_KEY` di hosting. Jangan commit file `.env`.

Production minimal:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-kamu.com
APP_KEY=base64:...
ADMIN_EMAIL=...
ADMIN_PASSWORD=...
```

Database dan session juga harus memakai credential production, bukan credential XAMPP/local.

## Media upload

Default:

```env
PORTFOLIO_MEDIA_DISK=public
```

Untuk Docker/Railway, folder berikut harus persistent bila admin akan upload cover/gallery:

```text
/var/www/html/storage/app/public
```

Alternatif yang lebih scalable adalah S3-compatible object storage. Jika ingin menggunakan `s3`, install adapter Flysystem AWS terlebih dahulu di project utama lalu isi credential storage.

## Seeder production

Seeder sekarang membutuhkan:

```env
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=password-random-yang-panjang
```

Untuk deploy pertama dan tetap ingin sample portfolio:

```env
PORTFOLIO_SEED_DEMO=true
RUN_SEEDER=true
```

Setelah seed pertama berhasil, ubah:

```env
RUN_SEEDER=false
```

Agar restart/redeploy berikutnya tidak menjalankan seeder lagi.

## Migration production

Docker entrypoint mendukung:

```env
RUN_MIGRATIONS=true
```

Untuk portfolio demo dengan satu web instance ini praktis. Untuk deployment besar/multi-replica, jalankan migration sebagai release/pre-deploy step tersendiri, lalu set `RUN_MIGRATIONS=false`.

## Health check

Endpoint:

```text
GET /health
```

Response normal:

```json
{
  "status": "ok",
  "app": "Portfolio Demo"
}
```

Jika database tidak bisa diakses, endpoint mengembalikan HTTP `503`.

## Production optimization

Docker menjalankan:

```bash
php artisan optimize
```

saat container start. Laravel akan meng-cache configuration, events, routes, dan views untuk production.

## Deployment

Panduan Railway + MySQL dan Docker/VPS tersedia di:

```text
PRODUCTION_DEPLOYMENT.md
```

## File production baru

```text
app/Http/Middleware/SecurityHeaders.php
app/Http/Controllers/HealthController.php
app/Http/Controllers/SitemapController.php
config/portfolio.php
resources/views/sitemap.blade.php
public/robots.txt
Dockerfile
docker/entrypoint.sh
docker/php.ini
docker/apache-portfolio.conf
.env.production.example
.github/workflows/ci.yml
tests/Feature/*
PRODUCTION_DEPLOYMENT.md
```
