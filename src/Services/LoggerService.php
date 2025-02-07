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

    public function log(string $query, float $timeSpent): void
    {
        $endpoint = $_SERVER['REQUEST_URI'] ?? 'unknown endpoint';

        $backtrace = debug_backtrace();
        $callingFunction = $backtrace[1]['function'] ?? 'unknown function';
        $callingClass = $backtrace[1]['class'] ?? '';

        $logMessage = '['.
            date('Y-m-d H:i:s').
            "]  \nExecuted Query: $query | \nTime Spent: $timeSpent seconds | \nEndpoint: $endpoint | \nOrigin: $callingClass::$callingFunction".PHP_EOL;

        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}