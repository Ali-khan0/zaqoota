<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RideVehicle;
use App\Models\RideVehicleType;

class RideHailingController extends Controller
{
    public function vehicleOptions()
    {
        $types = RideVehicleType::query()
            ->where('status', true)
            ->with(['categories' => fn ($query) => $query->where('status', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'maximum_vehicle_limit' => RideVehicle::MAX_PER_RIDER,
            'fuel_types' => RideVehicle::FUEL_TYPES,
            'vehicle_types' => $types->map(fn ($type) => [
                'id' => (int) $type->id,
                'name' => $type->name,
                'slug' => $type->slug,
                'categories' => $type->categories->map(fn ($category) => [
                    'id' => (int) $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'required_fuel_type' => $category->fuel_type,
                    'passenger_capacity' => (int) $category->passenger_capacity,
                ])->values(),
            ])->values(),
        ]);
    }
}
