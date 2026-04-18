# Dot.Sheet

<p align="center">
  <img src="dot_sheet.png" alt="Dot.Sheet Logo" width="220" />
</p>

<p align="center">
  <strong>AI-powered collaborative spreadsheets built with Laravel, Livewire, and Tailwind.</strong>
</p>

Dot.Sheet combines a full spreadsheet engine, real-time collaboration, advanced AI assistance, and production-ready operational tooling in a single web platform.

## Table of Contents

- [Overview](#overview)
- [Complete Feature Inventory](#complete-feature-inventory)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [Run the Application](#run-the-application)
- [Testing](#testing)
- [Deployment & Operations](#deployment--operations)
- [Architecture & Project Structure](#architecture--project-structure)
- [Formula Engine](#formula-engine)
- [AI System](#ai-system)
- [Documentation Index](#documentation-index)
- [Known Gaps / Backlog](#known-gaps--backlog)
- [License](#license)

## Overview

Dot.Sheet is a modern spreadsheet platform focused on:

- Large-grid performance (sparse storage + virtual scrolling)
- Multi-user collaboration with real-time updates and presence
- AI-assisted analysis, formula generation, and workflow automation
- Enterprise-ready operations (queues, monitoring, backups, load testing)

## Complete Feature Inventory

This section enumerates all implemented product features from the project task roadmap.

### 1. Foundation & Security

- Laravel Jetstream (Livewire stack) with Teams
- Laravel Fortify authentication (email/password + two-factor auth)
- Laravel Sanctum API token support
- Team and personal spreadsheet ownership model
- Spreadsheet policy-based authorization for view/comment/edit/admin
- Audit trail data model (`cell_history`, `ai_prompts`, sharing pivots)

### 2. Core Spreadsheet Engine

- Sparse grid persistence: only non-empty cells are stored
- Dynamic 1,000 x 100 spreadsheet viewport with efficient rendering
- Virtual scrolling and windowed row/column loading
- Editable cells with click/double-click editing flow
- Keyboard navigation: arrows, tab, shift+tab, enter, escape
- Formula bar + selected cell metadata/sidebar support
- Livewire-powered reactive updates and state synchronization

### 3. Formula System

- JavaScript parser/evaluator for responsive in-browser calculations
- PHP server evaluator for authoritative validation and persistence
- 40+ built-in functions across math, logic, text, date/time, and lookup
- Relative and absolute references (`A1`, `$A$1`) and ranges (`A1:C10`)
- Full expression parsing with operator precedence and nested functions
- Dependency graph recalculation on update
- Redis-backed caching for dependency/evaluation performance
- Recalculation queue support for throttled update processing

### 4. Rich Spreadsheet Tooling

- Formatting toolbar:
  - Bold, italic, underline, strikethrough
  - Font size, text color, background color
  - Number/date/time/currency/percentage formatting
  - Cell alignment
- Format Painter
- Row/column operations: add, delete, resize, hide/show
- Data validation rules (number range, text length, list options)
- Conditional formatting rules (value and condition-based styling)
- Sorting (ascending/descending)
- Filtering (text, number, date, color, condition)

### 5. Charts, Import, and Export

- Chart.js integration with interactive chart builder
- Supported chart types: bar, line, pie, scatter, area, doughnut
- Data range selection and chart preview before save
- Persisted chart configuration storage
- CSV import/export
- Excel import/export via `maatwebsite/excel`
- Background chunked import jobs with progress updates

### 6. Collaboration & Sharing

- Real-time collaboration via Laravel Echo + Pusher-compatible channels
- Presence channels with active collaborator indicators
- Live remote cursor overlays and movement updates
- Real-time cell update broadcast to connected users
- Threaded cell comments
- `@mentions` with notification delivery (database/email)
- Resolve and re-open comment threads
- Version history snapshots and restore flow
- External email invitations with tokenized acceptance
- Public view-only links with optional expiry
- Permission levels: view, comment, edit, admin

### 7. AI Features

- Provider-agnostic AI service layer (Ollama, OpenAI, Anthropic)
- AI Formula modal:
  - Natural language formula prompt
  - Formula preview and insert confirmation
- AI analysis panel with tabs for insights, cleaning, and chart guidance
- Natural language query interface for spreadsheet actions
- AI data cleaning suggestions
- Sentiment analysis for text-heavy datasets
- OCR workflows for extracting structured data from pasted images
- Condition-driven automated workflows (AI-triggered actions)
- Prompt/response logging in `ai_prompts`
- User rate limiting (RPM/RPH) and API safety controls

### 8. Automation & Productivity

- Keyboard shortcuts modal and command handling
- Script editor for custom JavaScript automations
- Sandboxed script execution (Web Worker model)
- Macro recording and replay for repetitive tasks
- Guided onboarding tour support (Shepherd.js)

### 9. Platform Operations

- Redis-backed queue and cache architecture
- Horizon-ready queue monitoring setup
- Backup command and helper scripts
- Load testing script and runbook documentation
- Deployment runbook with cache optimization and supervisor restart flow

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13 |
| Auth/Identity | Jetstream 5, Fortify, Sanctum |
| Frontend Reactivity | Livewire 3, Alpine.js |
| Styling | Tailwind CSS 3 |
| Build Tooling | Vite 8 |
| Real-time | Laravel Echo, Pusher JS, Pusher PHP SDK |
| AI Integrations | Ollama, OpenAI, Anthropic (via service abstraction) |
| Charts | Chart.js 4 |
| Import/Export | Maatwebsite Excel 3 + CSV |
| Onboarding Tour | Shepherd.js |
| Queue/Monitoring | Redis, Horizon-compatible deployment |
| Testing | PHPUnit 12, Laravel Dusk 8 |

## Requirements

- PHP 8.3+ with extensions: `pdo`, `mbstring`, `xml`, `zip`, and DB-specific PDO driver
- Composer
- Node.js 18+ and npm
- Redis (recommended for cache, sessions, queues, and broadcasting support)
- Pusher account or self-hosted compatible websocket server (for real-time collaboration)
- Optional AI credentials/endpoints for provider(s) you plan to use

## Quick Start

```bash
git clone https://github.com/sakhileb/Dot.Sheet.git
cd Dot.Sheet
composer run setup
composer run dev
```

Open: `http://localhost:8000`

The `setup` script performs dependency install, environment bootstrap, key generation, migration, and frontend build.

## Configuration

Configure environment values in `.env`.

### App & Database

```env
APP_NAME="Dot.Sheet"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

### Redis / Queue / Session

```env
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

### Broadcasting

```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### AI Providers

```env
# one of: ollama, openai, anthropic
AI_PROVIDER=ollama

# ollama
OLLAMA_BASE_URL=http://localhost:11434
OLLAMA_MODEL=mistral

# openai
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini

# anthropic
ANTHROPIC_API_KEY=sk-ant-...
ANTHROPIC_MODEL=claude-3-5-sonnet-latest

# safety/rate limits
AI_RATE_LIMIT_ENABLED=true
AI_RATE_LIMIT_RPM=60
AI_RATE_LIMIT_RPH=1000
```

## Run the Application

Preferred one-command development mode:

```bash
composer run dev
```

This starts:

- App server (`php artisan serve`)
- Queue listener (`php artisan queue:listen --tries=1 --timeout=0`)
- Log tail (`php artisan pail --timeout=0`)
- Vite dev server (`npm run dev`)

Manual alternative:

```bash
php artisan serve
php artisan queue:work --queue=default,imports
npm run dev
```

## Testing

```bash
# all app tests
composer run test

# phpunit/feature/unit tests
php artisan test

# targeted suite
php artisan test --filter=FormulaEvaluator

# browser/E2E tests (requires Dusk setup)
php artisan dusk
```

Additional quality checks:

- Load testing helper: `scripts/run-load-test.sh`
- Load testing documentation: `docs/load-testing.md`

## Deployment & Operations

Primary deployment references:

- `docs/deployment-runbook.md`
- `docs/redis-horizon-checklist.md`
- `deploy/supervisor/`

Typical deployment flow:

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

Backups:

```bash
php artisan ops:backup
./scripts/run-backup.sh
```

## Architecture & Project Structure

```text
app/
  Http/Controllers/
  Livewire/
    ShowSpreadsheet.php
    SpreadsheetToolbar.php
    ChartBuilder.php
    CellCommentsPanel.php
    VersionHistoryModal.php
    SpreadsheetSharingPanel.php
    AiFormulaModal.php
    AiAnalysisPanel.php
    AiNaturalLanguageQuery.php
    ScriptsEditor.php
  Services/
    FormulaEvaluatorService.php
    SpreadsheetImportExportService.php
    AiService.php
  Jobs/
    BulkPasteChunkJob.php
    ImportRowsChunkJob.php
    SimulateSpreadsheetEditJob.php
  Events/
    SpreadsheetCellUpdated.php
    SpreadsheetCursorMoved.php
  Models/
    Spreadsheet.php
    Cell.php
    CellHistory.php
    ChartConfig.php
    AiPrompt.php
resources/
  js/
    formula-parser.js
  views/
    livewire/
database/
  migrations/
docs/
```

## Formula Engine

Dot.Sheet evaluates formulas in two layers for speed and consistency:

- Client: `resources/js/formula-parser.js`
- Server: `app/Services/FormulaEvaluatorService.php`

Supported function families include:

- Math: `SUM`, `AVERAGE`, `COUNT`, `MAX`, `MIN`, `ROUND`, `ABS`, `SQRT`, `POWER`, `MOD`
- Logic: `IF`, `AND`, `OR`, `NOT`, `IFERROR`
- Text: `CONCAT`, `UPPER`, `LOWER`, `LEN`, `TRIM`, `LEFT`, `RIGHT`, `MID`
- Date/Time: `NOW`, `TODAY`, `DATE`, `YEAR`, `MONTH`, `DAY`
- Lookup: `VLOOKUP`, `HLOOKUP`, `INDEX`, `MATCH`

To extend formulas, follow: `docs/developer-formula-extension.md`

## AI System

All AI operations are centralized through `app/Services/AiService.php` with provider switching through configuration only.

Provider options:

- Ollama (self-hosted/local)
- OpenAI (cloud)
- Anthropic (cloud)

AI requests are logged to `ai_prompts` for transparency, auditing, and potential response reuse. Per-user rate limits are enforced before outbound provider calls.

## Documentation Index

- User guide: `docs/user-guide.md`
- Formula extension guide: `docs/developer-formula-extension.md`
- Deployment runbook: `docs/deployment-runbook.md`
- Load testing: `docs/load-testing.md`
- Redis/Horizon checklist: `docs/redis-horizon-checklist.md`
- Quick project bootstrap: `QUICKSTART.md`
- Historical delivery notes: `PHASE_1_COMPLETION.md`, `PHASE_2_COMPLETE.md`, `PHASE_2_PROGRESS.md`, `TASK_LIST.md`

## Known Gaps / Backlog

The major roadmap is implemented. Remaining/planned items include:

- CRDT/OT-style conflict resolution enhancements for concurrent edits
- Mobile-optimized simplified editor experience
- Public API surface (REST/GraphQL)
- Third-party workflow integrations (Zapier/Make)
- Offline-first sync support

## License

Licensed under the [MIT License](LICENSE).
