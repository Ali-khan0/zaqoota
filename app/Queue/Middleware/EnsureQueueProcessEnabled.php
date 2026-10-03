<?php

namespace App\Queue\Middleware;

use App\Services\QueueProcessService;
use Closure;
use Throwable;

class EnsureQueueProcessEnabled
{
    public function __construct(private readonly string $process) {}

    public function handle(object $job, Closure $next): void
    {
        $service = app(QueueProcessService::class);
        if (! $service->enabled($this->process)) {
            $service->recordSkipped($this->process);
            if (method_exists($job, 'skipped')) {
                $job->skipped();
            }

            return;
        }

        try {
            $next($job);
            $service->recordProcessed($this->process);
        } catch (Throwable $exception) {
            $service->recordFailed($this->process, $exception);

            throw $exception;
        }
    }
}
