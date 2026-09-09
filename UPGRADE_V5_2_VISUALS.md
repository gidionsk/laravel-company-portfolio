# V5.2 Professional Visual Upgrade

This patch is designed to sit on top of the Anti-Slop V5 + V5.1 motion build.

## What changes

- Replaces the hero's text-only right column with a purpose-built interface preview.
- Keeps a compact implementation ledger as factual technical proof.
- Adds a `Selected screens` editorial section.
- Adds six lightweight SVG visual assets stored in the repository.
- Uses concept-specific imagery for Nexa Finance, Aruna Living, FlowDesk, and Vanta Commerce when no uploaded cover exists.
- Adds restrained entrance motion and hover movement to visual surfaces.
- Preserves `prefers-reduced-motion` behavior.

The visuals are explicitly concept interfaces. They contain no invented revenue, retention, client or performance metrics.

## Install

Copy the contents of this folder into the Laravel project root and replace matching files.

Then run:

```powershell
npm run build
php artisan test
```

If both pass:

```powershell
git add .
git commit -m "Add professional visual portfolio layer"
git push origin main
```

No database migration, seeder change, Docker change, or Railway variable change is required.

## Important

This patch intentionally does not contain `resources/views/projects/show.blade.php`, so any local fixes already made to the case-study detail view are preserved.
