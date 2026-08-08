<?php

namespace App\Services;

use App\Models\RideCategory;
use App\Models\RideFare;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RideFareService
{
    public function rules(): array
    {
        return [
            'ride_fares' => ['required', 'array'],
            'ride_fares.*.base_fare' => ['required', 'numeric', 'min:0'],
            'ride_fares.*.minimum_fare' => ['required', 'numeric', 'min:0'],
            'ride_fares.*.per_km_charge' => ['required', 'numeric', 'min:0'],
            'ride_fares.*.per_minute_charge' => ['required', 'numeric', 'min:0'],
            'ride_fares.*.pickup_distance_charge' => ['required', 'numeric', 'min:0'],
            'ride_fares.*.waiting_charge_per_minute' => ['required', 'numeric', 'min:0'],
            'ride_fares.*.free_waiting_minutes' => ['required', 'integer', 'between:0,60'],
            'ride_fares.*.cancellation_charge' => ['required', 'numeric', 'min:0'],
            'ride_fares.*.platform_commission_percent' => ['required', 'numeric', 'between:0,100'],
            'ride_fares.*.negotiation_min_percent' => ['required', 'numeric', 'between:0,500'],
            'ride_fares.*.negotiation_max_percent' => ['required', 'numeric', 'between:0,500'],
            'ride_fares.*.offer_expiry_seconds' => ['required', 'integer', 'between:10,300'],
        ];
    }

    public function saveForZone(int $zoneId, array $fares, Request $request): void
    {
        $categoryIds = RideCategory::query()->where('status', true)->pluck('id');
        if ($categoryIds->diff(array_map('intval', array_keys($fares)))->isNotEmpty()) {
            throw ValidationException::withMessages([
                'ride_fares' => translate('messages.Fare setup is required for every active ride category.'),
            ]);
        }

        foreach ($fares as $categoryId => $fare) {
            if (! $categoryIds->contains((int) $categoryId)) {
                throw ValidationException::withMessages([
                    'ride_fares' => translate('messages.One of the selected ride categories is invalid.'),
                ]);
            }
            if ((float) $fare['negotiation_min_percent'] > (float) $fare['negotiation_max_percent']) {
                throw ValidationException::withMessages([
                    "ride_fares.{$categoryId}.negotiation_min_percent" => translate('messages.Minimum negotiation percentage cannot exceed maximum percentage.'),
                ]);
            }

            RideFare::updateOrCreate(
                ['zone_id' => $zoneId, 'ride_category_id' => $categoryId],
                [
                    ...$fare,
                    'status' => true,
                ]
            );
        }
    }
}
