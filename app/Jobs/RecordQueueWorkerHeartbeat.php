<?php

namespace App\Jobs;

use App\Models\BusinessSetting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RecordQueueWorkerHeartbeat implements ShouldQueue
{
    use Queueable;

    public int $tries = 1;

    public function handle(): void
    {
        BusinessSetting::query()->updateOrCreate(
            ['key' => 'queue_worker_last_heartbeat_at'],
            ['value' => now()->toIso8601String()],
        );
        BusinessSetting::query()->updateOrCreate(
            ['key' => 'queue_worker_last_connection'],
            ['value' => (string) config('queue.default')],
        );
    }
}
