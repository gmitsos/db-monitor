<?php

declare(strict_types=1);

namespace Gmitsos\DbMonitor;

use Gmitsos\DbMonitor\Services\AnalyzerService;
use Gmitsos\DbMonitor\Services\LoggerService;

class Monitor
{
    private LoggerService $loggerService;

    private AnalyzerService $analyzerService;

    public function __construct()
    {
        $this->loggerService = new LoggerService();
        $this->analyzerService = new AnalyzerService();
    }

    public function monitor(string $query, float $timeSpent): void
    {
        $this->loggerService->log($query, $timeSpent);
        $this->analyzerService->analyze($query);
    }

    public function log(string $query, float $timeSpent): void
    {
        $this->loggerService->log($query, $timeSpent);
    }

    public function analyze(string $query): void
    {
        $this->analyzerService->analyze($query);
    }
}