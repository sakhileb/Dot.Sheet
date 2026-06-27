<div align="center">

<img src="public/dot_sheet.png" alt="Dot.Sheet" width="200" />

<h1>Dot.Sheet</h1>

<p>Collaborative spreadsheets — build, share, and analyse data in real time with your team.</p>

[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=flat-square)](https://livewire.laravel.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-4169E1?style=flat-square&logo=postgresql&logoColor=white)](https://postgresql.org)
[![License](https://img.shields.io/badge/license-MIT-green?style=flat-square)](LICENSE)

</div>

---

## Overview

Dot.Sheet is the collaborative spreadsheet platform in the Dot ecosystem. Teams create and edit spreadsheets with live multi-user presence, formula support, and real-time sync powered by Laravel Reverb WebSockets.

---

## Features

- Real-time multi-user editing with cell-level locking via Reverb
- Formula engine (SUM, AVG, IF, VLOOKUP, and more)
- Named ranges, data validation, and conditional formatting
- Charts and pivot tables
- Import/export CSV and XLSX
- Sheet-level and cell-range sharing permissions
- Comment threads on cells
- Ecosystem SSO — authenticate from InfoDot with a single click

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 + PHP 8.4 |
| Frontend | Livewire 3 + Vite + Tailwind CSS |
| Auth | Jetstream 5 + Sanctum (ecosystem SSO) |
| Database | PostgreSQL 16 (shared infodot instance) |
| WebSockets | Laravel Reverb (replaced Pusher) |

---

## Quick Start

```bash
git clone https://github.com/sakhileb/Dot.Sheet.git && cd Dot.Sheet
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate && npm run dev & php artisan serve
php artisan reverb:start   # WebSockets for real-time sync
```

```bash
bash bin/test.sh   # Run tests
```

---

## Part of the Dot Ecosystem

Dot.Sheet connects to [InfoDot](https://github.com/sakhileb/InfoDot) — the central hub. Log in to InfoDot once and navigate here without re-authenticating via `/auth/ecosystem`.

---

MIT — © SK Digital / BluPin Incorporated
