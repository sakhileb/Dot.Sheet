#!/usr/bin/env bash
set -euo pipefail

if [[ $# -lt 1 ]]; then
  echo "Usage: $0 <spreadsheet_id> [jobs] [iterations] [max_row] [max_col]"
  echo "Example: $0 1 30 300 1000 80"
  exit 1
fi

SPREADSHEET_ID="$1"
JOBS="${2:-20}"
ITERATIONS="${3:-200}"
MAX_ROW="${4:-500}"
MAX_COL="${5:-50}"

php artisan spreadsheet:load-test "$SPREADSHEET_ID" \
  --jobs="$JOBS" \
  --iterations="$ITERATIONS" \
  --max-row="$MAX_ROW" \
  --max-col="$MAX_COL"
