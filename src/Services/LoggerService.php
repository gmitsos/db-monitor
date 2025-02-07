<?php

declare(strict_types=1);

namespace Gmitsos\DbMonitor\Services;

final class LoggerService
{
    private string $logFile;

    public function __construct(string $logFile = null)
    {
        $defaultLogFile = dirname(__DIR__, 5).'/log/db_queries.log';

        $this->logFile = $logFile ?? $defaultLogFile;

        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
    }

    public function log(string $query, float $timeSpent): void
    {
        $endpoint = $_SERVER['REQUEST_URI'] ?? 'unknown endpoint';
        microtime(true) - $timeSpent;
        $timeSpent = number_format((microtime(true) - $timeSpent) / 1000000, 4);

        $logMessage = '['.
            date('Y-m-d H:i:s').
            "]  \nExecuted Query: $query | \nTime Spent: $timeSpent seconds | \nEndpoint: $endpoint |\n";

        $start = microtime(true);
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
        $end = microtime(true);

        $final = $end - $start;

        $writeLog = "Write took : $final\n";

        file_put_contents($this->logFile, $writeLog, FILE_APPEND);

    }
}