<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\RideCategory;
use App\Models\RideFare;
use App\Models\RideRequest;
use App\Models\RideVehicle;
use App\Models\RideVehicleType;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RideHailingController extends Controller
{
    public function dashboard(Request $request): View
    {
        $zoneId = $request->input('zone_id', 'all');
        $zoneId = is_numeric($zoneId) ? (int) $zoneId : 'all';
        $zones = Zone::query()->where('status', 1)->orderBy('name')->get(['id', 'name']);

        $stats = [
            'ride_mode_riders' => DeliveryMan::query()->rideMode()->active()
                ->when($zoneId !== 'all', fn ($query) => $query->where('zone_id', $zoneId))->count(),
            'registered_vehicles' => RideVehicle::query()
                ->when($zoneId !== 'all', fn ($query) => $query->whereHas('deliveryMan', fn ($rider) => $rider->where('zone_id', $zoneId)))->count(),
            'approved_vehicles' => RideVehicle::query()->where('status', 'approved')
                ->when($zoneId !== 'all', fn ($query) => $query->whereHas('deliveryMan', fn ($rider) => $rider->where('zone_id', $zoneId)))->count(),
            'pending_vehicles' => RideVehicle::query()->where('status', 'pending')
                ->when($zoneId !== 'all', fn ($query) => $query->whereHas('deliveryMan', fn ($rider) => $rider->where('zone_id', $zoneId)))->count(),
            'categories' => RideCategory::query()->where('status', true)->count(),
            'configured_fares' => RideFare::query()->where('status', true)
                ->whereHas('zone.modules', fn ($query) => $query->where('module_type', 'ride_hailing'))
                ->when($zoneId !== 'all', fn ($query) => $query->where('zone_id', $zoneId))->count(),
            'rides_need_captain' => RideRequest::query()->whereIn('status', [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING])
                ->when($zoneId !== 'all', fn ($query) => $query->where('zone_id', $zoneId))->count(),
            'active_rides' => RideRequest::query()->whereIn('status', [RideRequest::STATUS_RIDER_SELECTED, RideRequest::STATUS_CAPTAIN_ARRIVING, RideRequest::STATUS_ARRIVED, RideRequest::STATUS_IN_PROGRESS])
                ->when($zoneId !== 'all', fn ($query) => $query->where('zone_id', $zoneId))->count(),
            'completed_rides' => RideRequest::query()->where('status', RideRequest::STATUS_COMPLETED)
                ->when($zoneId !== 'all', fn ($query) => $query->where('zone_id', $zoneId))->count(),
            'unpaid_rides' => RideRequest::query()->whereIn('status', [RideRequest::STATUS_COMPLETED, RideRequest::STATUS_CANCELLED])->whereIn('payment_status', ['unpaid', 'pending', 'partially_paid'])
                ->when($zoneId !== 'all', fn ($query) => $query->where('zone_id', $zoneId))->count(),
        ];

        return view('admin-views.ride-hailing.dashboard', compact('stats', 'zones', 'zoneId'));
    }

    public function categories(): View
    {
        $types = RideVehicleType::query()->orderBy('sort_order')->get();
        $categories = RideCategory::query()->with('vehicleType')->withCount('vehicles')->orderBy('sort_order')->get();

        return view('admin-views.ride-hailing.categories', compact('types', 'categories'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ride_vehicle_type_id' => ['required', 'exists:ride_vehicle_types,id'],
            'name' => ['required', 'string', 'max:100'],
            'fuel_type' => ['nullable', Rule::in(RideVehicle::FUEL_TYPES)],
            'passenger_capacity' => ['required', 'integer', 'min:1', 'max:12'],
        ]);
        $slug = Str::slug($validated['name']);
        if (RideCategory::query()->where('slug', $slug)->exists()) {
            throw ValidationException::withMessages(['name' => translate('messages.This ride category already exists.')]);
        }

        RideCategory::create([...$validated, 'slug' => $slug, 'status' => true]);

        return back()->with('success', translate('messages.Ride category created successfully.'));
    }

    public function categoryStatus(RideCategory $category): RedirectResponse
    {
        $category->update(['status' => !$category->status]);

        return back()->with('success', translate('messages.Ride category status updated.'));
    }

    public function vehicles(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $vehicles = RideVehicle::query()
            ->with(['deliveryMan', 'vehicleType', 'category'])
            ->when($search !== '', fn ($query) => $query->where(fn ($nested) => $nested
                ->where('registration_number', 'like', "%{$search}%")
                ->orWhere('make', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%")
                ->orWhereHas('deliveryMan', fn ($rider) => $rider
                    ->where('f_name', 'like', "%{$search}%")
                    ->orWhere('l_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%"))))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin-views.ride-hailing.vehicles.index', compact('vehicles', 'search'));
    }

    public function riders(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $adminZoneId = auth('admin')->user()?->zone_id;
        $zoneId = $adminZoneId ?: ($request->integer('zone_id') ?: null);
        $zones = Zone::query()
            ->where('status', 1)
            ->when($adminZoneId, fn ($query) => $query->whereKey($adminZoneId))
            ->orderBy('name')
            ->get(['id', 'name']);
        $riders = DeliveryMan::withoutGlobalScopes()
            ->with(['rideVehicles.vehicleType', 'rideVehicles.category', 'activeRideVehicle.vehicleType', 'activeRideVehicle.category'])
            ->withCount('rideVehicles')
            ->where('application_status', 'approved')
            ->where('work_mode', 'ride')
            ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))
            ->when($search !== '', fn ($query) => $query->where(fn ($nested) => $nested
                ->where('f_name', 'like', "%{$search}%")
                ->orWhere('l_name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")))
            ->orderByDesc('ride_vehicles_count')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin-views.ride-hailing.riders', compact('riders', 'search', 'zones', 'zoneId', 'adminZoneId'));
    }

    public function createVehicle(): View
    {
        $types = RideVehicleType::query()->where('status', true)->with(['categories' => fn ($q) => $q->where('status', true)->orderBy('sort_order')])->orderBy('sort_order')->get();

        return view('admin-views.ride-hailing.vehicles.create', compact('types'));
    }

    public function searchRiders(Request $request): JsonResponse
    {
        $term = trim((string) $request->input('q'));
        $riders = DeliveryMan::withoutGlobalScopes()
            ->withCount('rideVehicles')
            ->where('application_status', 'approved')
            ->where('status', 1)
            ->whereHas('rideVehicles', fn ($query) => $query, '<', RideVehicle::MAX_PER_RIDER)
            ->when($term !== '', fn ($query) => $query->where(fn ($nested) => $nested
                ->where('f_name', 'like', "%{$term}%")
                ->orWhere('l_name', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")))
            ->orderBy('f_name')
            ->limit(20)
            ->get(['id', 'f_name', 'l_name', 'phone']);

        return response()->json(['results' => $riders->map(fn ($rider) => [
            'id' => $rider->id,
            'text' => trim("{$rider->f_name} {$rider->l_name}") . " ({$rider->phone}) - {$rider->ride_vehicles_count}/2",
        ])]);
    }

    public function storeVehicle(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'delivery_man_id' => ['required', 'exists:delivery_men,id'],
            'ride_vehicle_type_id' => ['required', 'exists:ride_vehicle_types,id'],
            'ride_category_id' => ['required', 'exists:ride_categories,id'],
            'fuel_type' => ['required', Rule::in(RideVehicle::FUEL_TYPES)],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'model_year' => ['nullable', 'integer', 'min:1980', 'max:' . (now()->year + 1)],
            'color' => ['required', 'string', 'max:50'],
            'registration_number' => ['required', 'string', 'max:80', 'unique:ride_vehicles,registration_number'],
            'vehicle_front_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'vehicle_back_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['required', Rule::in(RideVehicle::STATUSES)],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $category = RideCategory::query()->findOrFail($validated['ride_category_id']);
        if ($category->ride_vehicle_type_id !== (int) $validated['ride_vehicle_type_id']) {
            throw ValidationException::withMessages(['ride_category_id' => translate('messages.The category does not belong to the selected vehicle type.')]);
        }
        if ($category->fuel_type && $category->fuel_type !== $validated['fuel_type']) {
            throw ValidationException::withMessages(['fuel_type' => translate('messages.The fuel type does not match the selected ride category.')]);
        }

        DB::transaction(function () use ($validated) {
            DeliveryMan::withoutGlobalScopes()->lockForUpdate()->findOrFail($validated['delivery_man_id']);
            if (RideVehicle::query()->where('delivery_man_id', $validated['delivery_man_id'])->count() >= RideVehicle::MAX_PER_RIDER) {
                throw ValidationException::withMessages(['delivery_man_id' => translate('messages.A rider can register a maximum of two ride vehicles.')]);
            }

            $frontImage = \App\CentralLogics\Helpers::upload('ride-vehicle/', 'png', $validated['vehicle_front_image']);
            $backImage = \App\CentralLogics\Helpers::upload('ride-vehicle/', 'png', $validated['vehicle_back_image']);
            unset($validated['vehicle_front_image'], $validated['vehicle_back_image']);
            $hasActive = RideVehicle::query()->where('delivery_man_id', $validated['delivery_man_id'])->where('is_active', true)->exists();
            RideVehicle::create([
                ...$validated,
                'registration_number' => strtoupper(trim($validated['registration_number'])),
                'front_image' => $frontImage,
                'front_image_storage' => \App\CentralLogics\Helpers::getDisk(),
                'back_image' => $backImage,
                'back_image_storage' => \App\CentralLogics\Helpers::getDisk(),
                'is_active' => $validated['status'] === 'approved' && !$hasActive,
            ]);
        });

        return redirect()->route('admin.ride-hailing.vehicles.index')->with('success', translate('messages.Ride vehicle registered successfully.'));
    }

    public function vehicleStatus(Request $request, RideVehicle $vehicle): RedirectResponse
    {
        $validated = $request->validate(['status' => ['required', Rule::in(RideVehicle::STATUSES)]]);
        DB::transaction(function () use ($vehicle, $validated) {
            $vehicle = RideVehicle::query()->lockForUpdate()->findOrFail($vehicle->id);
            $vehicle->status = $validated['status'];
            if ($vehicle->status !== 'approved') {
                $vehicle->is_active = false;
            }
            $vehicle->save();
        });

        return back()->with('success', translate('messages.Ride vehicle status updated.'));
    }

    public function activateVehicle(RideVehicle $vehicle): RedirectResponse
    {
        if ($vehicle->status !== 'approved') {
            return back()->with('error', translate('messages.Only an approved ride vehicle can be activated.'));
        }
        DB::transaction(function () use ($vehicle) {
            RideVehicle::query()->where('delivery_man_id', $vehicle->delivery_man_id)->update(['is_active' => false]);
            $vehicle->update(['is_active' => true]);
        });

        return back()->with('success', translate('messages.Active ride vehicle updated.'));
    }

}
