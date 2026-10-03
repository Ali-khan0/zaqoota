<?php

namespace App\Services;

use App\Models\BusinessSetting;
use App\Models\QueueProcessStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class QueueProcessService
{
    public const MASTER_KEY = 'queue_processing_enabled';

    public function definitions(): array
    {
        return [
            'commerce_dispatch_wave' => [
                'label' => 'Commerce order dispatch waves',
                'description' => 'Opens nearest-first order and parcel rider waves.',
                'job' => 'DispatchCommerceOrderWave',
            ],
            'commerce_request_push' => [
                'label' => 'Commerce rider request push',
                'description' => 'Sends individual Firebase order and parcel requests.',
                'job' => 'SendCommerceOrderRequestPush',
            ],
            'ride_dispatch_wave' => [
                'label' => 'Passenger Ride dispatch waves',
                'description' => 'Opens nearest-first Ride discovery waves.',
                'job' => 'DispatchRideRequestWave',
            ],
            'ride_request_push' => [
                'label' => 'Passenger Ride request push',
                'description' => 'Sends individual Firebase Ride requests.',
                'job' => 'SendRideRequestPush',
            ],
            'ride_offer_expiry' => [
                'label' => 'Ride offer expiry',
                'description' => 'Expires unanswered Captain price offers at their deadline.',
                'job' => 'ExpireRideOffer',
            ],
            'driver_location_broadcast' => [
                'label' => 'Driver live-location broadcast',
                'description' => 'Broadcasts queued driver location updates to realtime clients.',
                'job' => 'DispatchDriverLocationJob',
            ],
            'ops_onboarding_submission_email' => [
                'label' => 'Ops onboarding registration and invoice email',
                'description' => 'Sends the partner registration message and onboarding invoice after submission.',
                'job' => 'SendOpsOnboardingSubmissionEmails',
            ],
            'ops_onboarding_reminder' => [
                'label' => 'Ops onboarding payment reminders',
                'description' => 'Sends manager-requested onboarding invoice payment reminders.',
                'job' => 'SendOpsOnboardingReminder',
            ],
            'ops_manager_notifications' => [
                'label' => 'Ops manager finance notifications',
                'description' => 'Sends commission and withdrawal status notifications to onboarding managers.',
                'job' => 'SendOpsManagerNotification',
            ],
            'ops_onboarding_payment_email' => [
                'label' => 'Ops onboarding payment confirmation email',
                'description' => 'Sends the paid onboarding invoice after verified settlement.',
                'job' => 'SendOpsOnboardingPaymentConfirmation',
            ],
            'ops_vendor_approval_email' => [
                'label' => 'Ops vendor approval and password setup email',
                'description' => 'Sends the approved partner a one-time expiring password setup link.',
                'job' => 'SendOpsVendorApprovalEmail',
            ],
        ];
    }

    public function statuses(): Collection
    {
        if (! Schema::hasTable('queue_process_statuses')) {
            return collect();
        }

        foreach (array_keys($this->definitions()) as $process) {
            QueueProcessStatus::query()->firstOrCreate(['process' => $process], ['enabled' => true]);
        }

        return QueueProcessStatus::query()->whereIn('process', array_keys($this->definitions()))
            ->get()->keyBy('process');
    }

    public function masterEnabled(): bool
    {
        $value = DB::table('business_settings')->where('key', self::MASTER_KEY)->value('value');

        return $value === null || (string) $value === '1';
    }

    public function enabled(string $process): bool
    {
        if (! $this->masterEnabled()) {
            return false;
        }
        if (! Schema::hasTable('queue_process_statuses')) {
            return true;
        }

        return (bool) QueueProcessStatus::query()->firstOrCreate(
            ['process' => $process],
            ['enabled' => true],
        )->enabled;
    }

    public function updateControls(bool $masterEnabled, array $enabledProcesses): void
    {
        BusinessSetting::query()->updateOrCreate(
            ['key' => self::MASTER_KEY],
            ['value' => $masterEnabled ? '1' : '0'],
        );

        foreach (array_keys($this->definitions()) as $process) {
            QueueProcessStatus::query()->updateOrCreate(
                ['process' => $process],
                ['enabled' => in_array($process, $enabledProcesses, true)],
            );
        }
    }

    public function recordProcessed(string $process): void
    {
        if (! Schema::hasTable('queue_process_statuses')) {
            return;
        }

        $status = QueueProcessStatus::query()->firstOrCreate(['process' => $process], ['enabled' => true]);
        $status->increment('processed_count', 1, ['last_processed_at' => now(), 'last_error' => null]);
    }

    public function recordFailed(string $process, Throwable $exception): void
    {
        if (! Schema::hasTable('queue_process_statuses')) {
            return;
        }

        $status = QueueProcessStatus::query()->firstOrCreate(['process' => $process], ['enabled' => true]);
        $status->increment('failed_count', 1, [
            'last_failed_at' => now(),
            'last_error' => (string) str($exception->getMessage())->limit(1000),
        ]);
    }

    public function recordSkipped(string $process): void
    {
        if (! Schema::hasTable('queue_process_statuses')) {
            return;
        }

        $status = QueueProcessStatus::query()->firstOrCreate(['process' => $process], ['enabled' => true]);
        $status->increment('skipped_count', 1, ['last_skipped_at' => now()]);
    }
}
