<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\Http\Controllers\Controller;
use App\Models\RideCategory;
use App\Models\RideCoupon;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RideCouponController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $coupons = RideCoupon::query()
            ->withCount([
                'usages as reserved_uses' => fn ($query) => $query->where('status', 'reserved'),
                'usages as redeemed_uses' => fn ($query) => $query->where('status', 'redeemed'),
            ])
            ->when($search !== '', fn ($query) => $query->where(fn ($nested) => $nested
                ->where('title', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")))
            ->latest('id')->paginate(20)->withQueryString();

        return view('admin-views.ride-hailing.coupons.index', [
            'coupons' => $coupons,
            'search' => $search,
            'coupon' => null,
            'zones' => $this->zones(),
            'categories' => RideCategory::query()->where('status', true)->orderBy('sort_order')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        RideCoupon::query()->create($this->validated($request));

        return back()->with('success', translate('messages.Ride coupon created successfully.'));
    }

    public function edit(RideCoupon $coupon, Request $request): View
    {
        $coupons = RideCoupon::query()->withCount([
            'usages as reserved_uses' => fn ($query) => $query->where('status', 'reserved'),
            'usages as redeemed_uses' => fn ($query) => $query->where('status', 'redeemed'),
        ])->latest('id')->paginate(20);

        return view('admin-views.ride-hailing.coupons.index', [
            'coupons' => $coupons,
            'search' => '',
            'coupon' => $coupon,
            'zones' => $this->zones(),
            'categories' => RideCategory::query()->where('status', true)->orderBy('sort_order')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, RideCoupon $coupon): RedirectResponse
    {
        $coupon->update($this->validated($request, $coupon));

        return redirect()->route('admin.ride-hailing.coupons.index')->with('success', translate('messages.Ride coupon updated successfully.'));
    }

    public function status(RideCoupon $coupon): RedirectResponse
    {
        $coupon->update(['status' => ! $coupon->status]);

        return back()->with('success', translate('messages.Ride coupon status updated.'));
    }

    public function destroy(RideCoupon $coupon): RedirectResponse
    {
        if ($coupon->usages()->exists()) {
            return back()->with('error', translate('messages.A used Ride coupon cannot be deleted. Disable it instead.'));
        }
        $coupon->delete();

        return back()->with('success', translate('messages.Ride coupon deleted successfully.'));
    }

    public function usages(RideCoupon $coupon): View
    {
        $usages = $coupon->usages()->with(['user', 'ride'])->latest('id')->paginate(25);

        return view('admin-views.ride-hailing.coupons.usages', compact('coupon', 'usages'));
    }

    private function validated(Request $request, ?RideCoupon $coupon = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'code' => ['required', 'string', 'max:100', Rule::unique('ride_coupons', 'code')->ignore($coupon?->id)],
            'discount_type' => ['required', Rule::in(['amount', 'percent'])],
            'discount' => ['required', 'numeric', 'gt:0', $request->discount_type === 'percent' ? 'max:100' : 'max:99999999'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'min_fare' => ['nullable', 'numeric', 'min:0'],
            'zone_ids' => ['nullable', 'array'],
            'zone_ids.*' => ['integer', 'exists:zones,id'],
            'ride_category_ids' => ['nullable', 'array'],
            'ride_category_ids.*' => ['integer', 'exists:ride_categories,id'],
            'payment_methods' => ['required', 'array', 'min:1'],
            'payment_methods.*' => [Rule::in(['all', 'cash', 'digital', 'wallet'])],
            'first_ride_only' => ['nullable', 'boolean'],
            'total_limit' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['required', 'integer', 'min:1'],
            'starts_at' => ['required', 'date'],
            'expires_at' => ['required', 'date', 'after:starts_at'],
        ]);

        return [
            ...$data,
            'code' => strtoupper(trim($data['code'])),
            'max_discount' => $data['discount_type'] === 'percent' ? ($data['max_discount'] ?? 0) : 0,
            'min_fare' => $data['min_fare'] ?? 0,
            'zone_ids' => array_values($data['zone_ids'] ?? []),
            'ride_category_ids' => array_values($data['ride_category_ids'] ?? []),
            'payment_methods' => in_array('all', $data['payment_methods'], true) ? ['all'] : array_values($data['payment_methods']),
            'first_ride_only' => $request->boolean('first_ride_only'),
            'total_limit' => $data['total_limit'] ?? null,
            'status' => $coupon?->status ?? true,
        ];
    }

    private function zones()
    {
        $adminZoneId = auth('admin')->user()?->zone_id;

        return Zone::query()->where('status', 1)->when($adminZoneId, fn ($query) => $query->whereKey($adminZoneId))->orderBy('name')->get(['id', 'name']);
    }
}
