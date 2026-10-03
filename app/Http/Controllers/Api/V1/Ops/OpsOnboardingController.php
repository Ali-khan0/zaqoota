<?php

namespace App\Http\Controllers\Api\V1\Ops;

use App\Http\Controllers\Controller;
use App\Jobs\SendOpsOnboardingReminder;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\OnboardingInvoice;
use App\Models\OpsOnboardingReminderRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OpsOnboardingController extends Controller
{
    public function summary(Request $request): JsonResponse
    {
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $query = $this->ownedApplications($manager)->where('status', '!=', OnboardingApplication::STATUS_DRAFT);

        return response()->json([
            'counts' => [
                'total' => (clone $query)->count(),
                'payment_pending' => (clone $query)->whereIn('status', [
                    OnboardingApplication::STATUS_INVOICE_SENT,
                    OnboardingApplication::STATUS_PAYMENT_PENDING,
                    OnboardingApplication::STATUS_PAYMENT_FAILED,
                ])->count(),
                'data_pending' => (clone $query)->whereIn('status', [
                    OnboardingApplication::STATUS_DATA_PENDING,
                    OnboardingApplication::STATUS_DATA_ENTRY,
                    OnboardingApplication::STATUS_REVIEW_PENDING,
                ])->count(),
            ],
            'recent' => (clone $query)
                ->with(['invoice', 'store'])
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(fn (OnboardingApplication $application) => $this->summaryPayload($application))
                ->values(),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in([
                OnboardingApplication::STATUS_PAYMENT_PENDING,
                OnboardingApplication::STATUS_DATA_PENDING,
                OnboardingApplication::STATUS_APPROVED,
                OnboardingApplication::STATUS_REJECTED,
            ])],
            'sort' => ['nullable', Rule::in(['newest', 'oldest', 'name'])],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'between:1,50'],
        ]);
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $search = trim((string) ($validated['search'] ?? ''));
        $query = $this->ownedApplications($manager)
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->with(['invoice', 'store'])
            ->when($search !== '', fn (Builder $builder) => $builder->where(function (Builder $nested) use ($search) {
                $nested->where('store_name', 'like', "%{$search}%")
                    ->orWhere('owner_first_name', 'like', "%{$search}%")
                    ->orWhere('owner_last_name', 'like', "%{$search}%")
                    ->orWhere('owner_email', 'like', "%{$search}%")
                    ->orWhere('formatted_address', 'like', "%{$search}%");
            }))
            ->when(isset($validated['status']), fn (Builder $builder) => $this->applyStatusFilter($builder, $validated['status']))
            ->when(
                ($validated['sort'] ?? 'newest') === 'oldest',
                fn (Builder $builder) => $builder->oldest('created_at'),
                fn (Builder $builder) => ($validated['sort'] ?? 'newest') === 'name'
                    ? $builder->orderBy('store_name')
                    : $builder->latest('created_at'),
            );
        $paginator = $query->paginate((int) ($validated['per_page'] ?? 20));

        return response()->json([
            'data' => collect($paginator->items())
                ->map(fn (OnboardingApplication $application) => $this->summaryPayload($application))
                ->values(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    public function show(Request $request, int $onboarding): JsonResponse
    {
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $application = $this->ownedApplications($manager)
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->with([
                'store',
                'invoice.items',
                'invoice.events',
                'invoice.deliveries' => fn ($query) => $query->latest('id'),
                'statusHistory' => fn ($query) => $query->oldest('created_at'),
            ])
            ->findOrFail($onboarding);
        $invoice = $application->invoice;
        $cooldownMinutes = max(1, (int) config('ops.reminder_cooldown_minutes', 5));
        $nextReminderAt = $invoice?->last_reminder_at?->copy()->addMinutes($cooldownMinutes);
        $timeline = collect($application->statusHistory)->map(fn ($history) => [
            'title' => $this->statusTitle($history->to_status),
            'detail' => $history->note ?: 'Application status updated.',
            'occurred_at' => $history->created_at?->toIso8601String(),
            'complete' => true,
        ]);
        if ($invoice) {
            $timeline = $timeline->concat($invoice->events->map(fn ($event) => [
                'title' => $this->statusTitle($event->event_type),
                'detail' => $event->description,
                'occurred_at' => $event->created_at?->toIso8601String(),
                'complete' => true,
            ]));
        }
        if ($timeline->isEmpty()) {
            $timeline->push([
                'title' => 'Submitted',
                'detail' => 'Onboarding application received.',
                'occurred_at' => ($application->submitted_at ?? $application->created_at)?->toIso8601String(),
                'complete' => true,
            ]);
        }

        return response()->json(['data' => [
            ...$this->summaryPayload($application),
            'phone' => $application->owner_phone,
            'email' => $application->owner_email,
            'business_type' => $application->module_name_snapshot,
            'resolved_zone' => $application->zone_name_snapshot,
            'delivery_time' => $this->deliveryTime($application),
            'invoice_due_at' => $invoice?->due_date?->toDateString(),
            'next_reminder_at' => $nextReminderAt?->toIso8601String(),
            'invoice' => $invoice ? [
                'number' => $invoice->invoice_number,
                'amount' => (float) $invoice->amount,
                'due_at' => $invoice->due_date?->toDateString(),
                'payment_status' => $invoice->payment_status,
                'send_status' => $invoice->send_status,
                'delivery_history' => $invoice->deliveries->map(fn ($delivery) => [
                    'id' => $delivery->id,
                    'type' => $delivery->delivery_type,
                    'recipient' => $delivery->recipient_email,
                    'status' => $delivery->status,
                    'attempt_count' => $delivery->attempt_count,
                    'manager_name' => $delivery->sent_by_name,
                    'last_attempt_at' => $delivery->last_attempt_at?->toIso8601String(),
                    'sent_at' => $delivery->sent_at?->toIso8601String(),
                ])->values(),
                'items' => $invoice->items->map(fn ($item) => [
                    'description' => $item->description,
                    'quantity' => (float) $item->quantity,
                    'unit_price' => (float) $item->unit_price,
                    'line_total' => (float) $item->line_total,
                ])->values(),
            ] : null,
            'timeline' => $timeline->sortBy('occurred_at')->values(),
        ]]);
    }

    public function remind(Request $request, int $onboarding): JsonResponse
    {
        $validated = $request->validate([
            'idempotency_key' => ['required', 'string', 'min:16', 'max:150'],
        ]);
        $headerKey = (string) $request->header('Idempotency-Key');
        if ($headerKey === '' || ! hash_equals($validated['idempotency_key'], $headerKey)) {
            return response()->json([
                'code' => 'idempotency_key_mismatch',
                'message' => 'The Idempotency-Key header and request value must match.',
            ], 422);
        }

        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $hash = hash('sha256', $validated['idempotency_key']);
        $processed = OpsOnboardingReminderRequest::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('idempotency_key_hash', $hash)
            ->first();
        if ($processed) {
            if ((int) $processed->onboarding_application_id !== $onboarding) {
                return response()->json([
                    'code' => 'idempotency_key_reused',
                    'message' => 'This idempotency key was already used for another onboarding.',
                ], 409);
            }

            return response()->json([
                'message' => 'Payment reminder already processed.',
                'next_allowed_at' => $processed->next_allowed_at->toIso8601String(),
                'delivery_status' => $processed->status,
                'already_processed' => true,
            ]);
        }

        return DB::transaction(function () use ($manager, $onboarding, $hash): JsonResponse {
            $application = $this->ownedApplications($manager)
                ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
                ->lockForUpdate()
                ->findOrFail($onboarding);
            $invoice = $application->invoices()->latest('id')->lockForUpdate()->first();
            if (! $invoice) {
                return response()->json(['code' => 'invoice_missing', 'message' => 'This onboarding does not have an invoice yet.'], 422);
            }
            if ($invoice->voided_at || $invoice->payment_status === OnboardingInvoice::PAYMENT_PAID) {
                return response()->json(['code' => 'reminder_not_allowed', 'message' => 'Only active unpaid invoices can receive reminders.'], 422);
            }

            $existing = OpsOnboardingReminderRequest::query()
                ->where('onboarding_manager_id', $manager->id)
                ->where('idempotency_key_hash', $hash)
                ->first();
            if ($existing) {
                return response()->json([
                    'message' => 'Payment reminder already processed.',
                    'next_allowed_at' => $existing->next_allowed_at->toIso8601String(),
                    'delivery_status' => $existing->status,
                    'already_processed' => true,
                ]);
            }

            $cooldownMinutes = max(1, (int) config('ops.reminder_cooldown_minutes', 5));
            $nextAllowedAt = $invoice->last_reminder_at?->copy()->addMinutes($cooldownMinutes);
            if ($nextAllowedAt?->isFuture()) {
                throw new HttpResponseException(response()->json([
                    'code' => 'reminder_cooldown',
                    'message' => 'Please wait before sending another reminder.',
                    'errors' => ['next_allowed_at' => [$nextAllowedAt->toIso8601String()]],
                ], 429));
            }

            $actorName = trim($manager->f_name.' '.$manager->l_name) ?: $manager->email;
            $queuedAt = now();
            $nextAllowedAt = $queuedAt->copy()->addMinutes($cooldownMinutes);
            $invoice->update(['last_reminder_at' => $queuedAt]);
            $reminderRequest = OpsOnboardingReminderRequest::create([
                'onboarding_application_id' => $application->id,
                'onboarding_manager_id' => $manager->id,
                'idempotency_key_hash' => $hash,
                'status' => OpsOnboardingReminderRequest::STATUS_QUEUED,
                'next_allowed_at' => $nextAllowedAt,
            ]);
            $invoice->events()->create([
                'event_type' => 'reminder_queued',
                'description' => 'Payment reminder queued for delivery.',
                'metadata' => ['reminder_request_id' => $reminderRequest->id],
                'admin_id' => $manager->id,
                'admin_name' => $actorName,
            ]);
            SendOpsOnboardingReminder::dispatch($reminderRequest->id);

            return response()->json([
                'message' => 'Payment reminder queued successfully.',
                'next_allowed_at' => $nextAllowedAt->toIso8601String(),
                'delivery_status' => OpsOnboardingReminderRequest::STATUS_QUEUED,
                'already_processed' => false,
            ]);
        });
    }

    private function ownedApplications(Admin $manager): Builder
    {
        return OnboardingApplication::query()->where('onboarding_manager_id', $manager->id);
    }

    private function applyStatusFilter(Builder $query, string $status): Builder
    {
        return match ($status) {
            OnboardingApplication::STATUS_PAYMENT_PENDING => $query->whereIn('status', [
                OnboardingApplication::STATUS_INVOICE_SENT,
                OnboardingApplication::STATUS_PAYMENT_PENDING,
                OnboardingApplication::STATUS_PAYMENT_FAILED,
            ]),
            OnboardingApplication::STATUS_DATA_PENDING => $query->whereIn('status', [
                OnboardingApplication::STATUS_DATA_PENDING,
                OnboardingApplication::STATUS_DATA_ENTRY,
                OnboardingApplication::STATUS_REVIEW_PENDING,
            ]),
            default => $query->where('status', $status),
        };
    }

    private function summaryPayload(OnboardingApplication $application): array
    {
        $invoice = $application->invoice;

        return [
            'id' => $application->id,
            'store_name' => $application->store_name ?: $application->store?->name,
            'owner_name' => trim($application->owner_first_name.' '.$application->owner_last_name),
            'invoice_number' => $invoice?->invoice_number,
            'amount' => (float) ($invoice?->amount ?? 0),
            'status' => $this->mobileStatus($application->status),
            'address' => $application->formatted_address,
            'created_at' => $application->created_at?->toIso8601String(),
            'logo_url' => $application->store?->logo_full_url,
        ];
    }

    private function mobileStatus(string $status): string
    {
        return match ($status) {
            OnboardingApplication::STATUS_INVOICE_SENT,
            OnboardingApplication::STATUS_PAYMENT_PENDING,
            OnboardingApplication::STATUS_PAYMENT_FAILED => OnboardingApplication::STATUS_PAYMENT_PENDING,
            OnboardingApplication::STATUS_DATA_ENTRY,
            OnboardingApplication::STATUS_REVIEW_PENDING => OnboardingApplication::STATUS_DATA_PENDING,
            default => $status,
        };
    }

    private function deliveryTime(OnboardingApplication $application): string
    {
        if (! $application->delivery_time_min || ! $application->delivery_time_max || ! $application->delivery_time_unit) {
            return '';
        }

        return "{$application->delivery_time_min}-{$application->delivery_time_max} {$application->delivery_time_unit}";
    }

    private function statusTitle(string $status): string
    {
        return str($status)->replace('_', ' ')->title()->toString();
    }
}
