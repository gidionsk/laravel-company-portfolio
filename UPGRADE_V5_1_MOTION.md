# V5.1 motion polish

This is a small overlay for Anti-Slop V5. It does not change Laravel models, migrations, database state, admin authentication, Docker, or Railway configuration.

## Changes

- Reduced desktop hero top padding and slightly reduced headline size.
- Replaced multi-line highlight underlines with one accent rule under the hero heading.
- Added one-time, low-distance viewport reveals for major content groups.
- Added a short stagger to the implementation ledger on first view.
- Added subtle project-card hover feedback.
- Added brief visual feedback when project filters reveal matching items.
- Preserved content visibility when JavaScript is disabled.
- Fully respects `prefers-reduced-motion`.
- Updated `DESIGN.md` from Motion 1/5 to Motion 2/5.

## Install

Copy these files into the existing V5 project:

- `resources/css/app.css`
- `resources/js/app.js`
- `DESIGN.md`

Then run:

```powershell
npm run build
php artisan test
```

If both succeed:

```powershell
git add resources/css/app.css resources/js/app.js DESIGN.md UPGRADE_V5_1_MOTION.md
git commit -m "Add restrained motion polish"
git push origin main
```
