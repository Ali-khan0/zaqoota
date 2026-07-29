<?php

namespace App\Console\Commands;

use App\Services\DeliveryManRegistrationFeeService;
use Illuminate\Console\Command;

class DeductDeliveryManRegistrationFeesCommand extends Command
{
    protected $signature = 'dm:deduct-registration-fees';

    protected $description = 'Apply scheduled wallet deductions for delivery man registration fees';

    public function handle(DeliveryManRegistrationFeeService $service): int
    {
        $n = $service->runScheduledDeductions();
        $this->info("Processed {$n} deduction(s).");

        return self::SUCCESS;
    }
}
