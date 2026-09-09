# Apply the anti-slop update

This ZIP is an upgrade overlay for the existing Laravel repository. Copy its contents into the project root and choose replace/merge when prompted.

Do not run `migrate:fresh` on production data.

## Local check

```powershell
cd "D:\Project\Company Profile"
php artisan optimize:clear
php artisan migrate
npm ci
npm run build
php artisan test
```

The two new migrations add the explicit concept flag and clean the bundled demo content. They do not change the admin password.

## Commit

```powershell
git status
git add .
git commit -m "Apply anti-slop portfolio redesign"
git push origin main
```

Railway should redeploy automatically.

## Railway variables

Keep:

```env
RUN_MIGRATIONS=true
RUN_SEEDER=false
PORTFOLIO_SEED_DEMO=false
```

There is no need to run the seeder again. The new production data changes are migrations.

## Production smoke test

After Railway reports Online, verify:

- `/` shows the new restrained homepage and implementation ledger.
- `/projects` labels bundled items as Concept case study.
- `/projects/nexa-finance` states that the brief is fictional.
- No fake metrics or fictional testimonials are visible.
- Mobile menu opens and closes.
- Project filters update the visible list.
- Contact form shows validation and a success message.
- `/admin/login` still accepts the existing database credential.
- Admin project edit has a Concept case study checkbox.
- Saving a concept project clears client and metric fields.
- `/health` returns `ok`.

The anti-slop audit and follow-up report are in `anti-slop/`.
