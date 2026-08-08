<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\RideCoupon;
use App\Models\RidePushNotification;
use App\Models\Zone;
use App\Traits\NotificationTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RidePushNotificationController extends Controller
{
    use NotificationTrait;

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $notifications = RidePushNotification::query()->with('zone:id,name')
            ->when($this->adminZoneId(), fn ($query, $zoneId) => $query->where('zone_id', $zoneId))
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->latest('id')->paginate(20)->withQueryString();

        return view('admin-views.ride-hailing.push-notifications.index', ['notifications' => $notifications, 'search' => $search,
            'zones' => Zone::query()->where('status', 1)->when($this->adminZoneId(), fn ($query, $id) => $query->whereKey($id))->orderBy('name')->get(['id', 'name']),
            'coupons' => RideCoupon::query()->where('status', true)->orderBy('title')->get(['code', 'title'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $data['image'] = Helpers::upload('ride-promotion/', 'png', $request->file('image'));
            $data['image_storage'] = Helpers::getDisk();
        }
        $notification = RidePushNotification::query()->create($data);
        $this->send($notification);

        return back()->with('success', translate('messages.Ride notification created and sent.'));
    }

    public function resend(RidePushNotification $notification): RedirectResponse
    {
        $this->authorizeZone($notification->zone_id);
        $this->send($notification);

        return back()->with('success', translate('messages.Ride notification sent again.'));
    }

    public function status(RidePushNotification $notification): RedirectResponse
    {
        $this->authorizeZone($notification->zone_id);
        $notification->update(['status' => ! $notification->status]);

        return back()->with('success', translate('messages.Ride notification feed status updated.'));
    }

    public function destroy(RidePushNotification $notification): RedirectResponse
    {
        $this->authorizeZone($notification->zone_id);
        if ($notification->image) {
            Helpers::check_and_delete('ride-promotion/', $notification->image);
        }
        $notification->delete();

        return back()->with('success', translate('messages.Ride notification deleted successfully.'));
    }

    private function validated(Request $request): array
    {
        $adminZoneId = $this->adminZoneId();
        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'], 'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'zone_id' => ['nullable', 'integer', Rule::exists('zones', 'id')->when($adminZoneId, fn ($rule) => $rule->where('id', $adminZoneId))],
            'action_type' => ['required', Rule::in(['ride_home', 'coupon', 'url'])],
            'action_value' => ['nullable', 'string', 'max:1000', Rule::requiredIf(in_array($request->action_type, ['coupon', 'url'], true))],
        ]);
        if ($data['action_type'] === 'coupon') {
            $data['action_value'] = strtoupper(trim($data['action_value']));
            validator($data, ['action_value' => ['exists:ride_coupons,code']])->validate();
        }
        if ($data['action_type'] === 'url') {
            validator($data, ['action_value' => ['url', 'starts_with:https://']])->validate();
        }
        $data['zone_id'] = $adminZoneId ?: ($data['zone_id'] ?? null);
        $data['action_value'] = $data['action_type'] === 'ride_home' ? null : $data['action_value'];

        return $data;
    }

    private function send(RidePushNotification $notification): void
    {
        $topic = $notification->zone_id ? 'zone_'.$notification->zone_id.'_customer' : 'all_zone_customer';
        $payload = ['message' => ['topic' => $topic, 'data' => [
            'title' => (string) $notification->title, 'body' => (string) $notification->description,
            'type' => 'ride_promotion', 'image' => (string) $notification->image_full_url,
            'action_type' => (string) $notification->action_type, 'action_value' => (string) ($notification->action_value ?? ''),
            'zone_id' => (string) ($notification->zone_id ?? ''), 'sound' => 'notification.wav',
        ], 'notification' => ['title' => (string) $notification->title, 'body' => (string) $notification->description, 'image' => (string) $notification->image_full_url],
            'android' => ['notification' => ['channelId' => '6ammart']], 'apns' => ['payload' => ['aps' => ['sound' => 'notification.wav']]]]];
        try {
            self::sendNotificationToHttp($payload);
            $notification->update(['delivery_status' => 'attempted', 'sent_at' => now()]);
        } catch (\Throwable $exception) {
            report($exception);
            $notification->update(['delivery_status' => 'failed']);
        }
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
