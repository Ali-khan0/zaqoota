<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class RecordQueueWorkerHeartbeat implements ShouldQueue
{
    use Queueable;

    public int $tries = 1;

    public function handle(): void
    {
        DB::table('business_settings')->updateOrInsert(
            ['key' => 'queue_worker_last_heartbeat_at'],
            ['value' => now()->toIso8601String(), 'updated_at' => now()],
        );
        DB::table('business_settings')->updateOrInsert(
            ['key' => 'queue_worker_last_connection'],
            ['value' => (string) config('queue.default'), 'updated_at' => now()],
        );
    }
}
