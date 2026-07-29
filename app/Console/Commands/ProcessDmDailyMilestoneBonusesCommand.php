<?php

namespace App\Console\Commands;

use App\Services\DeliveryManMilestoneBonusService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessDmDailyMilestoneBonusesCommand extends Command
{
    protected $signature = 'dm:process-milestones-daily {--date=}';

    protected $description = 'Award daily delivery-man milestone bonuses for a completed day (default: yesterday)';

    public function handle(DeliveryManMilestoneBonusService $service): int
    {
        $dateStr = $this->option('date');
        $day = $dateStr ? Carbon::parse($dateStr) : Carbon::yesterday();
        $n = $service->processDaily($day);
        $this->info("Awarded {$n} daily milestone bonus(es) for ".$day->toDateString());

        return self::SUCCESS;
    }
}
