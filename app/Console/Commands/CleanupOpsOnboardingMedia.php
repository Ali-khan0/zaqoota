<?php

namespace App\Console\Commands;

use App\Services\OpsOnboardingMediaService;
use App\Services\OpsOnboardingPaymentService;
use Illuminate\Console\Command;

class CleanupOpsOnboardingMedia extends Command
{
    protected $signature = 'ops:cleanup-onboarding-media {--hours=}';

    protected $description = 'Delete abandoned temporary Zaqoota Ops onboarding media and payment proofs';

    public function handle(
        OpsOnboardingMediaService $mediaService,
        OpsOnboardingPaymentService $paymentService,
    ): int {
        $hours = $this->option('hours') !== null
            ? max(1, (int) $this->option('hours'))
            : max(1, (int) config('ops.media.orphan_after_hours', 720));
        $mediaDeleted = $mediaService->cleanupOrphans($hours);
        $proofsDeleted = $paymentService->cleanupOrphanedProofs($hours);
        $this->info("Deleted {$mediaDeleted} abandoned onboarding media file(s) and {$proofsDeleted} payment proof(s).");

        return self::SUCCESS;
    }
}
