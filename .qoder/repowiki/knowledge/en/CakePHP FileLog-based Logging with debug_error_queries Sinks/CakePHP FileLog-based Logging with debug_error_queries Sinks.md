---
kind: logging_system
name: CakePHP FileLog-based Logging with debug/error/queries Sinks
category: logging_system
scope:
    - '**'
source_files:
    - config/app.php
    - config/bootstrap.php
    - src/Command/ConsoleCommand.php
---

## What system/approach is used

The application uses **CakePHP's built-in logging subsystem** (`Cake\Log\Log`) backed by the `Cake\Log\Engine\FileLog` engine. There is no third-party logger (Monolog, PSR-3 wrapper, etc.) — all log output is routed through CakePHP's Log facade into file sinks under the `logs/` directory.

## Key files and packages

- `config/app.php` — defines the `Log` configuration array with three named sinks: `debug`, `error`, and `queries`.
- `config/bootstrap.php` — line 169 calls `Log::setConfig(Configure::consume("Log"))` to register the configured sinks at bootstrap time.
- `src/Command/ConsoleCommand.php` — drops the default `debug` and `error` sinks before launching a Psy\Shell REPL so interactive debugging does not pollute log files.
- `logs/` directory — runtime log files produced by the sinks:
  - `debug.log` — debug/info/notice messages
  - `error.log` — warning/error/critical/alert/emergency messages
  - `cli-debug.log`, `cli-error.log` — CLI-specific log outputs
  - `error.log.<timestamp>` — rotated error logs

## Architecture and conventions

### Sink configuration
Three sinks are registered in `config/app.php`:

| Sink name | Engine | File | Levels |
|---|---|---|---|
| `debug` | `FileLog` | `LOGS/debug` | `notice`, `info`, `debug` |
| `error` | `FileLog` | `LOGS/error` | `warning`, `error`, `critical`, `alert`, `emergency` |
| `queries` | `FileLog` | `LOGS/queries` | scoped to `queriesLog` only |

Each sink supports an optional `url` key read from environment variables (`LOG_DEBUG_URL`, `LOG_ERROR_URL`, `LOG_QUERIES_URL`), allowing the same config to be extended via `app_local.php` or env overrides without changing source code.

### Error/exception integration
The `Error` config block sets `'log' => true` and `'trace' => true`, meaning uncaught exceptions and PHP errors are automatically captured by the configured log sinks with full stack traces. The `WebExceptionRenderer` renders web exceptions; in CLI mode an `ErrorTrap` is registered instead of an `ExceptionTrap`.

### Query logging
Database query logging is disabled by default (`Datasources.default.log = false`). To enable it, set the datasource `log` flag to `true`; queries will then be emitted on the `queriesLog` scope and written to `logs/queries`. A comment in `config/app.php` explicitly documents this opt-in behavior.

### CLI vs web separation
In `src/Command/ConsoleCommand.php`, the command drops the `debug` and `error` sinks and disables console loggers (`$io->setLoggers(false)`) before starting the Psy\Shell REPL. This prevents interactive shell sessions from writing to the standard log files, keeping REPL output separate.

### Environment-driven behavior
- `debug` mode (from `env('DEBUG')`) controls whether framework errors are displayed in-browser; when `debug` is false, errors are coerced into generic HTTP responses but still logged.
- Per-sink `url` keys allow swapping file sinks for alternate destinations (e.g., syslog, remote endpoint) purely via configuration.

## Conventions and constraints

- **All logging goes through `Cake\Log\Log`** — there are no direct `file_put_contents` or `error_log` calls observed in application code; the project relies on the framework's centralized logger.
- **Two-tier level split**: routine operational messages use the `debug` sink (levels `notice`/`info`/`debug`); anything that indicates a problem uses the `error` sink (levels `warning`+). No custom levels are defined.
- **Structured fields / scopes**: the `queries` sink demonstrates the use of the `scopes` key to restrict a sink to a specific scope (`queriesLog`). Application code can emit additional scoped logs via `Log::write($level, $message, ['scope' => '...'])` if needed.
- **No per-request/request-id correlation** is implemented in this repo — logs do not include request IDs or user context beyond what the caller passes.
- **Log rotation** is not handled by CakePHP itself; rotated files like `error.log.1744058124` suggest an external process (OS logrotate or similar) handles rotation.
- **Environment overrides live in `app_local.php`** (loaded conditionally in `bootstrap.php`), which is the intended place to adjust log paths, URLs, or levels per deployment without touching version-controlled config.