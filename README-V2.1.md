# Northstar Portfolio V2 — Laravel Company Website + Admin CMS

Upgrade dari template company profile sebelumnya. Versi ini bukan lagi static one-page saja: portfolio, services, testimonials, website settings, dan inquiry sudah dikelola melalui database + admin panel.

## Fitur

### Public website
- Modern responsive company profile
- Home / About / Services / Selected Work / Process / Testimonial / Contact
- Portfolio archive: `/projects`
- Project case-study detail: `/projects/{slug}`
- Dynamic company name, hero copy, contact info, dan social links
- Dynamic services, projects, testimonials dari database
- Optional uploaded project cover image
- Contact form tersimpan ke database
- SEO title + meta description untuk project detail

### Admin CMS
- Login: `/admin/login`
- Dashboard overview
- CRUD Projects
- Upload cover image project
- Draft / Published + Featured project
- CRUD Services
- CRUD Testimonials
- Inbox inquiry + status New / Read / Archived
- Website settings tanpa edit source code
- Responsive admin panel

## Stack
- Laravel 13 compatible
- PHP 8.3+ (PHP 8.4 recommended / compatible)
- Blade
- Eloquent ORM
- Laravel Authentication session
- Laravel Filesystem public disk
- Vite
- Vanilla CSS + JavaScript
- No third-party admin package required

---

# Instalasi ke project Laravel kamu

Asumsi project Laravel kamu berada di:

```text
D:\Project\Company Profile\company-profile
```

Extract ZIP ini lalu copy seluruh isinya ke root project Laravel. Pilih **Replace / Merge** saat diminta.

File yang ditambahkan / diubah antara lain:

```text
app/Http/Controllers/
app/Http/Controllers/Admin/
app/Models/
database/migrations/
database/seeders/DatabaseSeeder.php
resources/views/
resources/css/app.css
resources/js/app.js
routes/web.php
```

Template ini tidak mengganti file framework inti Laravel.

## 1. Masuk ke project

```powershell
cd "D:\Project\Company Profile\company-profile"
```

## 2. Pastikan PHP benar

```powershell
where.exe php
php -v
php --ini
```

Kalau kamu memakai XAMPP, idealnya `C:\xampp\php\php.exe` ada di urutan pertama.

## 3. Install dependency frontend

```powershell
npm install
```

## 4. Database

Laravel baru biasanya sudah mudah dipakai dengan SQLite. Kalau `.env` kamu sudah menggunakan SQLite, cukup lanjut ke migrate.

Kalau ingin MySQL/XAMPP, ubah `.env` misalnya:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=company_profile
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `company_profile` terlebih dahulu dari phpMyAdmin / MySQL.

## 5. Set admin account

Tambahkan ke `.env`:

```env
ADMIN_EMAIL=admin@company.com
ADMIN_PASSWORD=GantiDenganPasswordYangKuat
```

Jika tidak diisi, seeder development menggunakan:

```text
admin@northstar.test
password
```

**Jangan gunakan credential default di production.**

## 6. Migration + sample data

Project baru / database kosong:

```powershell
php artisan migrate --seed
```

Kalau kamu sedang development dan boleh menghapus seluruh database lama:

```powershell
php artisan migrate:fresh --seed
```

`migrate:fresh` akan menghapus seluruh tabel, jadi jangan jalankan pada database yang berisi data penting.

## 7. Aktifkan uploaded project image

```powershell
php artisan storage:link
```

## 8. Jalankan frontend

Terminal 1:

```powershell
npm run dev
```

Terminal 2:

```powershell
php artisan serve
```

Buka:

```text
Website : http://127.0.0.1:8000
Admin   : http://127.0.0.1:8000/admin/login
```

---

# Workflow admin

## Project
Admin → Projects → Add Project.

Data yang dapat diatur:
- Title
- Category
- Summary
- Challenge
- Solution
- Result
- Metric
- Tags
- Theme
- Cover image
- Featured
- Published / Draft
- Sort order

Slug project dibuat otomatis dari title.

## Inquiry
Setiap submission form Contact akan tersimpan ke `contact_messages` dan muncul di Admin → Messages.

Admin bisa:
- membaca inquiry
- membuka email reply
- membuka WhatsApp jika nomor tersedia
- mengubah status New / Read / Archived
- menghapus inquiry

## Website Settings
Admin → Website Settings dapat mengubah:
- company name
- short brand name
- tagline
- hero title
- highlighted phrase
- hero description
- email
- phone
- WhatsApp
- location
- Instagram
- LinkedIn

---

# Production checklist

Sebelum deploy:

```powershell
npm run build
php artisan optimize
```

Set `.env` production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-kamu.com
```

Gunakan password admin yang kuat, database production, HTTPS, dan pastikan `storage` serta `bootstrap/cache` writable.

Untuk email notification real-time, versi ini menyimpan inquiry ke database terlebih dahulu. Laravel Mail / SMTP bisa ditambahkan setelah SMTP provider ditentukan.

---

# Struktur penting

```text
app/
├── Http/Controllers/
│   ├── CompanyController.php
│   ├── ProjectController.php
│   └── Admin/
│       ├── AuthController.php
│       ├── DashboardController.php
│       ├── ProjectController.php
│       ├── ServiceController.php
│       ├── TestimonialController.php
│       ├── ContactMessageController.php
│       └── SettingController.php
└── Models/
    ├── Project.php
    ├── Service.php
    ├── Testimonial.php
    ├── ContactMessage.php
    └── SiteSetting.php

database/
├── migrations/
└── seeders/DatabaseSeeder.php

resources/views/
├── home.blade.php
├── projects/
├── layouts/
└── admin/
```

## Recommended next upgrade
- SMTP/email notification untuk inquiry baru
- Multiple project gallery images
- Rich text editor
- Team/member CMS
- Client logos CMS
- Analytics dashboard
- Spam protection / Cloudflare Turnstile
- Deployment + domain + HTTPS


## v2.1 compatibility fix
- Switched Eloquent casts from `casts()` methods to the `$casts` property for broader Laravel-version compatibility.
- Fixes `Array to string conversion` during seeding for JSON `tags` fields.
