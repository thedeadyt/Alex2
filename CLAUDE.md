# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Alex² is a PHP agency/portfolio website for a web development duo based in Tarbes/Lourdes (65, France). It combines server-side PHP rendering with client-side React components (JSX transpiled via Babel in-browser). No build step required.

## Architecture

**Hybrid PHP + React**: PHP handles routing, data fetching, and page shell. React 18 (CDN) renders interactive UI components inline via `<script type="text/babel">` blocks. Tailwind CSS (CDN) for styling.

```
config/          → PHP config (BASE_URL, PDO database, .env loader)
includes/        → Shared components (header.php, footer.php) - included in <body>
public/          → Web root (Apache serves from here via .htaccess rewrite)
  ├── api/       → REST JSON endpoints (blog, projects, services, clients)
  ├── admin/     → Dashboard (session-authenticated, React SPA)
  ├── pages/     → Page views (each is a full HTML document)
  └── asset/     → Static files (css/, fonts/, img/, icons/)
sql/             → Database migration SQL files
```

**Routing**: Two-layer `.htaccess` system. Root `.htaccess` rewrites all requests into `public/`. Public `.htaccess` maps clean URLs (e.g., `/Nos-Réalisations` → `pages/NosProjets.php`) and falls back to `pages/$1.php` for unknown routes.

**Data flow**: PHP fetches from MySQL (PDO), encodes to JSON in `<script>` tags (`window.dataFromPHP = <?= json_encode(...) ?>`), React components read from `window.*` globals.

## Environments

- **Dev**: `http://dev.alex2-server.fr/Alex2/` — `BASE_URL = '/Alex2/'`, DB host: `php-dev-db`
- **Prod**: `https://alex2.dev/` — `BASE_URL = '/'`, DB host: OVH MySQL

Environment is auto-detected in `config/config.php` via `$_SERVER['HTTP_HOST']`.

## Commands

```bash
# Install dependencies
composer install

# Run blog SQL migration (Docker dev)
docker exec -i php-dev-db mysql -uroot -proot11122005 alex2pro_site < sql/create_blog_table.sql

# Copy .env for email/auth config
cp public/pages/.env.example public/pages/.env
```

No build process, no test suite, no linter configured. Changes are live immediately.

## Key Conventions

- **Page files**: PascalCase (`NosProjets.php`, `Apropos.php`), API files lowercase (`blog.php`)
- **CSS**: Design tokens in `variables.css` (`:root` custom properties). Two font families: `--font-tinos` (body, Google Fonts) and `--font-bounded` (headings, local TTF). Color palette: green `#51845C`, cyan `#30b8c6`, dark `#1f2020`
- **React in PHP**: Functional components with hooks, rendered via `ReactDOM.createRoot()`. No external state management.
- **API pattern**: Each endpoint in `api/` handles GET/POST/PUT/DELETE via `$_SERVER['REQUEST_METHOD']` switch. Returns JSON. Session auth required.
- **Font loading**: `@font-face` for Bounded must use PHP-resolved paths (`<?= BASE_URL ?>asset/fonts/...`) in inline `<style>` blocks because CSS files can't resolve `BASE_URL`. The `variables.css` also has relative-path `@font-face` as fallback.

## Important Gotchas

- `BASE_URL` differs between environments (`/Alex2/` vs `/`). Always use `<?= BASE_URL ?>` for asset/link paths in PHP files, never hardcode.
- The root `.htaccess` has `RewriteBase /Alex2/` — production uses a different `.htaccess-production` with `RewriteBase /`.
- `header.php` and `footer.php` are included in `<body>`, not `<head>`. They contain their own `<style>` blocks for font declarations.
- `animation.php` is a standalone page (no header/footer includes) — it needs its own `@font-face` declarations.
- PHPMailer is bundled directly in `public/pages/PHPMailer-master/` (not via Composer).
- Secrets (SMTP, admin credentials) are in `public/pages/.env`, loaded by `config/env.php`.
