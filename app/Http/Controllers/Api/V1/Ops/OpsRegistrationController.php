<?php

namespace App\Http\Controllers\Api\V1\Ops;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Module;
use App\Models\OnboardingApplication;
use App\Models\Zone;
use App\Services\OpsOnboardingMediaService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OpsRegistrationController extends Controller
{
    public function __construct(private readonly OpsOnboardingMediaService $mediaService) {}

    public function reference(): JsonResponse
    {
        $modules = Module::query()
            ->active()
            ->commerce()
            ->notParcel()
            ->orderBy('module_name')
            ->get(['id', 'module_name'])
            ->map(fn (Module $module) => [
                'id' => (string) $module->id,
                'name' => $module->module_name,
            ])
            ->values();

        return response()->json([
            'modules' => $modules,
            'services' => array_values(config('ops.onboarding_services', [])),
            'delivery_time_options' => array_values(config('ops.delivery_time_options', [])),
            'validation_policy' => array_merge(config('ops.validation', []), [
                'maximum_menu_photos' => (int) config('ops.media.maximum_menu_photos', 8),
                'maximum_photo_size_kb' => (int) config('ops.media.maximum_size_kb', 2048),
            ]),
            'currency' => 'PKR',
        ]);
    }

    public function draft(Request $request): JsonResponse
    {
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $maximumAge = max(1, (int) config('ops.validation.draft_max_age_days', 30));
        $application = OnboardingApplication::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', OnboardingApplication::STATUS_DRAFT)
            ->where('updated_at', '>=', now()->subDays($maximumAge))
            ->latest('updated_at')
            ->first();

        if (! $application || ! is_array($application->draft_payload)) {
            return response()->json(['data' => null]);
        }

        return response()->json(['data' => $this->draftPayload($application, $manager)]);
    }

    public function saveDraft(Request $request): JsonResponse
    {
        if (strlen((string) $request->getContent()) > 262144) {
            return response()->json([
                'code' => 'draft_too_large',
                'message' => 'The registration draft is too large.',
            ], 413);
        }

        $validated = $request->validate([
            'draft' => ['required', 'array'],
            'draft.schema_version' => ['required', 'integer', 'in:1'],
            'draft.updated_at' => ['required', 'date'],
            'draft.current_step' => ['required', 'integer', 'between:0,3'],
            'draft.first_name' => ['nullable', 'string', 'max:100'],
            'draft.last_name' => ['nullable', 'string', 'max:100'],
            'draft.email' => ['nullable', 'email', 'max:255'],
            'draft.phone' => ['nullable', 'string', 'max:30'],
            'draft.include_tax_details' => ['nullable', 'boolean'],
            'draft.tin' => ['nullable', 'string', 'max:255'],
            'draft.tin_expiry' => ['nullable', 'date'],
            'draft.store_name' => ['nullable', 'string', 'max:255'],
            'draft.module_id' => ['nullable', 'integer'],
            'draft.minimum_delivery_time' => ['nullable', 'integer', 'min:1', 'max:999'],
            'draft.maximum_delivery_time' => ['nullable', 'integer', 'min:1', 'max:999'],
            'draft.delivery_time_type' => ['nullable', Rule::in(['min', 'hours', 'days'])],
            'draft.address' => ['nullable', 'string', 'max:2000'],
            'draft.place_id' => ['nullable', 'string', 'max:255'],
            'draft.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'draft.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'draft.resolved_zone' => ['nullable', 'string', 'max:255'],
            'draft.resolved_zone_id' => ['nullable', 'integer'],
            'draft.services' => ['nullable', 'array', 'max:25'],
            'draft.services.*.id' => ['required_with:draft.services', 'string', 'max:100'],
            'draft.services.*.quantity' => ['required_with:draft.services', 'integer', 'min:1', 'max:999'],
            'draft.services.*.unit_price' => ['required_with:draft.services', 'integer', 'min:0'],
            'draft.services.*.selected' => ['required_with:draft.services', 'boolean'],
            'draft.due_date' => ['nullable', 'date'],
            'draft.invoice_note' => ['nullable', 'string', 'max:2000'],
            'draft.media' => ['nullable', 'array', 'max:20'],
            'draft.submission_key' => ['nullable', 'string', 'max:150'],
        ]);

        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $draft = $validated['draft'];
        $expectedRevision = $this->expectedRevision($request);

        $application = DB::transaction(function () use ($manager, $draft, $expectedRevision) {
            Admin::query()->whereKey($manager->id)->lockForUpdate()->firstOrFail();
            $application = OnboardingApplication::query()
                ->where('onboarding_manager_id', $manager->id)
                ->where('status', OnboardingApplication::STATUS_DRAFT)
                ->latest('updated_at')
                ->lockForUpdate()
                ->first();

            if (($application && $expectedRevision !== $application->draft_revision)
                || (! $application && $expectedRevision > 0)) {
                throw new HttpResponseException(response()->json([
                    'code' => 'draft_conflict',
                    'message' => 'This registration draft changed on another device. Reload it before saving.',
                    'current_revision' => $application?->draft_revision ?? 0,
                ], 409));
            }

            $module = ! empty($draft['module_id'])
                ? Module::query()->active()->commerce()->notParcel()->find($draft['module_id'])
                : null;
            $zone = ! empty($draft['resolved_zone_id'])
                ? Zone::query()->active()->find($draft['resolved_zone_id'])
                : null;
            $nextRevision = ($application?->draft_revision ?? 0) + 1;
            $serverNow = now();
            $serverPayload = [
                ...$draft,
                'manager_id' => $manager->id,
                'updated_at' => $serverNow->copy()->utc()->toIso8601String(),
                'server_revision' => $nextRevision,
                'has_local_changes' => false,
            ];

            $values = [
                'onboarding_manager_id' => $manager->id,
                'status' => OnboardingApplication::STATUS_DRAFT,
                'draft_revision' => $nextRevision,
                'draft_payload' => $serverPayload,
                'last_draft_synced_at' => $serverNow,
                'manager_name_snapshot' => trim($manager->f_name.' '.$manager->l_name),
                'manager_email_snapshot' => $manager->email,
                'commission_rate_snapshot' => $manager->onboarding_commission_percent,
                'owner_first_name' => $draft['first_name'] ?? null,
                'owner_last_name' => $draft['last_name'] ?? null,
                'owner_email' => $draft['email'] ?? null,
                'owner_phone' => $draft['phone'] ?? null,
                'owner_tin' => ($draft['include_tax_details'] ?? false) ? ($draft['tin'] ?? null) : null,
                'owner_tin_expire_date' => ($draft['include_tax_details'] ?? false) ? ($draft['tin_expiry'] ?? null) : null,
                'store_name' => $draft['store_name'] ?? null,
                'module_id' => $module?->id,
                'module_name_snapshot' => $module?->module_name,
                'zone_id' => $zone?->id,
                'zone_name_snapshot' => $zone?->name,
                'formatted_address' => $draft['address'] ?? null,
                'latitude' => $draft['latitude'] ?? null,
                'longitude' => $draft['longitude'] ?? null,
                'place_id' => $draft['place_id'] ?? null,
                'delivery_time_min' => $draft['minimum_delivery_time'] ?? null,
                'delivery_time_max' => $draft['maximum_delivery_time'] ?? null,
                'delivery_time_unit' => $draft['delivery_time_type'] ?? null,
            ];

            if (! $application) {
                $application = OnboardingApplication::create([
                    'reference' => 'OPS-'.Str::upper((string) Str::ulid()),
                    ...$values,
                ]);
            } else {
                $application->update($values);
            }

            $serverPayload['server_id'] = (string) $application->id;
            $application->update(['draft_payload' => $serverPayload]);
            $this->mediaService->associateDraftMedia($serverPayload, $manager, $application);

            return $application->fresh();
        });

        return response()->json(['data' => $this->draftPayload($application, $manager)]);
    }

    private function expectedRevision(Request $request): int
    {
        $header = trim((string) $request->header('If-Match'), " \t\n\r\0\x0B\"");

        return ctype_digit($header) ? (int) $header : 0;
    }

    private function draftPayload(OnboardingApplication $application, Admin $manager): array
    {
        return $this->mediaService->refreshDraftUrls([
            ...(is_array($application->draft_payload) ? $application->draft_payload : []),
            'schema_version' => 1,
            'manager_id' => $manager->id,
            'server_id' => (string) $application->id,
            'server_revision' => $application->draft_revision,
            'has_local_changes' => false,
            'updated_at' => $application->last_draft_synced_at?->copy()->utc()->toIso8601String()
                ?? $application->updated_at->copy()->utc()->toIso8601String(),
        ], $manager);
    }
}
