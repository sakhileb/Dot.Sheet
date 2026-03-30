#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

if [[ ! -f artisan ]]; then
  echo "artisan not found. Run this script from inside the Laravel project." >&2
  exit 1
fi

RETENTION_DAYS="${BACKUP_RETENTION_DAYS:-14}"

echo "Running backup with retention ${RETENTION_DAYS} days..."
php artisan ops:backup --retention-days="${RETENTION_DAYS}" "$@"

echo "Backup finished. Latest backups are in storage/app/backups/."
