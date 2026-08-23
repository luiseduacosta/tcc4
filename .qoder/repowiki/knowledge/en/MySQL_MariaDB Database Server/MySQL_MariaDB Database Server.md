---
kind: external_dependency
name: MySQL/MariaDB Database Server
slug: mysql-mariadb
category: external_dependency
category_hints:
    - client_constraint
scope:
    - '**'
---

- Runtime database is MySQL/MariaDB; the default connection targets the `ess_apps` database on `localhost` (configured in `config/app_local.php`), while the test suite connects to a separate `tccess` database with foreign key checks disabled during init.
- Session storage uses PHP's built-in handler (`Session.defaults = 'php'`); the bundled `config/schema/sessions.sql` is available if switching to DB sessions.
- Note: the SQL dump files (`config/Migrations/schema.sql`, `tccess.sql`) are known to diverge from the live schema — do not treat them as authoritative source of truth for column names or table structure.