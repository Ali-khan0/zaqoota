<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\RideCancellationReason;
use App\Models\RideRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RideCancellationReasonController extends Controller
{
    public function index(?RideCancellationReason $reason = null): View
    {
        return view('admin-views.ride-hailing.cancellation-reasons.index', [
            'reasons' => RideCancellationReason::query()->orderBy('user_type')->orderBy('display_order')->paginate(25),
            'reason' => $reason?->exists ? $reason->load('translations') : null,
            'languages' => Helpers::get_business_settings('language') ?: [],
            'statuses' => $this->statuses(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $reason = RideCancellationReason::query()->create($data);
        $this->translations($request, $reason);

        return back()->with('success', translate('messages.Ride cancellation reason created successfully.'));
    }

    public function edit(RideCancellationReason $reason): View
    {
        return $this->index($reason);
    }

    public function update(Request $request, RideCancellationReason $reason): RedirectResponse
    {
        $reason->update($this->validated($request, $reason));
        $this->translations($request, $reason);

        return redirect()->route('admin.ride-hailing.cancellation-reasons.index')
            ->with('success', translate('messages.Ride cancellation reason updated successfully.'));
    }

    public function status(RideCancellationReason $reason): RedirectResponse
    {
        $reason->update(['status' => ! $reason->status]);

        return back()->with('success', translate('messages.Ride cancellation reason status updated.'));
    }

    public function destroy(RideCancellationReason $reason): RedirectResponse
    {
        $reason->translations()->delete();
        $reason->delete();

        return back()->with('success', translate('messages.Ride cancellation reason deleted successfully.'));
    }

    private function validated(Request $request, ?RideCancellationReason $reason = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'array'],
            'title.0' => ['required', 'string', 'max:255'],
            'title.*' => ['nullable', 'string', 'max:255'],
            'lang' => ['required', 'array'],
            'code' => [$reason ? 'nullable' : 'required', 'string', 'max:80', 'regex:/^[a-z0-9_]+$/', Rule::unique('ride_cancellation_reasons', 'code')->ignore($reason?->id)],
            'user_type' => ['required', Rule::in(RideCancellationReason::ACTORS)],
            'ride_statuses' => ['required', 'array', 'min:1'],
            'ride_statuses.*' => [Rule::in($this->statuses())],
            'display_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
        $defaultIndex = array_search('default', $data['lang'], true);
        $defaultIndex = $defaultIndex === false ? 0 : $defaultIndex;

        return [
            'code' => $reason?->code ?? strtolower($data['code']),
            'title' => $data['title'][$defaultIndex] ?? $data['title'][0],
            'user_type' => $data['user_type'],
            'ride_statuses' => array_values(array_unique($data['ride_statuses'])),
            'display_order' => $data['display_order'],
            'status' => $reason?->status ?? true,
        ];
    }

    private function translations(Request $request, RideCancellationReason $reason): void
    {
        foreach ($request->input('lang', []) as $index => $locale) {
            if ($locale === 'default' || ! filled($request->input("title.{$index}"))) {
                continue;
            }
            $reason->translations()->updateOrCreate(
                ['locale' => $locale, 'key' => 'title'],
                ['value' => $request->input("title.{$index}")]
            );
        }
    }

    private function statuses(): array
    {
        return [
            RideRequest::STATUS_SEARCHING,
            RideRequest::STATUS_NEGOTIATING,
            RideRequest::STATUS_RIDER_SELECTED,
            RideRequest::STATUS_CAPTAIN_ARRIVING,
            RideRequest::STATUS_ARRIVED,
        ];
    }
}
