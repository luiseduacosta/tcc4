---
kind: dependency_management
name: Composer-based PHP Dependency Management for CakePHP 5 Application
category: dependency_management
scope:
    - '**'
source_files:
    - composer.json
    - composer.lock
---

## System/Approach

This repository uses **Composer** as its sole dependency manager for PHP packages. It is a standard CakePHP 5 skeleton application (`cakephp/app`) that declares all third-party libraries in `composer.json` and pins exact versions via the generated `composer.lock`. Dependencies are resolved from Packagist (the default public Composer registry) and installed into the `vendor/` directory, which is empty in this snapshot because the lockfile alone captures the dependency graph.

## Key Files

- `composer.json` — Declares runtime dependencies (`require`), development-only dependencies (`require-dev`), PSR-4 autoload mappings for `App\`, dev autoloads for tests, Composer scripts (`check`, `cs-check`, `cs-fix`, `stan`, `test`), and Composer config options.
- `composer.lock` — Generated lockfile that pins every transitive dependency to an exact version and source commit hash; it is committed to the repository so deployments reproduce the same dependency tree.
- `vendor/` — The Composer vendor directory where packages are installed; currently empty in this snapshot but populated by `composer install` using the lockfile.
- `config/.env.example` / `config/app_local.php` — Environment-specific overrides loaded at bootstrap; not dependency manifests but part of the deployment-time configuration surface.

## Architecture and Conventions

- **Framework baseline**: The project depends on `cakephp/cakephp ^5.0`, with `php >=8.1` declared as a hard requirement. Core CakePHP ecosystem packages (`authentication ^3.0`, `authorization ^3.0`, `migrations ^4.0`, `debug_kit ^5.0`, `bake ^3.0`) are pinned to compatible major versions.
- **Runtime vs dev split**: Runtime-only packages (`dompdf/dompdf`, `friendsofcake/cakepdf`, `mobiledetect/mobiledetectlib`) live under `require`; tooling and test frameworks (`phpunit/phpunit ^10.1`, `phpstan/phpstan ^2.1`, `cakedc/cakephp-phpstan ^4.2`, `cakephp/cakephp-codesniffer ^5.0`, `psy/psysh @stable`) live under `require-dev`.
- **Autoloading**: PSR-4 autoloading maps `App\` to `src/` and `App\Test\` to `tests/`. A special mapping `Cake\Test\` points to `vendor/cakephp/cakephp/tests/` so the bundled CakePHP test fixtures can be autoloaded.
- **Scripts as workflow glue**: Composer scripts wrap the project's quality gates — `@check` runs both `@test` and `@cs-check`; `@cs-fix` invokes `phpcbf`; `@stan` runs PHPStan over `src/`.
- **Stability policy**: `minimum-stability` is set to `dev` while `prefer-stable: true` is enabled, meaning stable releases are preferred unless explicitly overridden (e.g., `psy/psysh @stable`).
- **Package ordering**: `sort-packages: true` in Composer config keeps `composer.json` entries alphabetically sorted automatically.

## Conventions and Constraints

- **Lockfile is authoritative**: `composer.lock` is committed and should be the single source of truth for reproducible installs; running `composer install` without updating `composer.json` will not change versions.
- **No vendoring or private registries**: There is no custom `repositories` entry, no `COMPOSER_AUTH` token usage, and no private package mirror configured — all packages come from Packagist.
- **Plugin allowlist**: Only `dealerdirect/phpcodesniffer-composer-installer` is explicitly allowed via `allow-plugins`; other plugins must be approved before installation.
- **Environment variables**: The `josegonzalez/dotenv` package is included in dev dependencies, indicating environment-driven configuration loading via `.env` files (with `config/.env.example` as the template).
- **PHP version gate**: The `php >=8.1` constraint in `composer.json` enforces the minimum PHP runtime required by the dependency graph.
- **Testing integration**: PHPUnit 10.x is the enforced testing framework, invoked through the `@test` Composer script with color output enabled.