---
kind: build_system
name: Composer-based PHP Build, Test & Static Analysis for CakePHP 5 App
category: build_system
scope:
    - '**'
source_files:
    - composer.json
    - composer.lock
    - phpunit.xml.dist
    - phpstan.neon
    - bin/cake.php
    - bin/cake.bat
    - webroot/index.php
    - config/.env.example
    - config/app_local.example.php
    - tests/bootstrap.php
---

## What system/approach is used

This repository is a standard **CakePHP 5** application whose build and quality pipeline is driven entirely by **Composer** scripts. There are no Makefiles, Dockerfiles, shell build scripts, or CI configuration files in the repository. The project relies on Composer's `scripts` section to orchestrate testing, code style checks, and static analysis, and uses the standard CakePHP CLI (`bin/cake`) for runtime tasks.

## Key files and packages

- `composer.json` — declares dependencies (CakePHP 5, authentication/authorization, migrations, dompdf/CakePdf), dev tools (phpunit 10, phpstan 2, cakephp-codesniffer, bake, debug_kit), PSR-4 autoload mappings (`App\` → `src/`, `App\Test\` → `tests/`), and the script surface.
- `composer.lock` — pins exact dependency versions; `sort-packages: true` keeps it deterministic.
- `phpunit.xml.dist` — PHPUnit 10 config: bootstrap at `tests/bootstrap.php`, test suite under `tests/TestCase/`, source include/exclude rules, `.phpunit.cache` cache directory, memory limit disabled, APC enabled for CLI.
- `phpstan.neon` — PHPStan level 5 analysis over `src/`, includes `cakedc/cakephp-phpstan` extension, bootstraps via `config/bootstrap.php`, and contains a long list of `ignoreErrors` tuned for CakePHP 5 dynamic properties, magic entity access, and controller return-type conventions.
- `bin/cake` / `bin/cake.bat` / `bin/cake.php` — CakePHP console entry points used for baking, migrations, and custom commands (e.g. `src/Console/Installer.php`).
- `webroot/index.php` — public front controller that serves static assets and routes all HTTP requests into the CakePHP application.
- `config/.env.example` / `config/app_local.example.php` — environment and per-environment overrides loaded at runtime (no build-time env expansion).

## Architecture and conventions

- **Dependency management**: All third-party packages are managed through Composer with `minimum-stability: dev` and `prefer-stable: true`. Runtime deps pin major versions (`^5.0`, `^3.0`, `^4.0`, `^3.1`, `^4.8`); dev deps similarly use caret ranges.
- **Build surface**: The entire build/test workflow is exposed as Composer scripts:
  - `composer check` — runs both tests and code-style checks.
  - `composer test` — executes `phpunit --colors=always`.
  - `composer cs-check` — runs `phpcs` against `src/` and `tests/` using the `CakePHP` standard from `cakephp/cakephp-codesniffer`.
  - `composer cs-fix` — auto-fixes style violations via `phpcbf`.
  - `composer stan` — runs `phpstan analyse src/`.
  - `post-install-cmd` / `post-create-project-cmd` — invoke `App\Console\Installer::postInstall` to perform post-install setup.
- **Testing**: PHPUnit 10 is the test runner. Tests live under `tests/TestCase/` (controllers, models/Table) with fixtures under `tests/Fixture/`. Coverage excludes `src/Console/Installer.php`.
- **Static analysis**: PHPStan at level 5 with the CakePHP-specific extension; many CakePHP-specific false positives are suppressed via `ignoreErrors` rather than refactored.
- **Code style**: Enforced via `cakephp/cakephp-codesniffer` with the `CakePHP` coding standard.
- **CLI**: Application-specific console commands live under `src/Command/` and `src/Console/`; the installer handles post-install wiring.
- **Deployment model**: No containerization or packaging step exists. Deployment is expected to be a plain PHP deployment where `vendor/` is installed via Composer and `webroot/` is served by a web server (Apache/Nginx). Database schema lives in `config/Migrations/schema.sql` and `tccess.sql`.

## Conventions and constraints

- **PHP version**: Requires `php >= 8.1` (enforced by Composer constraint in `composer.json`).
- **Autoloading**: PSR-4 only — `App\` maps to `src/`, `App\Test\` maps to `tests/`; no classmap or legacy autoloading.
- **Package sorting**: `composer config sort-packages: true` enforces alphabetically sorted dependency lists in `composer.json`.
- **Plugin allowlist**: Only `dealerdirect/phpcodesniffer-composer-installer` is explicitly allowed via `allow-plugins`.
- **Test isolation**: `processIsolation: false` and `stopOnFailure: false` in PHPUnit config — tests run in-process and do not abort on first failure.
- **Source coverage scope**: Only `src/` and `plugins/*/src/` are included in coverage; `src/Console/Installer.php` is excluded.
- **No CI/build artifacts**: There is no `.github/`, `.gitlab-ci.yml`, `Dockerfile`, `Makefile`, or build script committed to the repo; any CI would need to be added externally.
- **Database**: Schema is maintained via SQL files (`config/Migrations/schema.sql`, `config/schema/*.sql`, `tccess.sql`) and the `cakephp/migrations` package; no ORM-level migration definitions were found in this snapshot.