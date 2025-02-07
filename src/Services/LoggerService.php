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

        $backtrace = debug_backtrace();
        $callingFunction = $backtrace[2]['function'] ?? 'unknown function';
        $callingClass = $backtrace[2]['class'] ?? '';

        $logMessage = '['.
            date('Y-m-d H:i:s').
            "]  \nExecuted Query: $query | \nTime Spent: $timeSpent seconds | \nEndpoint: $endpoint | \nOrigin: $callingClass::$callingFunction\n";

        $logMessage .= "Backtrace:\n";

        foreach ($backtrace as $index => $frame) {
            $file = $frame['file'] ?? 'unknown file';
            $line = $frame['line'] ?? 'unknown line';
            $function = $frame['function'] ?? 'unknown function';
            $class = $frame['class'] ?? '';
            $args = $frame['args'] ?? [];

            $formattedArgs = [];
            foreach ($args as $arg) {
                $formattedArgs[] = is_object($arg) ? get_class($arg) : var_export($arg, true);
            }
            $argList = implode(', ', $formattedArgs);

            $logMessage .= "#$index $class::$function called at [$file:$line] with args: ($argList)\n";
        }

        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}