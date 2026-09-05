# Production Deployment Guide

Rekomendasi paling praktis untuk portfolio ini adalah **GitHub → Railway → MySQL**, menggunakan `Dockerfile` yang sudah tersedia. Setup yang sama juga bisa dijalankan di VPS/container host lain.

---

# A. Final check di laptop

Pastikan semua perubahan V4 sudah masuk ke root Laravel.

```powershell
php artisan optimize:clear
php artisan migrate
npm install
npm run build
php artisan test
```

Pastikan semua test sukses.

Generate production key:

```powershell
php artisan key:generate --show
```

Copy hasil `base64:...`. Jangan mengganti `APP_KEY` production setelah website sudah memiliki encrypted data/session.

---

# B. Push ke GitHub

Dari root project:

```powershell
git init
git add .
git commit -m "Prepare portfolio for production"
git branch -M main
```

Buat repository GitHub kosong lalu hubungkan remote:

```powershell
git remote add origin <repository-git-url>
git push -u origin main
```

Pastikan `.env` tidak ikut ter-commit.

---

# C. Deploy ke Railway

## 1. Buat project

Di Railway:

1. New Project.
2. Deploy from GitHub Repo.
3. Pilih repository portfolio.
4. Railway akan menemukan `Dockerfile` di root dan menggunakannya untuk build.

Jangan generate public domain dulu sampai database dan environment variables selesai.

## 2. Tambahkan MySQL

Pada project canvas yang sama:

1. `+ New`
2. Pilih MySQL.
3. Tunggu database selesai dibuat.

## 3. Hubungkan environment variable web service ke MySQL

Nama service database Railway biasanya `MySQL`. Jika kamu mengganti nama service, sesuaikan namespace reference di bawah.

Tambahkan pada **Variables** web service:

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

Gunakan Reference Variables, jangan copy credential database secara manual bila tidak diperlukan.

## 4. Tambahkan application variables

```env
APP_NAME=Portfolio Demo
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:HASIL_DARI_KEY_GENERATE
LOG_LEVEL=warning

ADMIN_EMAIL=email-admin-kamu
ADMIN_PASSWORD=password-random-yang-panjang

SESSION_DRIVER=database
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=database

PORTFOLIO_MEDIA_DISK=public
PORTFOLIO_SEED_DEMO=true
RUN_MIGRATIONS=true
RUN_SEEDER=true
```

`APP_URL` diisi setelah Railway public domain tersedia.

## 5. Persistent media volume

Jika ingin upload cover/gallery lewat admin dan tetap tersimpan setelah redeploy, tambahkan Volume ke **web service** dengan mount path:

```text
/var/www/html/storage/app/public
```

Tanpa volume, file yang di-upload ke local filesystem container bisa hilang saat deployment diganti.

Database MySQL Railway dikelola sebagai service terpisah; jangan mount volume MySQL ke web service.

## 6. Health check

Di Settings web service, set health check path:

```text
/health
```

Deployment baru baru dianggap sehat jika endpoint ini mengembalikan HTTP 200 dan koneksi database berhasil.

## 7. Generate domain

Setelah deployment berhasil:

1. Settings → Networking.
2. Generate Domain.
3. Copy domain Railway, misalnya `xxxxx.up.railway.app`.

Set:

```env
APP_URL=https://xxxxx.up.railway.app
```

Railway akan redeploy.

## 8. Matikan seeder setelah deploy pertama

Setelah homepage dan admin berhasil dibuka, ubah:

```env
RUN_SEEDER=false
```

Biarkan:

```env
RUN_MIGRATIONS=true
```

untuk project portfolio single-instance sederhana. Untuk scale >1 replica gunakan migration sebagai release step dan matikan runtime migration.

## 9. Admin

Buka:

```text
https://domain-kamu/admin/login
```

Login memakai `ADMIN_EMAIL` / `ADMIN_PASSWORD` yang dipakai ketika seeder dijalankan.

Jika kamu mengubah credential env setelah admin sudah dibuat, menjalankan seeder lagi akan meng-update password user tersebut.

---

# D. Custom domain

Setelah Railway domain bekerja:

1. Tambahkan custom domain di Networking.
2. Ikuti DNS record yang diberikan Railway.
3. Setelah SSL aktif, ubah:

```env
APP_URL=https://domain-kamu.com
```

Pastikan:

```env
SESSION_SECURE_COOKIE=true
```

---

# E. VPS / Docker alternatif

Docker image yang sama bisa digunakan pada VPS.

Build:

```bash
docker build -t company-portfolio:latest .
```

Run contoh:

```bash
docker run -d \
  --name company-portfolio \
  -p 8080:8080 \
  --env-file .env.production \
  -e PORT=8080 \
  -e RUN_MIGRATIONS=true \
  -v portfolio-media:/var/www/html/storage/app/public \
  company-portfolio:latest
```

Database sebaiknya MySQL terpisah/managed, bukan database ephemeral di container aplikasi.

Reverse proxy (Nginx/Caddy/Cloudflare) dapat diarahkan ke port 8080 dan menangani HTTPS.

---

# F. Setelah production online

Checklist singkat:

- `APP_DEBUG=false`.
- `/health` HTTP 200.
- Homepage dan `/projects` dapat dibuka.
- Draft project mengembalikan 404 dari public URL.
- `/admin` meminta login.
- Login gagal berulang terkena rate limit.
- Contact form berhasil masuk ke admin Messages.
- `/sitemap.xml` dapat dibuka.
- `/robots.txt` dapat dibuka.
- Upload gambar tetap ada setelah redeploy/restart.
- Backup MySQL dan volume media aktif.

---

# G. Update berikutnya

Workflow normal setelah production:

```powershell
git add .
git commit -m "Update portfolio content"
git push
```

Railway akan melakukan build/deploy dari commit baru. `Dockerfile` menjalankan Vite production build, Composer `--no-dev`, OPcache, dan `php artisan optimize`.
