# AGENTS.md

This file provides guidance to the AI agent when working with code in this repository.

## Project Overview

CakePHP 5.4.x academic management system (TCC/internship tracking) for a Brazilian university. Portuguese-language UI and flash messages.

## Commands

- **Run tests:** `vendor/bin/phpunit --colors=always`
- **Code style check:** `composer cs-check` (CakePHP coding standard)
- **Code style fix:** `composer cs-fix`
- **Syntax check:** `php -l src/Controller/FileName.php`
- **CakePHP console:** `bin/cake`
- **Bake (code gen):** `bin/cake bake`

## Architecture

- **Auth stack:** `Authentication` + `Authorization` plugins. AppController loads both components globally — do NOT re-load them in child controllers.
- **Authorization pattern:** Use `$this->Authorization->authorize($entity)` for entity-level checks, or `$this->Authorization->skipAuthorization()` for actions that don't need it. Every action MUST call one of these or CakePHP throws `AuthorizationRequiredException`.
- **Policies:** Located in `src/Policy/`. Each entity has a corresponding policy class.
- **PDF generation:** Uses `CakePdf` plugin + `dompdf`.
- **Database:** MySQL, database name `tcc.ess`, configured in `config/app_local.php`.
- **Routes:** DashedRoute convention. CSRF middleware applied globally.

## Code Style

- 4 spaces indentation, LF line endings
- CakePHP coding standard (PSR-2 based with CakePHP conventions)
- Flash messages in Portuguese: `$this->Flash->success(__('Registro inserido.'))` / `$this->Flash->error(__('...'))`
- Use `$this->fetchTable('TableName')` (not the deprecated `$this->loadModel()`)

## Common Gotchas

- `AppController::beforeFilter()` makes `index`, `view`, `busca`, `download` unauthenticated globally. Child controllers can override.
- `get($id)` throws `RecordNotFoundException` if not found — wrap in try/catch or use `find()->first()` for nullable results.
- Never authorize a null entity — check existence before calling `authorize()`.
- Don't use `$this->layout` (deprecated) — use `$this->viewBuilder()->disableAutoLayout()`.
- `WWW_ROOT` is a filesystem path, not a URL. Use `Router::url()` for URLs.
- `config/app_local.php` is gitignored and contains DB credentials — never commit it.
