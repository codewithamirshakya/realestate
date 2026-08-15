# Om Realtors &mdash; Real Estate Platform

A full-featured real estate marketplace built with Laravel, created for **Om Realtors Pvt. Ltd.**
(ओम रियलटर्स प्रा. लि.), Batukbhairab, Hanumansthan, Lagankhel, Lalitpur.

## What's included

- **Public site** &mdash; home page, property listings with search/filter (type, category, city,
  price, bedrooms), property detail pages with an inquiry form, a services page built from the
  six services on the company's business card, an about page, and a contact form that emails
  the team and logs the message.
- **Accounts & roles** &mdash; visitors can register as a **buyer** (browse, save favorites, send
  inquiries) or an **agent** (list and manage their own properties). An **admin** role manages
  everything.
- **Agent dashboard** &mdash; create/edit/delete listings, upload multiple photos per property,
  mark a listing sold/rented/pending, see inquiries received.
- **Admin dashboard** &mdash; manage every property (assign to any agent), manage inquiries
  (status: new/contacted/closed), manage users and their roles, and edit the services shown on
  the Services page.
- **Buyer dashboard** &mdash; saved/favorited properties and a history of inquiries sent.
- **Content management (CMS)** &mdash; admins can edit the copy and images on the public pages
  from **Admin &rarr; Site Content**, or edit them **inline**: turn on edit mode and click any
  highlighted text straight on the live page. See [Site content (CMS)](#site-content-cms) below.
- Branding, colors, and copy are based on the Om Realtors business card (navy `#1c4f6e` and
  green `#4bb95a`), with an inline SVG recreation of the mountain/skyline logo mark so it stays
  crisp at any size, plus bilingual (Nepali/English) labels throughout.

## Tech stack

- Laravel 13 (PHP 8.3+)
- SQLite by default (zero setup) &mdash; swap to MySQL/Postgres by editing `.env`
- Tailwind CSS v4 + Vite for the frontend build
- Laravel's built-in session auth (no separate auth package) with a custom `role` middleware for
  admin/agent/buyer access control

## ⚠️ About this build

This project was scaffolded in a sandboxed environment whose network access does not include
**Packagist** (Composer's package registry), so `composer install` could not be run or verified
here. Every PHP file has been checked with `php -l` (no syntax errors), and the Tailwind/Vite
frontend build was test-compiled successfully. On your own machine &mdash; which has normal
internet access &mdash; `composer install` will work exactly as it would for any fresh Laravel
project. Follow the setup steps below.

## Setup

1. **Install PHP dependencies**

   ```bash
   composer install
   ```

2. **Copy the environment file and generate an app key**

   The `.env` file is already included with sensible local defaults (SQLite, mail logged instead
   of sent). If you'd rather start fresh:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   If you're using the included `.env`, just run `php artisan key:generate` if `APP_KEY` is empty.

3. **Create the SQLite database** (already created as an empty file at
   `database/database.sqlite`; skip if it already exists)

   ```bash
   touch database/database.sqlite
   ```

4. **Run migrations and seed demo data**

   ```bash
   php artisan migrate --seed
   ```

   This creates:

   | Role  | Email                     | Password   |
   |-------|---------------------------|------------|
   | Admin | admin@omrealtors.com.np   | password   |
   | Agent | agent@omrealtors.com.np   | password   |
   | Buyer | buyer@example.com         | password   |

   plus 3 extra demo agents and 24 sample property listings with placeholder photos, and the
   six services from the business card.

   **Change these passwords before deploying anywhere public.**

5. **Link storage** (so uploaded/seeded property photos are servable)

   ```bash
   php artisan storage:link
   ```

6. **Install JS dependencies and build the frontend**

   ```bash
   npm install
   npm run build
   ```

   For local development with hot reload, use `npm run dev` in a second terminal instead.

7. **Serve the app**

   ```bash
   php artisan serve
   ```

   Visit http://localhost:8000.

### One-liner (after `composer install` and `npm install`)

```bash
php artisan key:generate && php artisan migrate --seed && php artisan storage:link && npm run build
```

## Site content (CMS)

Every heading, blurb, button label and hero/about image on the public site is editable by an
admin &mdash; no code deploy needed.

**Two ways to edit**

1. **The content manager** &mdash; `Admin → Site Content` (`/admin/content`). Fields are grouped by
   page (Company &amp; contact, Home, Services, About, Contact, Footer, SEO). Each input shows the
   built-in default as its placeholder: leave it blank and the default is used, tick *Reset to
   default* to throw an override away.
2. **Inline editing** &mdash; press **Edit site inline** on the admin dashboard (or *Edit this page*
   in the black bar that follows an admin around the site). Editable text gets a dashed green
   outline; click it, type, then click away or press <kbd>Enter</kbd> to save (<kbd>Esc</kbd>
   cancels). Images get a *Change image* button that uploads straight from the page. Saving is a
   background request &mdash; no page reload, and the bar confirms each save.

**How it fits together**

| Piece | Where |
|-------|-------|
| Which keys exist, their labels, types and defaults | `config/cms.php` |
| Stored overrides (only the values actually edited) | `site_contents` table / `App\Models\SiteContent` |
| Read/write + caching + edit-mode state | `App\Support\Cms` |
| Admin screens and the inline/upload endpoints | `App\Http\Controllers\Admin\ContentController` |
| Rendering | `<x-editable key="home.cta.title" as="h2" class="..." />`, `<x-editable-image key="about.image_primary" />`, or `@cms('home.cta.button')` inside an attribute |
| Inline editing behaviour | `resources/js/cms.js` (loaded via `resources/js/app.js`) |

To make another piece of copy editable: add the key to `config/cms.php`, then swap the hard-coded
text in the Blade view for `<x-editable>` (or `@cms(...)` where a wrapping tag won't fit). Nothing
else &mdash; no migration, no seeder.

Values in the **Company &amp; contact** group override `config/company.php` at runtime, so the phone
number, address, email and taglines change everywhere at once (nav, footer, contact page, emails).

Uploaded CMS images go to the `public` disk under `storage/app/public/cms`, so
`php artisan storage:link` must have been run. Resolved values are cached (`cms.overrides`) and the
cache is flushed automatically on every save.

## Things to update before going live

- **`config/company.php`** (and the matching `COMPANY_*` values in `.env`) &mdash; the phone
  number was not fully legible on the photographed business card, so it's currently a
  placeholder (`+977-98XXXXXXXX`). Update it, plus the email and Facebook link.
- **Mail** &mdash; `.env` currently uses `MAIL_MAILER=log`, so contact-form emails are written to
  `storage/logs/laravel.log` instead of actually being sent. Point `MAIL_*` at a real SMTP
  provider (or Mailgun/SES/etc.) before launch.
- **Database** &mdash; SQLite is fine for development; for production, switch `DB_CONNECTION` in
  `.env` to `mysql` or `pgsql` and fill in the connection details.
- **Seeded demo data** &mdash; the 24 sample properties and demo users are for development only.
  Remove them (or just don't run `--seed` in production) and replace the placeholder property
  photos with real listing photos.
- **Storage disk** &mdash; property photos are stored on the `public` local disk
  (`storage/app/public`). For production on more than one server, switch to an S3-compatible
  disk in `config/filesystems.php`.

## Project structure notes

- `app/Http/Controllers/Agent/*` and `app/Http/Controllers/Admin/*` both manage properties;
  shared upload/delete logic lives in `app/Http/Controllers/Concerns/ManagesPropertyImages.php`.
- Role access is enforced by `app/Http/Middleware/EnsureUserHasRole.php`, registered as the
  `role` middleware alias in `bootstrap/app.php` (used as `->middleware('role:admin')` etc.).
- `resources/views/properties/_form.blade.php` is a shared create/edit form used by both the
  agent and admin property views.
- Editable site copy is declared in `config/cms.php`, resolved by `app/Support/Cms.php`, and
  rendered through the `x-editable` / `x-editable-image` components (see
  [Site content (CMS)](#site-content-cms)).
- The logo mark is a generated inline SVG component at
  `resources/views/components/logo-mark.blade.php` (no image dependency, scales cleanly).
- The two original business card photos are included at
  `public/images/business-card-front.jpg` / `business-card-back.jpg` and shown on the About page.
