<?php

namespace App\Console\Commands;

use App\Services\DeliveryManMilestoneBonusService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessDmWeeklyMilestoneBonusesCommand extends Command
{
    protected $signature = 'dm:process-milestones-weekly {--date=}';

    protected $description = 'Award weekly delivery-man milestone bonuses for the week containing date (default: last week)';

    public function handle(DeliveryManMilestoneBonusService $service): int
    {
        $dateStr = $this->option('date');
        $ref = $dateStr ? Carbon::parse($dateStr) : Carbon::now()->subWeek();
        $n = $service->processWeekly($ref);
        $this->info("Awarded {$n} weekly milestone bonus(es) for week of ".$ref->copy()->startOfWeek()->toDateString());

        return self::SUCCESS;
    }
}
