# Dot.Sheet

**Dot.Sheet** is an AI-powered collaborative spreadsheet platform built on Laravel. It combines a full-featured spreadsheet engine, real-time multi-user collaboration, and deep AI integration into a single web application.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Testing](#testing)
- [Deployment](#deployment)
- [Project Structure](#project-structure)
- [AI Integration](#ai-integration)
- [Formula Engine](#formula-engine)
- [Extending Formulas](#extending-formulas)
- [Keyboard Shortcuts](#keyboard-shortcuts)
- [License](#license)

---

## Features

### Core Spreadsheet Engine
- **Sparse grid storage** — only non-empty cells are persisted, enabling efficient 1,000-row × 100-column grids
- **Virtual scrolling** — only the visible viewport is rendered for performance at scale
- **40+ built-in formula functions** — SUM, AVERAGE, COUNT, MAX, MIN, IF, CONCAT, UPPER, LOWER, ROUND, ABS, SQRT, POWER, and more
- **Formula dependency tracking** — automatic recalculation of dependent cells when a value changes; dependency graph cached in Redis
- Cell references (`A1`, `$B$2`) and ranges (`A1:A10`)
- Full operator precedence (`+`, `-`, `*`, `/`, `%`, `^`, comparison, logical)
- Keyboard navigation (arrow keys, Tab, Shift+Tab, Enter, Escape)

### Rich Formatting & Data Tools
- **Toolbar** — bold, italic, underline, strikethrough, font size, text/background color, number formats (currency, percentage, date, time)
- **Format Painter** — copy formatting from one cell and apply it to another
- **Conditional formatting** — highlight cells by rule (e.g., value > 100 → red background)
- **Data validation** — number range, text length, allowed list values
- **Sorting & filtering** — column-level sort, text/number/date/color/condition filters
- Add, delete, hide, and resize rows and columns via right-click context menu or toolbar

### Charts & Visualizations
- Powered by **Chart.js**
- Supported chart types: bar, line, pie, scatter, area, doughnut
- Select a data range, preview the chart, and save the configuration

### Import & Export
- Import **CSV** and **Excel** files (`maatwebsite/excel`)
- Export to **CSV** and **Excel**
- Large file imports are processed as background jobs with a live progress indicator

### Real-time Collaboration
- **Laravel Echo + Pusher** presence channels
- Live display of active collaborators (avatars in the top bar)
- Live cursor overlay showing each collaborator's active cell
- Full broadcast of cell updates to all viewers of a spreadsheet

### Version History
- Auto-snapshot on edits and at configurable intervals
- "Version History" modal to browse past versions
- One-click restore to any previous version

### Sharing & Permissions
- **Team-based sharing** via Jetstream Teams
- Invite external users by email with tokenized acceptance links
- Granular permission levels: **View**, **Comment**, **Edit**, **Admin**
- **Public view-only links** with optional expiration dates

### Cell Comments
- Threaded comment panels per cell
- `@mention` team members to trigger email/database notifications
- Resolve and re-open comment threads

### Macros & Scripting
- JavaScript script editor for automating repetitive tasks
- Scripts run in a sandboxed Web Worker
- Built-in macro recorder to capture and replay user actions

### AI Features
- **AI Formula Generation** — describe a formula in plain English; AI generates, previews, and inserts it
- **AI Analysis Panel** — data insights, data cleaning suggestions, chart recommendations, sentiment analysis, OCR from pasted images
- **Natural Language Queries** — type "What is the total sales for Q1?" and AI translates it into a formula or filter
- **Automated Workflows** — AI-triggered actions based on conditions (e.g., "When stock < 10, send email")
- Supports **OpenAI**, **Anthropic**, and **Ollama** (local LLM) as interchangeable providers
- Per-user rate limiting (configurable RPM/RPH) with a Redis-backed cache layer

### Authentication & Teams
- Email/password authentication via Laravel Fortify
- Two-factor authentication (TOTP)
- Team management, invitations, and role-based access via Laravel Jetstream
- API token support via Laravel Sanctum
- Profile photos, password management, browser session management

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 13 |
| Auth / Teams | Laravel Jetstream 5 + Fortify + Sanctum |
| Frontend reactivity | Livewire 3 + Alpine.js |
| Styling | Tailwind CSS 3 |
| Build tool | Vite 8 |
| Real-time | Laravel Echo + Pusher (PHP & JS SDKs) |
| Charts | Chart.js 4 |
| Import / Export | Maatwebsite Excel 3 |
| Onboarding tour | Shepherd.js |
| Queue management | Laravel Horizon |
| Cache / Queues | Redis |
| Database (dev) | SQLite |
| Database (prod) | MySQL or PostgreSQL |
| Testing | PHPUnit 12, Laravel Dusk 8 |

---

## Requirements

- PHP **8.3+** with extensions: `pdo`, `pdo_mysql` / `pdo_pgsql` / `pdo_sqlite`, `redis`, `mbstring`, `xml`, `zip`
- Composer
- Node.js **18+** and npm
- Redis (required for queues, caching, and broadcasting)
- A Pusher account **or** a self-hosted compatible server (e.g., Soketi) for real-time features
- *(Optional)* An OpenAI, Anthropic, or Ollama endpoint for AI features

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-org/dot-sheet.git
cd dot-sheet

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Copy and configure the environment file
cp .env.example .env
php artisan key:generate

# 5. Run database migrations
php artisan migrate

# 6. Build frontend assets
npm run build
```

Alternatively, the `composer setup` script performs steps 2–6 in one command:

```bash
composer run setup
```

---

## Configuration

All configuration is done via the `.env` file. Key variables:

### Application

```env
APP_NAME="Dot.Sheet"
APP_URL=http://localhost:8000
```

### Database

```env
DB_CONNECTION=sqlite          # or mysql / pgsql
DB_DATABASE=/absolute/path/to/database.sqlite
```

### Redis

```env
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

### Broadcasting (Pusher)

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=mt1
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### AI Provider

```env
# Supported: ollama | openai | anthropic
AI_PROVIDER=ollama

# Ollama (local)
OLLAMA_BASE_URL=http://localhost:11434
OLLAMA_MODEL=mistral

# OpenAI
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-3.5-turbo

# Anthropic
ANTHROPIC_API_KEY=sk-ant-...
ANTHROPIC_MODEL=claude-3-sonnet-20240229

# Rate limiting
AI_RATE_LIMIT_ENABLED=true
AI_RATE_LIMIT_RPM=60
```

---

## Running the Application

The `composer dev` script starts all required processes concurrently:

```bash
composer run dev
```

This starts:
- `php artisan serve` — application server at `http://localhost:8000`
- `php artisan queue:listen` — background job processor
- `php artisan pail` — real-time log viewer
- `npm run dev` — Vite HMR dev server

Or start services individually:

```bash
php artisan serve
php artisan queue:work --queue=default,imports
npm run dev
```

---

## Testing

```bash
# All tests
composer run test

# PHPUnit only
php artisan test

# Specific test suite
php artisan test --filter=FormulaEvaluator

# Browser tests (requires Dusk)
php artisan dusk
```

Key test locations:

| Path | Coverage |
|---|---|
| `tests/Unit/FormulaEvaluatorServiceTest.php` | Formula functions, cell refs, dependency graph |
| `tests/Feature/SpreadsheetCoreOperationsTest.php` | Create / update / delete cells, sharing |
| `tests/Browser/` | Critical user journeys via Laravel Dusk |

Load testing scripts are available in `scripts/run-load-test.sh` and documented in [docs/load-testing.md](docs/load-testing.md).

---

## Deployment

See the full [Deployment Runbook](docs/deployment-runbook.md). Summary:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
sudo supervisorctl restart dotsheet-horizon:*
sudo supervisorctl restart dotsheet-queue:*
```

Supervisor configuration examples for Horizon and queue workers are in `deploy/supervisor/`.

**Backups** — run manually or via cron:

```bash
php artisan ops:backup
# or
./scripts/run-backup.sh
```

Backups are stored in `storage/app/backups/<timestamp>/`. Configure retention with `BACKUP_RETENTION_DAYS` in `.env`.

---

## Project Structure

```
app/
  Http/Controllers/        # SpreadsheetController and other HTTP controllers
  Livewire/                # Livewire components
    ShowSpreadsheet.php      # Main grid engine
    AiAnalysisPanel.php      # AI sidebar (Insights / Cleaning / Charts)
    AiFormulaModal.php       # AI formula generation modal
    AiNaturalLanguageQuery.php
    CellCommentsPanel.php
    ChartBuilder.php
    ScriptsEditor.php
    SpreadsheetSharingPanel.php
    SpreadsheetToolbar.php
    VersionHistoryModal.php
  Models/                  # Eloquent models (Spreadsheet, Cell, CellHistory, …)
  Services/
    AiService.php            # Unified AI provider client (OpenAI / Anthropic / Ollama)
    FormulaEvaluatorService.php  # PHP-side formula engine
    SpreadsheetImportExportService.php
  Events/                  # Broadcasting events (CellUpdated, CursorMoved)
  Jobs/                    # Queue jobs (BulkPasteChunkJob, ImportRowsChunkJob, …)
  Notifications/           # Database / email notifications (@mentions, invitations)
resources/
  js/
    formula-parser.js        # Client-side formula parser (40+ functions)
  views/
    livewire/                # Blade templates for Livewire components
    spreadsheets/            # Spreadsheet list and create views
database/
  migrations/              # All schema migrations
docs/
  user-guide.md
  developer-formula-extension.md
  deployment-runbook.md
  load-testing.md
  redis-horizon-checklist.md
```

---

## AI Integration

Dot.Sheet routes AI requests through a single `AiService` class that supports three interchangeable providers:

| Provider | Use Case |
|---|---|
| **Ollama** | Self-hosted / air-gapped environments |
| **OpenAI** | Cloud-hosted with GPT models |
| **Anthropic** | Cloud-hosted with Claude models |

Set `AI_PROVIDER` in `.env` to switch providers with no code changes.

AI interactions are logged to the `ai_prompts` table for audit, debugging, and result re-use. Per-user rate limiting is enforced via a Redis counter before any external API call is made.

---

## Formula Engine

The formula engine has two layers:

- **Client-side** (`resources/js/formula-parser.js`) — parses and evaluates formulas instantly in the browser for a responsive feel
- **Server-side** (`app/Services/FormulaEvaluatorService.php`) — validates and re-evaluates on save, builds the dependency graph, and caches results in Redis

Supported categories of functions:

| Category | Functions |
|---|---|
| Math | `SUM`, `AVERAGE`, `COUNT`, `MAX`, `MIN`, `ROUND`, `ABS`, `SQRT`, `POWER`, `MOD` |
| Logic | `IF`, `AND`, `OR`, `NOT`, `IFERROR` |
| Text | `CONCAT`, `UPPER`, `LOWER`, `LEN`, `TRIM`, `LEFT`, `RIGHT`, `MID` |
| Date/Time | `NOW`, `TODAY`, `DATE`, `YEAR`, `MONTH`, `DAY` |
| Lookup | `VLOOKUP`, `HLOOKUP`, `INDEX`, `MATCH` |

Cell references support both relative (`A1`) and absolute (`$A$1`) notation. Range references (`A1:C10`) are expanded with a safety limit of 5,000 cells.

---

## Extending Formulas

To add a new function to the PHP evaluator:

1. Open `app/Services/FormulaEvaluatorService.php` and locate `evaluateExpression()`.
2. Add a case to the `match ($funcName)` block, evaluating arguments recursively.
3. Add a helper method for the implementation.

Example — adding `MEDIAN`:

```php
'MEDIAN' => $this->median(array_map(fn($a) => $this->evaluateExpression($a), $args)),
```

```php
protected function median(array $values): float
{
    sort($values);
    $count = count($values);
    if ($count === 0) return 0.0;
    $mid = intdiv($count, 2);
    return $count % 2 === 1
        ? (float) $values[$mid]
        : ((float) $values[$mid - 1] + (float) $values[$mid]) / 2;
}
```

Mirror the same function name in `resources/js/formula-parser.js` for client-side parity.

See the full guide in [docs/developer-formula-extension.md](docs/developer-formula-extension.md).

---

## Keyboard Shortcuts

| Shortcut | Action |
|---|---|
| Arrow keys | Move selection |
| Enter | Commit edit / move down |
| Escape | Cancel edit |
| Tab / Shift+Tab | Move right / left |
| Double-click | Enter edit mode |
| Ctrl/Cmd + S | Save cell |
| Ctrl/Cmd + C | Copy cell value |
| Ctrl/Cmd + V | Paste |
| Ctrl/Cmd + Z | Undo |
| Ctrl/Cmd + Y | Redo |
| Ctrl/Cmd + F | Focus formula bar |

A full shortcuts reference is available inside the app via the "Keyboard Shortcuts" help modal.

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
