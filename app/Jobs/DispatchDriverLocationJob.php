<?php

namespace App\Jobs;

use App\Queue\Middleware\EnsureQueueProcessEnabled;
use App\Services\DispatchRiderLocationService;
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

    public $previousZoneId;

    public function __construct($deliverymanId, $latitude, $longitude, $location, $previousZoneId = null)
    {
        $this->deliverymanId = $deliverymanId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->location = $location;
        $this->previousZoneId = $previousZoneId;
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('driver_location_broadcast')];
    }

    /**
     * Execute the job.
     */
    public function handle(DispatchRiderLocationService $dispatchLocations): void
    {
        $dispatchLocations->broadcast((int) $this->deliverymanId, $this->previousZoneId ? (int) $this->previousZoneId : null);
        if (is_numeric($this->latitude) && is_numeric($this->longitude)) {
            \App\Events\DeliveryLocationUpdated::broadcast($this->deliverymanId, $this->latitude, $this->longitude, $this->location);
        }
    }
}
