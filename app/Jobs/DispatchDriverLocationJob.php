<?php

namespace App\Jobs;

use App\Queue\Middleware\EnsureQueueProcessEnabled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchDriverLocationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $deliverymanId;

    public $latitude;

    public $longitude;

    public $location;

    public function __construct($deliverymanId, $latitude, $longitude, $location)
    {
        $this->deliverymanId = $deliverymanId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->location = $location;
        info("from JOB: Broadcasting location update for deliveryman ID: {$deliverymanId} to dm_location_{$deliverymanId} channel.");
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('driver_location_broadcast')];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('dispachDriverLocationJob called');
        \App\Events\DeliveryLocationUpdated::broadcast($this->deliverymanId, $this->latitude, $this->longitude, $this->location);
    }
}
