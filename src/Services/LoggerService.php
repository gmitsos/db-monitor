<?php

declare(strict_types=1);

namespace Gmitsos\DbMonitor\Services;

final class LoggerService
{
    private string $logFile;

    public function __construct(string $logFile = __DIR__.'/db_queries.log')
    {
        $this->logFile = $logFile;
    }

    public function log(string $query): void
    {
        $logMessage = '['.date('Y-m-d H:i:s')."] Executed Query: $query".PHP_EOL;
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}