# Developer Guide: Extending Formula Functions

## Overview

Formula evaluation is implemented in `app/Services/FormulaEvaluatorService.php`.

Core responsibilities:

- Parse and evaluate formula expressions.
- Resolve cell references (`A1`, `B12`, etc.).
- Evaluate built-in functions.
- Build dependency graph for formula recalculation planning.
- Cache cell payload and dependency graph in Laravel cache.

## Key Methods

- `evaluate(string $formula, int $spreadsheetId): array`
- `evaluateExpression(string $expr): mixed`
- `getCellValue(string $cellRef): mixed`
- `getDependencyGraph(int $spreadsheetId): array`
- `extractFormulaReferences(string $formula): array`

## Add a New Function

1. Open `evaluateExpression()`.
2. Extend the `match ($funcName)` block.
3. Parse and evaluate arguments with `evaluateExpression($arg)`.
4. Return a scalar result.

Example:

```php
'MEDIAN' => $this->median(array_map(fn($a) => $this->evaluateExpression($a), $args)),
```

Then add helper:

```php
protected function median(array $values): float
{
    sort($values);
    $count = count($values);
    if ($count === 0) {
        return 0.0;
    }

    $mid = intdiv($count, 2);
    if ($count % 2 === 1) {
        return (float) $values[$mid];
    }

    return ((float) $values[$mid - 1] + (float) $values[$mid]) / 2;
}
```

## Dependency Graph Notes

- Formula references are extracted by regex from formula text.
- Range references are expanded with safety limit (`maxCells = 5000`).
- Graph is keyed as `row_col` and points to dependent cells.

## Caching Behavior

- Cell payload cache key: `spreadsheet:{id}:cell_values`
- Dependency graph key: `spreadsheet:{id}:formula_dependency_graph`
- Any cell update should invalidate both keys.

## Testing Guidance

Use tests in:

- `tests/Unit/FormulaEvaluatorServiceTest.php`
- `tests/Feature/SpreadsheetCoreOperationsTest.php`

Recommended cases:

- Function correctness (`SUM`, `AVERAGE`, `IF`, etc.)
- Cell reference correctness
- Range expansion limits
- Dependency graph edge cases
- Cache invalidation after edits

## Safety and Limits

- Keep evaluation deterministic and side-effect free.
- Return fallback values for unsupported expressions.
- Bound any range expansion or recursion to avoid expensive evaluation.
