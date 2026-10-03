<?php

namespace App\Services;

use App\CentralLogics\StoreLogic;
use App\Jobs\SendOpsOnboardingSubmissionEmails;
use App\Models\Admin;
use App\Models\Module;
use App\Models\OnboardingApplication;
use App\Models\OnboardingApplicationMedia;
use App\Models\Store;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OpsOnboardingSubmissionService
{
    public function __construct(
        private readonly OnboardingInvoiceCreationService $invoiceService,
        private readonly OpsOnboardingMediaService $mediaService,
        private readonly OpsManagerFinanceService $financeService,
    ) {}

    public function submit(Admin $manager, array $data): array
    {
        $hash = hash('sha256', $data['idempotency_key']);
        $existing = $this->processedApplication($manager, $hash);
        if ($existing) {
            return $this->receipt($existing, true);
        }

        $assets = $this->mediaService->prepareStoreAssets($manager, $data['media']);
        $alreadyProcessed = false;
        try {
            $application = DB::transaction(function () use ($manager, $data, $hash, $assets, &$alreadyProcessed): OnboardingApplication {
                Admin::query()->whereKey($manager->id)->lockForUpdate()->firstOrFail();
                $existing = $this->processedApplication($manager, $hash, true);
                if ($existing) {
                    $alreadyProcessed = true;

                    return $existing;
                }

                $application = $this->draftApplication($manager, $data);
                $module = Module::query()->active()->commerce()->notParcel()->findOrFail($data['store']['module_id']);
                $media = $this->submissionMedia($manager, $application, $data['media']);
                $vendor = $this->createVendor($data['owner']);
                $store = $this->createStore($vendor, $module, $data, $assets);
                $managerName = trim($manager->f_name.' '.$manager->l_name) ?: $manager->email;

                $application->update([
                    'idempotency_key_hash' => $hash,
                    'vendor_id' => $vendor->id,
                    'store_id' => $store->id,
                    'module_id' => $module->id,
                    'zone_id' => $data['location']['zone_id'],
                    'manager_name_snapshot' => $managerName,
                    'manager_email_snapshot' => $manager->email,
                    'commission_rate_snapshot' => $manager->onboarding_commission_percent,
                    'currency' => 'PKR',
                    'owner_first_name' => trim($data['owner']['first_name']),
                    'owner_last_name' => trim((string) ($data['owner']['last_name'] ?? '')) ?: null,
                    'owner_email' => $data['owner']['email'],
                    'owner_phone' => $data['owner']['phone'],
                    'owner_tin' => $data['owner']['tin'] ?? null,
                    'owner_tin_expire_date' => $this->optionalDate($data['owner']['tin_expiry'] ?? null),
                    'owner_tin_certificate_path' => $assets['tin_certificate_path'] ?? null,
                    'store_name' => $store->name,
                    'store_phone' => $store->phone,
                    'store_email' => $store->email,
                    'module_name_snapshot' => $module->module_name,
                    'zone_name_snapshot' => $store->zone?->name,
                    'formatted_address' => $store->address,
                    'latitude' => $store->latitude,
                    'longitude' => $store->longitude,
                    'place_id' => $data['location']['place_id'],
                    'delivery_time_min' => $data['store']['minimum_delivery_time'],
                    'delivery_time_max' => $data['store']['maximum_delivery_time'],
                    'delivery_time_unit' => $data['store']['delivery_time_type'],
                ]);

                foreach ($data['media'] as $submittedMedia) {
                    $record = $media->firstWhere('id', (int) $submittedMedia['id']);
                    $record->update([
                        'onboarding_application_id' => $application->id,
                        'draft_key' => null,
                        'sort_order' => $submittedMedia['position'],
                        'status' => OnboardingApplicationMedia::STATUS_ATTACHED,
                    ]);
                }

                $catalog = collect(config('ops.onboarding_services', []))->keyBy('id');
                $items = collect($data['invoice']['services'])->map(fn (array $service) => [
                    'description' => $catalog->get($service['service_id'])['description'],
                    'quantity' => $service['quantity'],
                    'unit_price' => $service['unit_price'],
                ])->all();
                $invoice = $this->invoiceService->create(
                    store: $store->loadMissing('vendor'),
                    module: $module,
                    items: $items,
                    attributes: [
                        'invoice_type' => 'onboarding',
                        'invoice_date' => today(),
                        'due_date' => Carbon::createFromFormat('d/m/Y', $data['invoice']['due_date'])->startOfDay(),
                        'public_note' => $data['invoice']['note'] ?? null,
                        'private_note' => null,
                        'recipient_emails' => [],
                        'payment_status' => 'unpaid',
                        'send_status' => 'not_sent',
                    ],
                    actor: $manager,
                    application: $application,
                );
                $commissionBase = (float) $invoice->amount;
                $commissionRate = (float) $manager->onboarding_commission_percent;
                $application->update([
                    'status' => OnboardingApplication::STATUS_PAYMENT_PENDING,
                    'draft_payload' => null,
                    'commission_base_snapshot' => $commissionBase,
                    'commission_amount_snapshot' => round($commissionBase * $commissionRate / 100, 2),
                    'submitted_at' => now(),
                ]);
                $this->financeService->recordSubmission($application, $invoice);
                $application->statusHistory()->create([
                    'from_status' => OnboardingApplication::STATUS_DRAFT,
                    'to_status' => OnboardingApplication::STATUS_PAYMENT_PENDING,
                    'actor_type' => 'onboarding_manager',
                    'actor_id' => $manager->id,
                    'actor_name' => $managerName,
                    'note' => 'Application submitted and onboarding invoice created.',
                    'metadata' => ['invoice_id' => $invoice->id],
                ]);

                return $application->fresh(['invoice']);
            }, 3);
        } catch (\Throwable $exception) {
            $this->mediaService->discardStoreAssets($assets);
            throw $exception;
        }

        if ($alreadyProcessed) {
            $this->mediaService->discardStoreAssets($assets);
        }

        if (! $alreadyProcessed && $application->invoice) {
            SendOpsOnboardingSubmissionEmails::dispatch($application->id);
        }

        return $this->receipt($application, $alreadyProcessed);
    }

    public function receipt(OnboardingApplication $application, bool $alreadyProcessed): array
    {
        $application->loadMissing('invoice');

        return [
            'status' => 'completed',
            'application_id' => $application->id,
            'invoice_id' => $application->invoice?->id,
            'vendor_email' => $application->owner_email,
            'already_processed' => $alreadyProcessed,
        ];
    }

    private function processedApplication(Admin $manager, string $hash, bool $lock = false): ?OnboardingApplication
    {
        return OnboardingApplication::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('idempotency_key_hash', $hash)
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->when($lock, fn ($query) => $query->lockForUpdate())
            ->with('invoice')
            ->first();
    }

    private function draftApplication(Admin $manager, array $data): OnboardingApplication
    {
        if (! empty($data['draft_id'])) {
            $application = OnboardingApplication::query()
                ->where('onboarding_manager_id', $manager->id)
                ->where('status', OnboardingApplication::STATUS_DRAFT)
                ->lockForUpdate()
                ->find($data['draft_id']);
            if (! $application) {
                throw ValidationException::withMessages(['draft_id' => ['The registration draft is unavailable or does not belong to this account.']]);
            }
            if ((int) $application->draft_revision !== (int) $data['draft_revision']) {
                throw ValidationException::withMessages(['draft_revision' => ['The registration draft changed. Reload it before submitting.']]);
            }

            return $application;
        }

        return OnboardingApplication::create([
            'reference' => 'OPS-'.Str::upper((string) Str::ulid()),
            'onboarding_manager_id' => $manager->id,
            'status' => OnboardingApplication::STATUS_DRAFT,
            'draft_revision' => max(1, (int) $data['draft_revision']),
        ]);
    }

    private function submissionMedia(Admin $manager, OnboardingApplication $application, array $submitted): \Illuminate\Support\Collection
    {
        $ids = collect($submitted)->pluck('id')->map(fn ($id) => (int) $id)->all();
        $records = OnboardingApplicationMedia::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', OnboardingApplicationMedia::STATUS_TEMPORARY)
            ->where(function ($query) use ($application) {
                $query->whereNull('onboarding_application_id')
                    ->orWhere('onboarding_application_id', $application->id);
            })
            ->whereIn('id', $ids)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
        if ($records->count() !== count($ids)) {
            throw ValidationException::withMessages(['media' => ['One or more uploaded photos are unavailable. Upload them again before submitting.']]);
        }
        $collectionByKind = [
            'logo' => OnboardingApplicationMedia::COLLECTION_LOGO,
            'cover' => OnboardingApplicationMedia::COLLECTION_COVER,
            'inside' => OnboardingApplicationMedia::COLLECTION_VENUE_INSIDE,
            'outside' => OnboardingApplicationMedia::COLLECTION_VENUE_OUTSIDE,
            'menu' => OnboardingApplicationMedia::COLLECTION_MENU,
            'tin_certificate' => OnboardingApplicationMedia::COLLECTION_TIN_CERTIFICATE,
        ];
        foreach ($submitted as $item) {
            if ($records[(int) $item['id']]->collection !== $collectionByKind[$item['kind']]) {
                throw ValidationException::withMessages(['media' => ['An uploaded photo type does not match the submitted form.']]);
            }
        }

        return $records;
    }

    private function createVendor(array $owner): Vendor
    {
        $emailExists = Vendor::query()->where('email', $owner['email'])->lockForUpdate()->exists();
        $phoneExists = Vendor::query()->where('phone', $owner['phone'])->lockForUpdate()->exists();
        if ($emailExists || $phoneExists) {
            throw ValidationException::withMessages(array_filter([
                'owner.email' => $emailExists ? ['This email is already registered.'] : null,
                'owner.phone' => $phoneExists ? ['This phone number is already registered.'] : null,
            ]));
        }

        return Vendor::create([
            'f_name' => trim($owner['first_name']),
            'l_name' => trim((string) ($owner['last_name'] ?? '')) ?: null,
            'email' => $owner['email'],
            'phone' => $owner['phone'],
            'password' => Hash::make(Str::random(24).'!Aa1'),
            'status' => null,
        ]);
    }

    private function createStore(Vendor $vendor, Module $module, array $data, array $assets): Store
    {
        $store = new Store;
        $store->name = trim($data['store']['name']);
        $store->phone = $data['owner']['phone'];
        $store->email = $data['owner']['email'];
        $store->logo = $assets['logo'];
        $store->cover_photo = $assets['cover'];
        $store->address = trim($data['location']['address']);
        $store->latitude = $data['location']['latitude'];
        $store->longitude = $data['location']['longitude'];
        $store->vendor_id = $vendor->id;
        $store->zone_id = $data['location']['zone_id'];
        $store->module_id = $module->id;
        $store->pickup_zone_id = json_encode([]);
        $store->tin = $data['owner']['tin'] ?? null;
        $store->tin_expire_date = $this->optionalDate($data['owner']['tin_expiry'] ?? null);
        $store->tin_certificate_image = $assets['tin_certificate'] ?? null;
        $store->delivery_time = $data['store']['minimum_delivery_time'].'-'.$data['store']['maximum_delivery_time'].' '.$data['store']['delivery_time_type'];
        $store->status = 0;
        $store->store_business_model = 'commission';
        $store->save();
        if ((bool) config('module.'.$module->module_type.'.always_open', false)) {
            StoreLogic::insert_schedule($store->id);
        }

        return $store->loadMissing('zone');
    }

    private function optionalDate(?string $value): ?Carbon
    {
        return $value ? Carbon::createFromFormat('d/m/Y', $value)->startOfDay() : null;
    }
}
