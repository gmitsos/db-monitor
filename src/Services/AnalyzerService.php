<?php

declare(strict_types=1);

namespace Gmitsos\DbMonitor\Services;

final class AnalyzerService
{
    public function analyze(string $query): void
    {
        if (stripos($query, 'SELECT *') !== false) {
            echo "Warning: Avoid using SELECT * in queries. It may cause performance issues.\n";
        }

        if (preg_match('/WHERE\s+.*=.*[^\s]/', $query) === 0) {
            echo "Warning: The query might be missing conditions in WHERE clauses.\n";
        }
    }
}