# Lightweight Load Testing

This project includes a queue-driven load test harness that simulates concurrent spreadsheet edits.

## What It Does

- Dispatches many queued jobs in a batch.
- Each job performs random cell edits in the target spreadsheet.
- Polls batch progress until completion.
- Reports total operations and approximate ops/sec.

## Prerequisites

- Queue worker running for async mode:
  - `php artisan queue:work`
- A target spreadsheet ID.

## Run via Script

```bash
./scripts/run-load-test.sh <spreadsheet_id> [jobs] [iterations] [max_row] [max_col]
```

Example:

```bash
./scripts/run-load-test.sh 1 30 300 1000 80
```

## Run via Artisan Directly

```bash
php artisan spreadsheet:load-test 1 --jobs=30 --iterations=300 --max-row=1000 --max-col=80
```

## Notes

- With `QUEUE_CONNECTION=sync`, jobs execute inline and still provide throughput estimates.
- This is intentionally lightweight and suitable for local/dev benchmarking.
- For deeper performance analysis, integrate k6/JMeter and app-level tracing.
