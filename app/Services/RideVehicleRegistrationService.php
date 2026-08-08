<?php

namespace App\Services;

use App\Models\DeliveryMan;
use App\Models\DMVehicle;
use App\Models\RideCategory;
use App\Models\RideVehicle;
use App\Models\RideVehicleType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RideVehicleRegistrationService
{
    public function rules(): array
    {
        return [
            'ride_vehicle_type_id' => ['required', 'integer', Rule::exists('ride_vehicle_types', 'id')->where('status', true)],
            'ride_category_id' => ['required', 'integer', Rule::exists('ride_categories', 'id')->where('status', true)],
            'fuel_type' => ['required', Rule::in(RideVehicle::FUEL_TYPES)],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'model_year' => ['nullable', 'integer', 'min:1980', 'max:'.(now()->year + 1)],
            'color' => ['required', 'string', 'max:50'],
            'registration_number' => ['required', 'string', 'max:80', 'unique:ride_vehicles,registration_number'],
        ];
    }

    public function createPendingVehicle(DeliveryMan $rider, array $data): RideVehicle
    {
        $category = RideCategory::query()->where('status', true)->findOrFail($data['ride_category_id']);
        $type = RideVehicleType::query()->where('status', true)->findOrFail($data['ride_vehicle_type_id']);

        if ($category->ride_vehicle_type_id !== $type->id) {
            throw ValidationException::withMessages([
                'ride_category_id' => translate('messages.The category does not belong to the selected vehicle type.'),
            ]);
        }
        if ($category->fuel_type && $category->fuel_type !== $data['fuel_type']) {
            throw ValidationException::withMessages([
                'fuel_type' => translate('messages.The fuel type does not match the selected ride category.'),
            ]);
        }
        if ($rider->rideVehicles()->count() >= RideVehicle::MAX_PER_RIDER) {
            throw ValidationException::withMessages([
                'ride_vehicle_type_id' => translate('messages.A rider can register a maximum of two ride vehicles.'),
            ]);
        }

        return $rider->rideVehicles()->create([
            ...$data,
            'registration_number' => strtoupper(trim($data['registration_number'])),
            'status' => 'pending',
            'is_active' => false,
        ]);
    }

    public function matchingDeliveryVehicleId(int $rideVehicleTypeId): ?int
    {
        $type = RideVehicleType::query()->find($rideVehicleTypeId);
        if (!$type) {
            return null;
        }

        return DMVehicle::withoutGlobalScopes()
            ->where('status', 1)
            ->whereRaw('LOWER(type) = ?', [strtolower($type->name)])
            ->value('id');
    }
}
