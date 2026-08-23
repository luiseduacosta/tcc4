---
kind: external_dependency
name: CakePHP 5.x Framework
slug: cakephp-5
category: external_dependency
category_hints:
    - framework_behavior
scope:
    - '**'
---

- The application is a CakePHP 5 skeleton (`cakephp/cakephp ^5.0`) with the standard MVC layout under `src/` (Model/Table, Model/Entity, Controller, Policy) and views under `templates/`.
- ORM configuration lives in `config/app.php` (driver: MySQL via `Cake\Database\Driver\Mysql`, file-based cache engines for `_cake_model_`, `_cake_routes_`, `_cake_translations_`).
- Authentication/Authorization are provided by `cakephp/authentication ^3.0` and `cakephp/authorization ^3.0`; policies under `src/Policy/*Policy.php` gate access per entity.
- Migrations use `cakephp/migrations ^4.0` with DDL stored in `config/Migrations/schema.sql` (and `config/schema/*.sql` for i18n/sessions).
- PDF generation uses `dompdf/dompdf ^3.1` together with `friendsofcake/cakepdf ^5.0` to render CakePHP views as PDFs.
- Mobile detection is handled by `mobiledetect/mobiledetectlib ^4.8`.
- Development tooling: `cakephp/debug_kit ^5.0`, `cakephp/bake ^3.0`, `phpstan/phpstan ^2.1` with `cakedc/cakephp-phpstan ^4.2`, `psy/psysh`, PHPUnit 10.