<?php

namespace App\Services;

use App\Jobs\DispatchRideRequestWave;
use App\Models\BusinessSetting;
use App\Models\DeliveryMan;
use App\Models\RideRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RideDispatchService
{
    private array $settings = [];

    public function __construct(private readonly RideCaptainEligibilityService $eligibility) {}

    public function rankedCaptains(RideRequest $ride): Collection
    {
        return $this->eligibility->eligibleCaptainsForRide($ride, 100);
    }

    public function visibleCaptains(RideRequest $ride): Collection
    {
        return $this->rankedCaptains($ride)
            ->take($this->visibleCaptainCount($ride))
            ->values();
    }

    public function captainsForWave(RideRequest $ride, int $wave): Collection
    {
        return $this->rankedCaptains($ride)
            ->slice($wave * $this->waveSize(), $this->waveSize())
            ->values();
    }

    public function isVisibleTo(DeliveryMan $captain, RideRequest $ride): bool
    {
        return $this->visibleWaveFor($captain, $ride) !== null;
    }

    public function visibleWaveFor(DeliveryMan $captain, RideRequest $ride): ?int
    {
        $position = $this->rankedCaptains($ride)
            ->search(fn (DeliveryMan $candidate) => (int) $candidate->id === (int) $captain->id);

        if ($position === false || $position >= $this->visibleCaptainCount($ride)) {
            return null;
        }

        return intdiv($position, $this->waveSize()) + 1;
    }

    public function dispatch(RideRequest $ride): void
    {
        $captainCount = $this->rankedCaptains($ride)->count();
        if ($captainCount === 0) {
            return;
        }

        $waveCount = (int) ceil($captainCount / $this->waveSize());
        for ($wave = 0; $wave < $waveCount; $wave++) {
            $releaseAt = $this->dispatchStartedAt($ride)
                ->addSeconds($wave * $this->waveIntervalSeconds());
            DispatchRideRequestWave::dispatch($ride->id, $wave)
                ->delay($releaseAt->isFuture() ? $releaseAt : now());
        }
    }

    public function visibleCaptainCount(RideRequest $ride): int
    {
        $elapsed = (int) max(0, $this->dispatchStartedAt($ride)->diffInSeconds(now(), false));

        return $this->waveSize() * (intdiv($elapsed, $this->waveIntervalSeconds()) + 1);
    }

    public function dispatchStartedAt(RideRequest $ride): Carbon
    {
        return Carbon::parse($ride->created_at);
    }

    public function waveSize(): int
    {
        return max(1, min(50, (int) ($this->setting('ride_hailing_dispatch_wave_size') ?: 3)));
    }

    public function waveIntervalSeconds(): int
    {
        return max(5, min(300, (int) ($this->setting('ride_hailing_dispatch_wave_interval_seconds') ?: 20)));
    }

    private function setting(string $key): mixed
    {
        if (! array_key_exists($key, $this->settings)) {
            $this->settings[$key] = BusinessSetting::query()->where('key', $key)->value('value');
        }

        return $this->settings[$key];
    }
}
