<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Models\DeliveryMan;
use App\Models\DMVehicle;
use App\Models\RideCategory;
use App\Models\RideVehicle;
use App\Models\RideVehicleReviewAudit;
use App\Models\RideVehicleType;
use Illuminate\Support\Facades\DB;
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
            'vehicle_front_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'vehicle_back_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function resubmissionRules(RideVehicle $vehicle): array
    {
        return [
            'ride_vehicle_type_id' => ['required', 'integer', Rule::exists('ride_vehicle_types', 'id')->where('status', true)],
            'ride_category_id' => ['required', 'integer', Rule::exists('ride_categories', 'id')->where('status', true)],
            'fuel_type' => ['required', Rule::in(RideVehicle::FUEL_TYPES)],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'model_year' => ['nullable', 'integer', 'min:1980', 'max:'.(now()->year + 1)],
            'color' => ['required', 'string', 'max:50'],
            'registration_number' => ['required', 'string', 'max:80', Rule::unique('ride_vehicles', 'registration_number')->ignore($vehicle->id)],
            'vehicle_front_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'vehicle_back_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
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

        $frontImage = Helpers::upload('ride-vehicle/', 'png', $data['vehicle_front_image']);
        $backImage = Helpers::upload('ride-vehicle/', 'png', $data['vehicle_back_image']);
        unset($data['vehicle_front_image'], $data['vehicle_back_image']);

        return $rider->rideVehicles()->create([
            ...$data,
            'registration_number' => strtoupper(trim($data['registration_number'])),
            'front_image' => $frontImage,
            'front_image_storage' => Helpers::getDisk(),
            'back_image' => $backImage,
            'back_image_storage' => Helpers::getDisk(),
            'status' => 'pending',
            'is_active' => false,
        ]);
    }

    public function resubmitRejectedVehicle(DeliveryMan $rider, RideVehicle $vehicle, array $data): RideVehicle
    {
        $newImages = [];
        $oldImages = [];

        try {
            $vehicle = DB::transaction(function () use ($rider, $vehicle, $data, &$newImages, &$oldImages): RideVehicle {
                $vehicle = $rider->rideVehicles()->whereKey($vehicle->id)->lockForUpdate()->firstOrFail();
                if ($vehicle->status !== 'rejected') {
                    throw ValidationException::withMessages([
                        'ride_vehicle' => translate('messages.Only a rejected ride vehicle can be corrected and resubmitted.'),
                    ]);
                }

                $this->assertCompatibleSelection($data);
                $updates = collect($data)->except(['vehicle_front_image', 'vehicle_back_image'])->all();
                $updates['registration_number'] = strtoupper(trim($data['registration_number']));

                foreach ([
                    'vehicle_front_image' => ['column' => 'front_image', 'storage' => 'front_image_storage'],
                    'vehicle_back_image' => ['column' => 'back_image', 'storage' => 'back_image_storage'],
                ] as $input => $columns) {
                    if (! isset($data[$input])) {
                        continue;
                    }
                    $uploaded = Helpers::upload('ride-vehicle/', 'png', $data[$input]);
                    $newImages[] = $uploaded;
                    if ($vehicle->{$columns['column']}) {
                        $oldImages[] = $vehicle->{$columns['column']};
                    }
                    $updates[$columns['column']] = $uploaded;
                    $updates[$columns['storage']] = Helpers::getDisk();
                }

                $vehicle->update([
                    ...$updates,
                    'status' => 'pending',
                    'is_active' => false,
                    'admin_note' => null,
                    'reviewed_by' => null,
                    'reviewed_at' => null,
                ]);
                RideVehicleReviewAudit::query()->create([
                    'ride_vehicle_id' => $vehicle->id,
                    'admin_id' => null,
                    'from_status' => 'rejected',
                    'to_status' => 'pending',
                    'admin_note' => 'Captain corrected and resubmitted the vehicle.',
                    'reviewed_at' => now(),
                ]);

                return $vehicle;
            }, 3);
        } catch (\Throwable $exception) {
            foreach ($newImages as $image) {
                Helpers::check_and_delete('ride-vehicle/', $image);
            }
            throw $exception;
        }

        foreach ($oldImages as $image) {
            Helpers::check_and_delete('ride-vehicle/', $image);
        }

        return $vehicle;
    }

    private function assertCompatibleSelection(array $data): void
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
