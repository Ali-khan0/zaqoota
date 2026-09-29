<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\RideRequest;
use App\Services\DispatchRiderLocationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class DispatchRealtimeController extends Controller
{
    private const MODULES = ['food', 'grocery', 'pharmacy', 'ecommerce', 'parcel', 'ride_hailing'];

    private const COMMERCE_TERMINAL_STATUSES = [
        'delivered', 'failed', 'canceled', 'refund_requested', 'refund_request_canceled', 'refunded',
    ];

    public function authenticate(Request $request)
    {
        $admin = auth('admin')->user();
        abort_unless($admin instanceof Admin, 403);

        $request->setUserResolver(fn () => $admin);

        return Broadcast::auth($request);
    }

    public function feed(Request $request): JsonResponse
    {
        $module = in_array($request->query('module'), self::MODULES, true)
            ? (string) $request->query('module')
            : 'food';
        abort_unless($this->canViewModule($module), 403);
        $zoneId = $this->adminZoneId();

        if ($module === 'ride_hailing') {
            $items = $this->rideQuery($zoneId)
                ->with(['user:id,f_name,l_name,phone', 'category:id,name'])
                ->latest('id')
                ->paginate(10)
                ->withQueryString();
        } else {
            $items = $this->commerceQuery($module, $zoneId)
                ->with(['customer:id,f_name,l_name,phone', 'store:id,name', 'module:id,module_type'])
                ->latest('id')
                ->paginate(10)
                ->withQueryString();
        }

        return response()->json([
            'html' => view('admin-views.dispatch.partials.feed', compact('items', 'module'))->render(),
            'counters' => $this->counters($zoneId),
            'module' => $module,
            'latest_cursor' => max(
                (int) Order::query()->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))->max('id'),
                (int) RideRequest::query()->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))->max('id'),
            ),
        ]);
    }

    public function item(string $type, int $id): JsonResponse
    {
        $zoneId = $this->adminZoneId();
        abort_unless(in_array($type, ['commerce', 'ride'], true), 404);

        if ($type === 'ride') {
            abort_unless($this->canViewModule('ride_hailing'), 403);
            $item = RideRequest::query()
                ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))
                ->with(['user', 'deliveryMan', 'category', 'zone'])
                ->findOrFail($id);
        } else {
            $item = Order::query()
                ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))
                ->with(['customer', 'delivery_man', 'store', 'module', 'zone'])
                ->findOrFail($id);
            $module = $item->order_type === 'parcel' ? 'parcel' : (string) ($item->module?->module_type ?: 'food');
            abort_unless($this->canViewModule($module), 403);
        }

        return response()->json([
            'html' => view('admin-views.dispatch.partials.detail', compact('item', 'type'))->render(),
        ]);
    }

    public function riders(Request $request, DispatchRiderLocationService $locations): JsonResponse
    {
        abort_unless($this->canViewDispatch(), 403);
        $adminZoneId = $this->adminZoneId();
        $requestedZoneId = auth('admin')->user()?->role_id == 1 && $request->integer('zone_id')
            ? $request->integer('zone_id')
            : null;

        return response()->json($locations->snapshot($adminZoneId ?: $requestedZoneId));
    }

    public function rider(int $id, DispatchRiderLocationService $locations): JsonResponse
    {
        abort_unless($this->canViewDispatch(), 403);
        $rider = $locations->rider($id, $this->adminZoneId());
        abort_unless($rider, 404);

        return response()->json(['rider' => $rider]);
    }

    private function counters(?int $zoneId): array
    {
        $counters = [];
        foreach (array_slice(self::MODULES, 0, 5) as $module) {
            $counters[$module] = $this->canViewModule($module)
                ? $this->commerceQuery($module, $zoneId)->count()
                : null;
        }
        $counters['ride_hailing'] = $this->canViewModule('ride_hailing')
            ? $this->rideQuery($zoneId)->count()
            : null;

        return $counters;
    }

    private function commerceQuery(string $module, ?int $zoneId): Builder
    {
        return Order::query()
            ->whereIn('order_type', ['delivery', 'parcel'])
            ->whereNotIn('order_status', self::COMMERCE_TERMINAL_STATUSES)
            ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))
            ->whereHas('module', fn ($query) => $query->where('module_type', $module));
    }

    private function rideQuery(?int $zoneId): Builder
    {
        return RideRequest::query()
            ->whereIn('status', RideRequest::ACTIVE_CUSTOMER_STATUSES)
            ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId));
    }

    private function adminZoneId(): ?int
    {
        $zoneId = auth('admin')->user()?->zone_id;

        return $zoneId ? (int) $zoneId : null;
    }

    private function canViewModule(string $module): bool
    {
        $admin = auth('admin')->user();
        if (! $admin instanceof Admin) {
            return false;
        }
        if ((int) $admin->role_id === 1) {
            return true;
        }

        $permissions = json_decode((string) $admin->role?->modules, true) ?: [];
        $requiredPermission = $module === 'ride_hailing' ? 'settings' : 'order';

        return in_array($requiredPermission, $permissions, true);
    }

    private function canViewDispatch(): bool
    {
        return $this->canViewModule('food') || $this->canViewModule('ride_hailing');
    }
}
