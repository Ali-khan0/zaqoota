<?php

namespace Tests\Unit;

use App\Jobs\RecordQueueWorkerHeartbeat;
use App\Services\QueueProcessService;
use Illuminate\Contracts\Queue\ShouldQueue;
use PHPUnit\Framework\TestCase;

class QueueProcessDefinitionsTest extends TestCase
{
    public function test_every_application_queue_process_is_registered_for_admin_control(): void
    {
        self::assertSame([
            'commerce_dispatch_wave',
            'commerce_request_push',
            'ride_dispatch_wave',
            'ride_request_push',
            'ride_offer_expiry',
            'driver_location_broadcast',
        ], array_keys((new QueueProcessService)->definitions()));
    }

    public function test_registry_covers_every_business_queue_job_class(): void
    {
        $jobNames = [];
        foreach (glob(dirname(__DIR__, 2).'/app/Jobs/*.php') ?: [] as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $class = 'App\\Jobs\\'.$name;
            if ($class !== RecordQueueWorkerHeartbeat::class && is_subclass_of($class, ShouldQueue::class)) {
                $jobNames[] = $name;
            }
        }

        $registered = array_column((new QueueProcessService)->definitions(), 'job');
        sort($jobNames);
        sort($registered);

        self::assertSame($jobNames, $registered);
    }
}
