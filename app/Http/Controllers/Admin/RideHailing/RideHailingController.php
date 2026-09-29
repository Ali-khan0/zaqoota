<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\RideCategory;
use App\Models\RideFare;
use App\Models\RideRequest;
use App\Models\RideVehicle;
use App\Models\RideVehicleReviewAudit;
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
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $slug = Str::slug($validated['name']);
        if (RideCategory::query()->where('slug', $slug)->exists()) {
            throw ValidationException::withMessages(['name' => translate('messages.This ride category already exists.')]);
        }

        $image = isset($validated['image']) ? Helpers::upload('ride-category/', 'webp', $validated['image']) : null;
        unset($validated['image']);
        RideCategory::create([...$validated, 'slug' => $slug, 'image' => $image, 'image_storage' => Helpers::getDisk(), 'status' => true]);

        return back()->with('success', translate('messages.Ride category created successfully.'));
    }

    public function categoryStatus(RideCategory $category): RedirectResponse
    {
        $category->update(['status' => ! $category->status]);

        return back()->with('success', translate('messages.Ride category status updated.'));
    }

    public function categoryImage(Request $request, RideCategory $category): RedirectResponse
    {
        $this->updateImage($request, $category);

        return back()->with('success', translate('messages.Ride category image updated.'));
    }

    public function vehicleTypeImage(Request $request, RideVehicleType $type): RedirectResponse
    {
        $this->updateImage($request, $type);

        return back()->with('success', translate('messages.Vehicle type image updated.'));
    }

    private function updateImage(Request $request, RideCategory|RideVehicleType $model): void
    {
        $validated = $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'required_without:remove_image'],
            'remove_image' => ['nullable', 'boolean'],
        ]);
        $oldImage = $model->image;
        if ($request->boolean('remove_image')) {
            $model->update(['image' => null, 'image_storage' => Helpers::getDisk()]);
        } elseif ($request->hasFile('image')) {
            $model->update([
                'image' => Helpers::upload('ride-category/', 'webp', $validated['image']),
                'image_storage' => Helpers::getDisk(),
            ]);
        }
        if ($oldImage && $oldImage !== $model->image) {
            Helpers::check_and_delete('ride-category/', $oldImage);
        }
    }

    public function vehicles(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $status = in_array($request->input('status'), RideVehicle::STATUSES, true) ? $request->input('status') : 'all';
        $vehicleTypeId = $request->integer('vehicle_type_id') ?: null;
        $categoryId = $request->integer('category_id') ?: null;
        $fuelType = in_array($request->input('fuel_type'), RideVehicle::FUEL_TYPES, true) ? $request->input('fuel_type') : null;
        $baseQuery = $this->vehicleAdminQuery();
        $statusCounts = collect(RideVehicle::STATUSES)->mapWithKeys(
            fn (string $vehicleStatus) => [$vehicleStatus => (clone $baseQuery)->where('status', $vehicleStatus)->count()],
        );
        $vehicles = (clone $baseQuery)
            ->with(['deliveryMan', 'vehicleType', 'category'])
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($vehicleTypeId, fn ($query) => $query->where('ride_vehicle_type_id', $vehicleTypeId))
            ->when($categoryId, fn ($query) => $query->where('ride_category_id', $categoryId))
            ->when($fuelType, fn ($query) => $query->where('fuel_type', $fuelType))
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
        $types = RideVehicleType::query()->with(['categories' => fn ($query) => $query->orderBy('sort_order')])->orderBy('sort_order')->get();
        $routePrefix = $this->vehicleRoutePrefix($request);

        return view('admin-views.ride-hailing.vehicles.index', compact(
            'vehicles', 'search', 'status', 'statusCounts', 'types', 'vehicleTypeId', 'categoryId', 'fuelType', 'routePrefix',
        ));
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

    public function createVehicle(Request $request): View
    {
        $types = RideVehicleType::query()->where('status', true)->with(['categories' => fn ($q) => $q->where('status', true)->orderBy('sort_order')])->orderBy('sort_order')->get();
        $routePrefix = $this->vehicleRoutePrefix($request);

        return view('admin-views.ride-hailing.vehicles.create', compact('types', 'routePrefix'));
    }

    public function searchRiders(Request $request): JsonResponse
    {
        $term = trim((string) $request->input('q'));
        $riders = DeliveryMan::withoutGlobalScopes()
            ->withCount('rideVehicles')
            ->where('application_status', 'approved')
            ->where('status', 1)
            ->when(auth('admin')->user()?->zone_id, fn ($query, $zoneId) => $query->where('zone_id', $zoneId))
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
            'text' => trim("{$rider->f_name} {$rider->l_name}")." ({$rider->phone}) - {$rider->ride_vehicles_count}/2",
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
            'model_year' => ['nullable', 'integer', 'min:1980', 'max:'.(now()->year + 1)],
            'color' => ['required', 'string', 'max:50'],
            'registration_number' => ['required', 'string', 'max:80', 'unique:ride_vehicles,registration_number'],
            'vehicle_front_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'vehicle_back_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['required', Rule::in(['pending'])],
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
            $rider = DeliveryMan::withoutGlobalScopes()->lockForUpdate()->findOrFail($validated['delivery_man_id']);
            $adminZoneId = auth('admin')->user()?->zone_id;
            abort_if($adminZoneId && (int) $rider->zone_id !== (int) $adminZoneId, 404);
            if (RideVehicle::query()->where('delivery_man_id', $validated['delivery_man_id'])->count() >= RideVehicle::MAX_PER_RIDER) {
                throw ValidationException::withMessages(['delivery_man_id' => translate('messages.A rider can register a maximum of two ride vehicles.')]);
            }

            $frontImage = \App\CentralLogics\Helpers::upload('ride-vehicle/', 'png', $validated['vehicle_front_image']);
            $backImage = \App\CentralLogics\Helpers::upload('ride-vehicle/', 'png', $validated['vehicle_back_image']);
            unset($validated['vehicle_front_image'], $validated['vehicle_back_image']);
            RideVehicle::create([
                ...$validated,
                'registration_number' => strtoupper(trim($validated['registration_number'])),
                'front_image' => $frontImage,
                'front_image_storage' => \App\CentralLogics\Helpers::getDisk(),
                'back_image' => $backImage,
                'back_image_storage' => \App\CentralLogics\Helpers::getDisk(),
                'is_active' => false,
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]);
        });

        return redirect()->route($this->vehicleRoutePrefix($request).'.index')->with('success', translate('messages.Ride vehicle registered successfully.'));
    }

    public function showVehicle(Request $request, RideVehicle $vehicle): View
    {
        $vehicle = $this->vehicleAdminQuery()
            ->with(['deliveryMan.zone', 'vehicleType', 'category', 'reviewer', 'reviewAudits.reviewer'])
            ->findOrFail($vehicle->id);
        $routePrefix = $this->vehicleRoutePrefix($request);

        return view('admin-views.ride-hailing.vehicles.show', compact('vehicle', 'routePrefix'));
    }

    public function reviewVehicle(Request $request, RideVehicle $vehicle): RedirectResponse
    {
        $validated = $request->validate([
            'decision' => ['required', Rule::in(['approved', 'rejected'])],
            'admin_note' => ['nullable', 'string', 'max:1000', Rule::requiredIf($request->input('decision') === 'rejected')],
        ]);
        $this->updateVehicleReview($vehicle->id, $validated['decision'], $validated['admin_note'] ?? null);

        return back()->with('success', translate('messages.Ride vehicle review saved.'));
    }

    public function vehicleStatus(Request $request, RideVehicle $vehicle): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(RideVehicle::STATUSES)],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);
        $this->updateVehicleReview($vehicle->id, $validated['status'], $validated['admin_note'] ?? null);

        return back()->with('success', translate('messages.Ride vehicle status updated.'));
    }

    public function activateVehicle(RideVehicle $vehicle): RedirectResponse
    {
        $activated = DB::transaction(function () use ($vehicle): bool {
            $vehicle = $this->vehicleAdminQuery()->lockForUpdate()->findOrFail($vehicle->id);
            if ($vehicle->status !== 'approved') {
                return false;
            }
            RideVehicle::query()->where('delivery_man_id', $vehicle->delivery_man_id)->update(['is_active' => false]);
            $vehicle->update(['is_active' => true]);

            return true;
        });
        if (! $activated) {
            return back()->with('error', translate('messages.Only an approved ride vehicle can be activated.'));
        }

        return back()->with('success', translate('messages.Active ride vehicle updated.'));
    }

    private function updateVehicleReview(int $vehicleId, string $status, ?string $adminNote): void
    {
        DB::transaction(function () use ($vehicleId, $status, $adminNote): void {
            $vehicle = $this->vehicleAdminQuery()->lockForUpdate()->findOrFail($vehicleId);
            $fromStatus = $vehicle->status;
            $vehicle->status = $status;
            $vehicle->admin_note = filled($adminNote) ? trim((string) $adminNote) : null;
            $vehicle->reviewed_by = auth('admin')->id();
            $vehicle->reviewed_at = now();
            if ($status !== 'approved') {
                $vehicle->is_active = false;
            }
            $vehicle->save();
            $this->recordVehicleReview($vehicle, $fromStatus, $status, $vehicle->admin_note);
        });
    }

    private function recordVehicleReview(RideVehicle $vehicle, string $fromStatus, string $toStatus, ?string $adminNote): void
    {
        RideVehicleReviewAudit::query()->create([
            'ride_vehicle_id' => $vehicle->id,
            'admin_id' => auth('admin')->id(),
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'admin_note' => $adminNote,
            'reviewed_at' => now(),
        ]);
    }

    private function vehicleAdminQuery()
    {
        $adminZoneId = auth('admin')->user()?->zone_id;

        return RideVehicle::query()->when($adminZoneId, fn ($query) => $query
            ->whereHas('deliveryMan', fn ($rider) => $rider->where('zone_id', $adminZoneId)));
    }

    private function vehicleRoutePrefix(Request $request): string
    {
        return $request->routeIs('admin.users.delivery-man.ride-vehicles.*')
            ? 'admin.users.delivery-man.ride-vehicles'
            : 'admin.ride-hailing.vehicles';
    }
}
