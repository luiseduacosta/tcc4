---
kind: error_handling
name: CakePHP Exception Rendering and Error Templates
category: error_handling
scope:
    - '**'
source_files:
    - src/Controller/ErrorController.php
    - templates/Error/error400.php
    - templates/Error/error500.php
    - templates/layout/error.php
    - templates/element/flash/error.php
    - config/app.php
---

## System/Approach

This CakePHP 5 application uses the framework's built-in exception handling pipeline. Uncaught exceptions are rendered by `Cake\Error\Renderer\WebExceptionRenderer` (configured in `config/app.php`) and dispatched to a dedicated `App\Controller\ErrorController`, which sets the template path to `templates/Error/`. The app relies on CakePHP's HTTP exception hierarchy (`NotFoundException`, `ForbiddenException`, etc.) rather than defining custom domain error types.

## Key Files

- `src/Controller/ErrorController.php` — overrides `beforeRender()` to force `viewBuilder()->setTemplatePath('Error')`, ensuring all errors render from the `templates/Error/` directory.
- `templates/Error/error400.php` — renders 4xx client errors; switches to the `dev_error` layout when `Configure::read('debug')` is true, surfacing SQL query strings and parameters via `$error->queryString` / `$error->params`.
- `templates/Error/error500.php` — renders 5xx server errors; similarly augments output with file/line info when `$error instanceof Error`.
- `templates/layout/error.php` — shared error layout that includes `cake.css`, renders flash messages via `$this->Flash->render()`, and provides a "Back" link.
- `templates/element/flash/error.php` — Bootstrap-styled danger badge for user-facing error flash messages.
- `config/app.php` — `Error` section configures `exceptionRenderer => WebExceptionRenderer::class`, `log => true`, `trace => true`, `errorLevel => E_ALL`; `Log.error` writes to `LOGS . DS . 'error'`.
- `logs/error.log` — runtime log file where logged exceptions are persisted.

## Architecture and Conventions

1. **Centralized rendering**: All exceptions funnel through `ErrorController`, which deliberately omits `parent::initialize()` so authentication/session middleware in `AppController` cannot interfere with error pages.
2. **Debug-driven detail**: Both `error400.php` and `error500.php` conditionally switch to the `dev_error` layout and expose raw SQL/query data only when `debug` is enabled, keeping production responses minimal.
3. **HTTP exceptions over throwables**: Controllers raise CakePHP HTTP exceptions (`ForbiddenException`, `NotFoundException`) instead of generic PHP exceptions or sentinel values; these map automatically to 403/404 status codes.
4. **User-facing vs. system errors**: User-visible failures use `$this->Flash->error($msg)` (rendered by `templates/element/flash/error.php`); unrecoverable failures are thrown as exceptions and logged via the configured `Log.error` channel.
5. **No custom exception classes**: The codebase does not define application-specific exception types; it reuses CakePHP's built-in exception hierarchy.
6. **No global try/catch blocks**: There are no application-wide try/catch wrappers around controllers; error propagation relies on CakePHP's dispatcher to catch unhandled exceptions.
7. **CLI logging**: Separate `cli-debug.log` and `cli-error.log` files exist under `logs/`, indicating CLI error paths are handled by CakePHP's console error handler rather than this web pipeline.

## Conventions and Constraints

- Error templates must live under `templates/Error/` and accept the standard variables `$message`, `$url`, `$code`, `$error`, and `$exception` provided by `WebExceptionRenderer`.
- When `debug` is false, error templates intentionally hide stack traces and SQL details; adding such details to production error views would leak sensitive information.
- Flash messages are the prescribed way to communicate recoverable errors back to users after redirects; they are rendered via the `Flash` element and styled with Bootstrap utility classes.
- Logging is always-on for errors (`'log' => true`), so any non-HTTP-exception throwable will be written to `logs/error.log` regardless of whether it is rendered.