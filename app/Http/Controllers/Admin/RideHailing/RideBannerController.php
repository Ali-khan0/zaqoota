<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\RideBanner;
use App\Models\RideCategory;
use App\Models\RideCoupon;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RideBannerController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $banners = RideBanner::query()->with(['zone:id,name', 'category:id,name'])
            ->when($this->adminZoneId(), fn ($query, $zoneId) => $query->where(fn ($scope) => $scope->whereNull('zone_id')->orWhere('zone_id', $zoneId)))
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->orderBy('sort_order')->latest('id')->paginate(20)->withQueryString();

        return view('admin-views.ride-hailing.banners.index', $this->viewData($banners, $search));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = Helpers::upload('ride-promotion/', 'png', $request->file('image'));
        $data['image_storage'] = Helpers::getDisk();
        RideBanner::query()->create($data);

        return back()->with('success', translate('messages.Ride banner created successfully.'));
    }

    public function edit(RideBanner $banner): View
    {
        $this->authorizeZone($banner->zone_id);
        $banners = RideBanner::query()->with(['zone:id,name', 'category:id,name'])->latest('id')->paginate(20);

        return view('admin-views.ride-hailing.banners.index', $this->viewData($banners, '', $banner));
    }

    public function update(Request $request, RideBanner $banner): RedirectResponse
    {
        $this->authorizeZone($banner->zone_id);
        $data = $this->validated($request, false);
        if ($request->hasFile('image')) {
            $data['image'] = Helpers::update('ride-promotion/', $banner->image, 'png', $request->file('image'));
            $data['image_storage'] = Helpers::getDisk();
        }
        $banner->update($data);

        return redirect()->route('admin.ride-hailing.banners.index')->with('success', translate('messages.Ride banner updated successfully.'));
    }

    public function status(RideBanner $banner): RedirectResponse
    {
        $this->authorizeZone($banner->zone_id);
        $banner->update(['status' => ! $banner->status]);

        return back()->with('success', translate('messages.Ride banner status updated.'));
    }

    public function destroy(RideBanner $banner): RedirectResponse
    {
        $this->authorizeZone($banner->zone_id);
        Helpers::check_and_delete('ride-promotion/', $banner->image);
        $banner->delete();

        return back()->with('success', translate('messages.Ride banner deleted successfully.'));
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        $adminZoneId = $this->adminZoneId();
        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'zone_id' => ['nullable', 'integer', Rule::exists('zones', 'id')->when($adminZoneId, fn ($rule) => $rule->where('id', $adminZoneId))],
            'ride_category_id' => ['nullable', 'integer', 'exists:ride_categories,id'],
            'action_type' => ['required', Rule::in(['none', 'ride_home', 'coupon', 'url'])],
            'action_value' => ['nullable', 'string', 'max:1000', Rule::requiredIf(in_array($request->action_type, ['coupon', 'url'], true))],
            'starts_at' => ['required', 'date'],
            'expires_at' => ['required', 'date', 'after:starts_at'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
        ]);
        if (($data['action_type'] ?? null) === 'coupon') {
            $data['action_value'] = strtoupper(trim($data['action_value']));
            validator($data, ['action_value' => ['exists:ride_coupons,code']])->validate();
        }
        if (($data['action_type'] ?? null) === 'url') {
            validator($data, ['action_value' => ['url', 'starts_with:https://']])->validate();
        }
        $data['zone_id'] = $adminZoneId ?: ($data['zone_id'] ?? null);
        $data['ride_category_id'] = $data['ride_category_id'] ?? null;
        $data['action_value'] = in_array($data['action_type'], ['coupon', 'url'], true) ? $data['action_value'] : null;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function viewData($banners, string $search, ?RideBanner $banner = null): array
    {
        return ['banners' => $banners, 'search' => $search, 'banner' => $banner,
            'zones' => Zone::query()->where('status', 1)->when($this->adminZoneId(), fn ($query, $id) => $query->whereKey($id))->orderBy('name')->get(['id', 'name']),
            'categories' => RideCategory::query()->where('status', true)->orderBy('sort_order')->get(['id', 'name']),
            'coupons' => RideCoupon::query()->where('status', true)->orderBy('title')->get(['code', 'title'])];
    }

    private function adminZoneId(): ?int
    {
        return auth('admin')->user()?->zone_id;
    }

    private function authorizeZone(?int $zoneId): void
    {
        abort_if($this->adminZoneId() && $zoneId !== $this->adminZoneId(), 403);
    }
}
