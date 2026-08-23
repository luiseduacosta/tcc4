---
kind: frontend_style
name: 'CakePHP App Styling: Bootstrap 5 + Foundation + Custom Theme'
category: frontend_style
scope:
    - '**'
source_files:
    - templates/layout/default.php
    - webroot/css/style.css
    - webroot/css/base.css
    - webroot/css/home.css
    - webroot/css/cake.css
    - webroot/css/jquery.autocomplete.css
    - webroot/js/bootstrap.bundle.min.js
    - webroot/js/jquery-3.6.0.js
    - webroot/js/jquery.mask.min.js
    - webroot/img/logoess_horizontal-azul.svg
---

## What system/approach is used

The frontend styling of this CakePHP 5 application is a **hybrid, CDN-based approach** that layers multiple CSS frameworks and custom overrides:

- **Bootstrap 5.3.5** (via jsDelivr CDN) provides the primary grid, components, and utility classes.
- **Bootstrap Icons 1.10.5** are loaded for iconography.
- **Normalize.css 8.0.1** (CDN) resets browser defaults.
- A local copy of **Foundation 5** (`base.css`) remains in `webroot/css/` — it is no longer linked from the layout but still present as legacy asset.
- The project's own theme lives in `webroot/css/style.css`, which heavily overrides Foundation/CakePHP-generated markup (`.side-nav`, `.top-bar`, `.actions.columns`, `.view .columns.*`, pagination, forms, flash messages).
- Additional local CSS files: `home.css`, `cake.css`, `jquery.autocomplete.css`; a minified `milligram.min.css` is also vendored but commented out in the layout.
- JavaScript assets (jQuery 3.x, Bootstrap bundle, Popper, jQuery Mask, Autocomplete) are loaded via CDN or vendored under `webroot/js/`.
- CKEditor 5 is integrated via CDN with an import map.

There is **no build step, preprocessor (Sass/Less), or design-token system**. Styles are plain CSS files served directly from `webroot/css/`.

## Key files and packages

- `templates/layout/default.php` — single HTML layout; links Bootstrap 5, Normalize, and fetches per-page `<link>` blocks via `$this->fetch('css')`.
- `webroot/css/style.css` — application-specific theme (~526 lines): header colors (`#D33C44` red, `#1798A5` teal), form/error/message styling, table/pagination overrides, responsive tweaks via `@media(max-width: 640px)`.
- `webroot/css/base.css` — vendored Foundation 5 source (large, mostly unused now).
- `webroot/css/home.css`, `webroot/css/cake.css`, `webroot/css/jquery.autocomplete.css` — small domain-specific styles.
- `webroot/css/bootstrap.min.css` — vendored Bootstrap minified (unused; layout pulls from CDN instead).
- `webroot/js/` — jQuery, Bootstrap bundle, Popper, jQuery Mask, Autocomplete.
- `webroot/img/logoess_horizontal-azul.svg` — UFRJ branding asset.

## Architecture and conventions

- **Single layout, global stylesheet injection**: `default.php` defines the page shell and exposes `fetch('css')` / `fetch('script')` blocks so individual templates can append their own styles/scripts without duplicating boilerplate.
- **CDN-first dependencies**: Bootstrap, Normalize, Bootstrap Icons, jQuery, CKEditor 5, and jQuery Mask are all pulled from CDNs at render time; only small utilities remain vendored locally.
- **Legacy Foundation overrides**: `style.css` targets Foundation class names (`.side-nav`, `.top-bar`, `.top-bar-section`, `.small-*` breakpoints) even though the active layout loads Bootstrap. This suggests the app was migrated from a Foundation-based CakePHP skeleton and the old CSS has not been fully purged.
- **Hardcoded color palette** in `style.css`: primary teal `#1798A5` / `#15848F`, header red `#D33C44`, error red `#C3232D`, success green, yellow highlight `#DCE47E`, brown accent `#8D6E65`, orange button hover `#BE840B`. These are repeated inline rather than centralized into CSS variables.
- **Responsive strategy**: minimal — one media query at `max-width: 640px` in `style.css` plus reliance on Bootstrap's built-in responsive grid.
- **No component library beyond Bootstrap**: reusable UI fragments live as CakePHP elements under `templates/element/` (e.g., `paginator.php`, `menu_monografias.php`, `flash/*`), styled by the same flat CSS files.

## Conventions and constraints

- **All public static assets must be placed under `webroot/`** (enforced by web server routing through `webroot/index.php`).
- **Per-page styles go into the template's `css` block**, not duplicated in the layout (convention enforced by the `$this->fetch('css')` pattern in `default.php`).
- **Templates should not embed raw `<style>` tags**; they extend the layout and rely on the global stylesheet stack.
- **Third-party libraries are preferred from CDN** (see layout comments showing both CDN and local paths, with CDN currently active). Vendoring is reserved for small, stable utilities.
- **No Sass/Less/PostCSS pipeline exists** — changes are made directly to `.css` files under `webroot/css/`.
- **Design tokens are not formalized**: colors, spacing, and typography are hardcoded hex values scattered across `style.css`; there is no central token file or CSS custom properties convention observed.