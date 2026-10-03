<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnboardingApplication;
use App\Services\OpsOnboardingReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OnboardingApplicationController extends Controller
{
    private function query()
    {
        return OnboardingApplication::query()->where('status', '!=', 'draft')
            ->when(auth('admin')->user()->zone_id, fn ($q, $zone) => $q->where('zone_id', $zone));
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::in(OnboardingApplication::STATUSES)],
            'search' => ['nullable', 'string', 'max:150'],
            'manager_id' => ['nullable', 'integer'],
        ]);
        $counts = $this->query()->selectRaw('status, COUNT(*) AS total')->groupBy('status')->pluck('total', 'status');
        $applications = $this->query()->with('invoice')
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->when($filters['manager_id'] ?? null, fn ($q, $id) => $q->where('onboarding_manager_id', $id))
            ->when($filters['search'] ?? null, fn ($q, $search) => $q->where(fn ($q) => $q
                ->where('reference', 'like', "%{$search}%")->orWhere('store_name', 'like', "%{$search}%")
                ->orWhere('owner_email', 'like', "%{$search}%")->orWhere('manager_name_snapshot', 'like', "%{$search}%")))
            ->latest('id')->paginate(20)->withQueryString();

        return view('admin-views.onboarding-application.index', compact('applications', 'counts'));
    }

    public function show(int $application)
    {
        $application = $this->query()->with(['media' => fn ($q) => $q->where('status', 'attached')->orderBy('sort_order'), 'invoice', 'dataEntryStaff'])->findOrFail($application);
        $history = $application->statusHistory()->latest('id')->paginate(15, ['*'], 'history_page')->withQueryString();
        $deliveries = $application->invoice?->deliveries()->latest('id')->paginate(15, ['*'], 'mail_page')->withQueryString();

        return view('admin-views.onboarding-application.show', compact('application', 'history', 'deliveries'));
    }

    public function media(int $application, int $media)
    {
        $application = $this->query()->findOrFail($application);
        $media = $application->media()->where('status', 'attached')->findOrFail($media);
        abort_unless(in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/webp'], true), 404);

        return Storage::disk($media->disk)->response($media->path, 'photo', [
            'Content-Type' => $media->mime_type,
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function review(Request $request, int $application, OpsOnboardingReviewService $service)
    {
        $application = $this->query()->findOrFail($application);
        $data = $request->validate([
            'action' => ['required', Rule::in(['correction', 'reject'])],
            'note' => ['required', 'string', 'max:2000'],
            'expected_status' => ['required', Rule::in(OnboardingApplication::STATUSES)],
        ]);
        $service->review($application, auth('admin')->user(), $data['action'], $data['note'], $data['expected_status']);

        return back()->with('review_success', 'Review saved. The note is visible in the manager application timeline.');
    }

    public function dataQueue(Request $request)
    {
        $request->validate(['stage' => ['nullable', Rule::in(['data_pending', 'data_entry', 'review_pending'])], 'mine' => ['nullable', 'boolean']]);
        $applications = $this->query()->where('status', $request->input('stage', 'data_pending'))
            ->whereHas('invoice', fn ($q) => $q->where('payment_status', 'paid')->whereNull('voided_at'))
            ->when($request->boolean('mine'), fn ($q) => $q->where('data_entry_admin_id', auth('admin')->id()))
            ->with(['invoice', 'dataEntryStaff'])->oldest('id')->paginate(20)->withQueryString();

        return view('admin-views.onboarding-application.data-queue', compact('applications'));
    }

    public function dataEntry(Request $request, int $application, \App\Services\OpsDataEntryService $service)
    {
        $application = $this->query()->findOrFail($application);
        $data = $request->validate([
            'action' => ['required', Rule::in(['assign', 'complete'])],
            'expected_status' => ['required', Rule::in(['data_pending', 'data_entry'])],
            'assignee' => ['required_if:action,assign', 'nullable', 'integer', 'exists:admins,id'],
            'note' => ['required', 'string', 'max:2000'],
            'catalog_checked' => ['required_if:action,complete', 'accepted'],
            'store_checked' => ['required_if:action,complete', 'accepted'],
        ]);
        $service->handle($application, auth('admin')->user(), $data['action'], $data['note'], $data['expected_status'], isset($data['assignee']) ? (int) $data['assignee'] : null);

        return back()->with('review_success', 'Data-entry workflow updated.');
    }

    public function approve(int $application, \App\Services\OpsOnboardingApprovalService $service)
    {
        $application = $this->query()->findOrFail($application);
        $service->approve($application, auth('admin')->user());

        return back()->with('review_success', 'Store approved. Password setup email queued.');
    }
}
