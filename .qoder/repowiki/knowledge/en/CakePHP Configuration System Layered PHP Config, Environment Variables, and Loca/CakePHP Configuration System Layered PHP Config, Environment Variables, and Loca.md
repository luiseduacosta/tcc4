---
kind: configuration_system
name: 'CakePHP Configuration System: Layered PHP Config, Environment Variables, and Local Overrides'
category: configuration_system
scope:
    - '**'
source_files:
    - config/bootstrap.php
    - config/app.php
    - config/app_local.php
    - config/app_local.example.php
    - config/paths.php
    - config/bootstrap_cli.php
    - config/.env.example
    - config/routes.php
    - config/inflections.php
    - config/requirements.php
---

## What system/approach is used

This CakePHP 5 application uses the framework's built-in configuration subsystem (`Cake\Core\Configure`) with a layered approach:
- **Base configuration** in `config/app.php` defines all default settings (App, Security, Cache, Datasources, Email, Log, Session).
- **Local overrides** via `config/app_local.php`, loaded conditionally after `app.php` to allow per-environment secrets without committing credentials.
- **Environment variables** via PHP's `env()` function throughout config files for secrets like `SECURITY_SALT`, `DATABASE_URL`, `EMAIL_TRANSPORT_DEFAULT_URL`, `LOG_*_URL`, `CACHE_*_URL`, `DEBUG`, `APP_*`.
- **Optional `.env` file loading** — the bootstrap contains commented-out code using `josegonzalez/Dotenv` to load `config/.env` into the environment during development; an example template exists at `config/.env.example`.
- **CLI-specific bootstrap** via `config/bootstrap_cli.php` that adjusts logging file names so CLI logs don't conflict with web logs.

## Key files and packages

- `config/paths.php` — Defines path constants (`ROOT`, `CONFIG`, `WWW_ROOT`, `TMP`, `LOGS`, `CACHE`, `RESOURCES`, `CORE_PATH`, `CAKE`).
- `config/bootstrap.php` — Loads paths, bootstraps CakePHP core, registers `PhpConfig` engine, loads `app` then `app_local`, applies debug-time cache duration overrides, sets timezone/locale, registers error/exception traps, includes CLI bootstrap, wires `Cache`, `ConnectionManager`, `TransportFactory`, `Mailer`, `Log`, `Security` from `Configure::consume(...)`.
- `config/app.php` — Master configuration array returned as a PHP file; keys include `App`, `Security`, `Cache`, `Error`, `EmailTransport`, `Email`, `Datasources`, `Log`, `Session`.
- `config/app_local.php` — Per-installation override file containing DB credentials, test DB, email transport defaults, and a local `SECURITY_SALT`.
- `config/app_local.example.php` — Template for new installations.
- `config/bootstrap_cli.php` — CLI-only adjustments (separate log files `cli-debug.log`, `cli-error.log`).
- `config/routes.php`, `config/inflections.php`, `config/requirements.php` — Additional non-data configuration.
- `config/.env.example` — Template of environment variables supported by the app.
- `config/schema/sessions.sql` — Schema for database-backed sessions.

## Architecture and conventions

1. **Layered loading order**: `bootstrap.php` calls `Configure::load("app", "default", false)`, then conditionally loads `app_local.php`. Because `app_local.php` is loaded second, its values override those in `app.php` for any matching keys.
2. **Environment-first for secrets**: Sensitive or deployment-varying values are read through `env('KEY', default)` inside both `app.php` and `app_local.php` (e.g., `DATABASE_URL`, `EMAIL_TRANSPORT_DEFAULT_URL`, `LOG_DEBUG_URL`, `CACHE_*_URL`, `SECURITY_SALT`, `DEBUG`).
3. **Configuration consumption pattern**: After loading, `bootstrap.php` calls `Configure::consume("Cache")`, `"Datasources"`, `"EmailTransport"`, `"Email"`, `"Log"` and passes each result to the corresponding CakePHP service (`Cache::setConfig`, `ConnectionManager::setConfig`, `TransportFactory::setConfig`, `Mailer::setConfig`, `Log::setConfig`). The `Security.salt` value is consumed separately via `Security::setSalt(Configure::consume("Security.salt"))`.
4. **Debug-aware cache durations**: When `debug` is true, `bootstrap.php` rewrites `_cake_model_`, `_cake_translations_`, and `_cake_routes_` durations to short-lived values (`+2 minutes`, `+2 seconds`) so schema/route changes are picked up quickly.
5. **Separate CLI vs web logging**: `bootstrap_cli.php` writes CLI logs to `logs/cli-debug.log` and `logs/cli-error.log` instead of the web `debug.log` / `error.log`, avoiding permission conflicts.
6. **Path constants centralization**: All filesystem paths go through constants defined in `paths.php` (`ROOT`, `CONFIG`, `WWW_ROOT`, `LOGS`, `CACHE`, `RESOURCES`, `TMP`), never hard-coded strings.
7. **i18n/timezone convention**: Despite reading `App.defaultTimezone` from config, bootstrap later hard-calls `date_default_timezone_set("America/Sao_Paulo")` and sets locale to `pt_BR`, overriding the configured UTC default.
8. **PDF generation config**: `CakePdf` configuration is written directly via `Configure::write("CakePdf", [...])` in bootstrap rather than via a config file.
9. **Inflection rules for Portuguese**: Custom singular/plural/irregular inflection rules are registered in bootstrap to support Portuguese domain terms (e.g., `administrador` → `administradores`, `professor` → `professores`).

## Conventions and constraints

- **Never commit `app_local.php` with real secrets**: Both `app_local.php` and `app_local.example.php` contain comments stating it should not be included in version control; the actual `app_local.php` on disk contains hardcoded DB credentials (`root/root/ess_apps`) which violates this convention but follows the intended pattern.
- **Use `env()` for every deployment-sensitive value**: Database URLs, email transport URLs, log URLs, cache URLs, security salt, debug flag, and app encoding/locale all use `env()` with sensible defaults.
- **Keep base config immutable in `app.php`**: Only defaults belong there; per-environment overrides go in `app_local.php` or environment variables.
- **CLI bootstrap is separate**: Any CLI-specific configuration belongs in `bootstrap_cli.php`, which is only required when `PHP_SAPI === 'cli'`.
- **Cache engines use file-based storage by default**: All `_cake_*` caches use `FileEngine` under `tmp/cache`, with prefixes like `myapp_cake_core_`, `myapp_cake_model_`, `myapp_cake_routes_`.
- **Sessions use PHP defaults**: `Session.defaults` is set to `'php'`, meaning session data lives in PHP's default session storage unless overridden.
- **Database connections**: Default connection uses MySQL driver (`Cake\Database\Driver\Mysql`); test connection targets database `tccess` with `SET FOREIGN_KEY_CHECKS=0` initialization.
- **Logging destinations**: Debug/info/debug go to `logs/debug.log`, warnings/critical/etc. go to `logs/error.log`, query logs go to `logs/queries.log`; CLI variants go to `logs/cli-debug.log` and `logs/cli-error.log`.