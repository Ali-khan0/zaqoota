<?php

namespace App\Http\Requests\Api\V1\Ops;

use App\Models\Module;
use App\Models\OnboardingApplication;
use App\Models\Zone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use MatanYadaev\EloquentSpatial\Objects\Point;

class OpsOnboardingSubmissionRequest extends FormRequest
{
    private ?bool $replay = null;

    protected function prepareForValidation(): void
    {
        $owner = is_array($this->input('owner')) ? $this->input('owner') : [];
        $owner['email'] = strtolower(trim((string) ($owner['email'] ?? '')));
        $owner['phone'] = trim((string) ($owner['phone'] ?? ''));
        $this->merge(['owner' => $owner]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isReplay()) {
            return ['idempotency_key' => ['required', 'string', 'min:16', 'max:150']];
        }

        return [
            'idempotency_key' => ['required', 'string', 'min:16', 'max:150'],
            'draft_id' => ['nullable', 'integer', 'min:1'],
            'draft_revision' => ['required', 'integer', 'min:0'],
            'owner' => ['required', 'array'],
            'owner.first_name' => ['required', 'string', 'min:2', 'max:100'],
            'owner.last_name' => ['nullable', 'string', 'max:100'],
            'owner.email' => ['required', 'email', 'max:255'],
            'owner.phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'],
            'owner.tin' => ['nullable', 'string', 'max:255'],
            'owner.tin_expiry' => ['nullable', 'date_format:d/m/Y'],
            'store' => ['required', 'array'],
            'store.name' => ['required', 'string', 'min:2', 'max:255'],
            'store.module_id' => [
                'required',
                'integer',
                Rule::exists('modules', 'id')->where(fn ($query) => $query
                    ->where('status', 1)
                    ->whereNotIn('module_type', ['rental', 'ride_hailing'])),
            ],
            'store.minimum_delivery_time' => ['required', 'integer', 'between:1,999'],
            'store.maximum_delivery_time' => ['required', 'integer', 'between:1,999', 'gte:store.minimum_delivery_time'],
            'store.delivery_time_type' => ['required', Rule::in(['min', 'hours', 'days'])],
            'location' => ['required', 'array'],
            'location.address' => ['required', 'string', 'max:2000'],
            'location.place_id' => ['required', 'string', 'max:255'],
            'location.latitude' => ['required', 'numeric', 'between:-90,90'],
            'location.longitude' => ['required', 'numeric', 'between:-180,180'],
            'location.zone_id' => ['required', 'integer', 'exists:zones,id'],
            'media' => ['required', 'array', 'min:5', 'max:13'],
            'media.*.id' => ['required', 'integer', 'distinct'],
            'media.*.kind' => ['required', Rule::in(['logo', 'cover', 'inside', 'outside', 'menu', 'tin_certificate'])],
            'media.*.position' => ['required', 'integer', 'min:0', 'max:99'],
            'invoice' => ['required', 'array'],
            'invoice.due_date' => ['required', 'date_format:d/m/Y'],
            'invoice.note' => ['nullable', 'string', 'max:2000'],
            'invoice.services' => ['required', 'array', 'min:1', 'max:25'],
            'invoice.services.*.service_id' => ['required', 'string', 'max:100', 'distinct'],
            'invoice.services.*.quantity' => ['required', 'integer', 'between:1,999'],
            'invoice.services.*.unit_price' => ['required', 'numeric', 'min:0', 'max:9999999999999999999999.99'],
            'confirmed' => ['accepted'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            $bodyKey = (string) $this->input('idempotency_key');
            $headerKey = (string) $this->header('Idempotency-Key');
            if ($headerKey === '' || ! hash_equals($bodyKey, $headerKey)) {
                $validator->errors()->add('idempotency_key', 'The Idempotency-Key header and request value must match.');
            }
            if ($this->isReplay()) {
                return;
            }

            $kinds = collect($this->input('media', []))->pluck('kind');
            foreach (['logo', 'cover', 'inside', 'outside', 'menu'] as $requiredKind) {
                if (! $kinds->contains($requiredKind)) {
                    $validator->errors()->add('media', "Add the required {$requiredKind} photo before submitting.");
                }
            }
            if ($kinds->filter(fn ($kind) => $kind === 'menu')->count() > (int) config('ops.media.maximum_menu_photos', 8)) {
                $validator->errors()->add('media', 'The menu photo count exceeds the current upload limit.');
            }
            foreach (['logo', 'cover', 'inside', 'outside'] as $singleKind) {
                if ($kinds->filter(fn ($kind) => $kind === $singleKind)->count() > 1) {
                    $validator->errors()->add('media', "Only one {$singleKind} photo can be submitted.");
                }
            }
            if ($kinds->filter(fn ($kind) => $kind === 'tin_certificate')->count() > 1) {
                $validator->errors()->add('media', 'Only one TIN certificate can be submitted.');
            }

            $serviceCatalog = collect(config('ops.onboarding_services', []))->keyBy('id');
            $total = 0.0;
            foreach ($this->input('invoice.services', []) as $index => $service) {
                if (! $serviceCatalog->has($service['service_id'] ?? null)) {
                    $validator->errors()->add("invoice.services.{$index}.service_id", 'The selected onboarding service is unavailable.');
                }
                $total += (float) ($service['quantity'] ?? 0) * (float) ($service['unit_price'] ?? 0);
            }
            if ($total <= 0) {
                $validator->errors()->add('invoice.services', 'Invoice total must be greater than zero.');
            }

            if ($validator->errors()->hasAny(['store.module_id', 'location.latitude', 'location.longitude', 'location.zone_id'])) {
                return;
            }
            $module = Module::query()->active()->commerce()->find($this->integer('store.module_id'));
            if (! $module) {
                return;
            }
            $zone = Zone::query()
                ->active()
                ->whereKey($this->integer('location.zone_id'))
                ->whereContains('coordinates', new Point(
                    (float) $this->input('location.latitude'),
                    (float) $this->input('location.longitude'),
                    POINT_SRID,
                ))
                ->when(! $module->all_zone_service, fn ($query) => $query->whereHas(
                    'modules',
                    fn ($moduleQuery) => $moduleQuery->where('modules.id', $module->id),
                ))
                ->first();
            if (! $zone) {
                $validator->errors()->add('location.zone_id', 'The selected location is not served by this business type.');
            }
        }];
    }

    private function isReplay(): bool
    {
        if ($this->replay !== null) {
            return $this->replay;
        }
        $manager = $this->attributes->get('ops_manager');
        $key = (string) $this->input('idempotency_key');
        $header = (string) $this->header('Idempotency-Key');
        if (! $manager || strlen($key) < 16 || $header === '' || ! hash_equals($key, $header)) {
            return $this->replay = false;
        }

        return $this->replay = OnboardingApplication::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('idempotency_key_hash', hash('sha256', $key))
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->exists();
    }
}
