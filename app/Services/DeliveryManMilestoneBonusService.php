<?php

namespace App\Services;

use App\Models\DeliveryMan;
use App\Models\DeliveryManWallet;
use App\Models\DeliveryManWalletLedger;
use App\Models\DmBonusAward;
use App\Models\DmBonusMilestone;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DeliveryManMilestoneBonusService
{
    public function milestonesForApp(DeliveryMan $dm): array
    {
        $daily = DmBonusMilestone::where('period_type', 'daily')->where('status', true)->orderBy('slot')->get();
        $weekly = DmBonusMilestone::where('period_type', 'weekly')->where('status', true)->orderBy('slot')->get();

        $dayKey = $this->periodKeyDaily(Carbon::today());
        $weekKey = $this->periodKeyWeekly(Carbon::now());

        $dailyDelivered = $this->deliveredCountForDay($dm->id, Carbon::today());
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $weeklyDelivered = $this->deliveredCountForRange($dm->id, $weekStart, $weekEnd);

        return [
            'daily' => $this->mapMilestones($dm->id, $daily, $dayKey, $dailyDelivered),
            'weekly' => $this->mapMilestones($dm->id, $weekly, $weekKey, $weeklyDelivered),
            'counts' => [
                'today_delivered_orders' => $dailyDelivered,
                'this_week_delivered_orders' => $weeklyDelivered,
            ],
        ];
    }

    private function mapMilestones(int $dmId, $milestones, string $periodKey, int $delivered): array
    {
        $awardedIds = DmBonusAward::where('delivery_man_id', $dmId)
            ->where('period_key', $periodKey)
            ->pluck('dm_bonus_milestone_id')
            ->all();

        $out = [];
        foreach ($milestones as $m) {
            $unlocked = $delivered >= $m->orders_required;
            $paid = in_array($m->id, $awardedIds, true);
            $status = $paid ? 'paid' : ($unlocked ? 'unlocked_pending' : 'locked');
            $out[] = [
                'id' => $m->id,
                'slot' => $m->slot,
                'orders_required' => $m->orders_required,
                'bonus_amount' => (float) $m->bonus_amount,
                'current_delivered' => $delivered,
                'status' => $status,
            ];
        }

        return $out;
    }

    public function processDaily(Carbon $day): int
    {
        return $this->processPeriod('daily', $this->periodKeyDaily($day), $day->copy()->startOfDay(), $day->copy()->endOfDay());
    }

    public function processWeekly(Carbon $anyInWeek): int
    {
        $start = $anyInWeek->copy()->startOfWeek();
        $end = $anyInWeek->copy()->endOfWeek();
        $key = $this->periodKeyWeekly($anyInWeek);

        return $this->processPeriod('weekly', $key, $start, $end);
    }

    private function processPeriod(string $periodType, string $periodKey, Carbon $start, Carbon $end): int
    {
        $milestones = DmBonusMilestone::where('period_type', $periodType)->where('status', true)->orderBy('orders_required')->get();
        if ($milestones->isEmpty()) {
            return 0;
        }

        $dmIds = DeliveryMan::query()
            ->where('application_status', 'approved')
            ->where('type', 'zone_wise')
            ->pluck('id');

        $paid = 0;

        foreach ($dmIds as $dmId) {
            $count = $this->deliveredCountForRange((int) $dmId, $start, $end);
            foreach ($milestones as $m) {
                if ($count < $m->orders_required) {
                    continue;
                }

                $exists = DmBonusAward::where('delivery_man_id', $dmId)
                    ->where('dm_bonus_milestone_id', $m->id)
                    ->where('period_key', $periodKey)
                    ->exists();
                if ($exists) {
                    continue;
                }

                DB::transaction(function () use ($dmId, $m, $periodKey, $count, &$paid) {
                    $amount = (float) $m->bonus_amount;
                    if ($amount <= 0) {
                        return;
                    }

                    $wallet = DeliveryManWallet::firstOrNew(['delivery_man_id' => $dmId]);
                    $wallet->total_earning = ($wallet->total_earning ?? 0) + $amount;
                    $wallet->save();

                    $ledgerType = $m->period_type === 'daily'
                        ? DeliveryManWalletLedger::TYPE_MILESTONE_BONUS_DAILY
                        : DeliveryManWalletLedger::TYPE_MILESTONE_BONUS_WEEKLY;

                    DeliveryManWalletLedger::create([
                        'delivery_man_id' => $dmId,
                        'transaction_type' => $ledgerType,
                        'reference' => 'milestone_'.$m->id,
                        'amount' => $amount,
                        'direction' => DeliveryManWalletLedger::DIR_CREDIT,
                        'meta' => [
                            'milestone_id' => $m->id,
                            'period_key' => $periodKey,
                            'delivered_count' => $count,
                        ],
                    ]);

                    DmBonusAward::create([
                        'delivery_man_id' => $dmId,
                        'dm_bonus_milestone_id' => $m->id,
                        'period_key' => $periodKey,
                        'delivered_count' => $count,
                        'amount' => $amount,
                        'awarded_at' => now(),
                    ]);
                    $paid++;
                });
            }
        }

        return $paid;
    }

    public function deliveredCountForDay(int $dmId, Carbon $day): int
    {
        return $this->deliveredCountForRange($dmId, $day->copy()->startOfDay(), $day->copy()->endOfDay());
    }

    public function deliveredCountForRange(int $dmId, Carbon $start, Carbon $end): int
    {
        return (int) Order::query()
            ->where('delivery_man_id', $dmId)
            ->where('order_status', 'delivered')
            ->whereBetween('updated_at', [$start, $end])
            ->count();
    }

    public function periodKeyDaily(Carbon $day): string
    {
        return 'd_'.$day->format('Y-m-d');
    }

    public function periodKeyWeekly(Carbon $date): string
    {
        return 'w_'.$date->format('o').'_W'.$date->format('W');
    }
    
    /**
     * Summary from rider join date through today (capped at end of current month for the period label).
     * History: recent days (newest first), skipping idle days, capped for payload size.
     *
     * @return array{summary: array<string, mixed>, history: array<int, array<string, mixed>>}
     */
    public function buildBonusSummaryWithHistory(DeliveryMan $dm, int $historyMaxRows = 90): array
    {
        $rangeStart = Carbon::parse($dm->created_at)->startOfDay();
        $now = Carbon::now();
        $rangeEnd = $now->copy()->endOfDay();

        $periodLabel = $now->copy()->locale(str_replace('_', '-', app()->getLocale()))->translatedFormat('F Y');

        $milestoneTypes = [
            DeliveryManWalletLedger::TYPE_MILESTONE_BONUS_DAILY,
            DeliveryManWalletLedger::TYPE_MILESTONE_BONUS_WEEKLY,
        ];

        $totalBonusEarned = (float) DeliveryManWalletLedger::query()
            ->where('delivery_man_id', $dm->id)
            ->whereIn('transaction_type', $milestoneTypes)
            ->where('direction', DeliveryManWalletLedger::DIR_CREDIT)
            ->whereBetween('created_at', [$rangeStart, $rangeEnd])
            ->sum('amount');

        $totalOrdersCompleted = (int) Order::query()
            ->where('delivery_man_id', $dm->id)
            ->where('order_status', 'delivered')
            ->whereBetween('updated_at', [$rangeStart, $rangeEnd])
            ->count();

        $totalQuestsHit = (int) DmBonusAward::query()
            ->where('delivery_man_id', $dm->id)
            ->whereNotNull('awarded_at')
            ->whereBetween('awarded_at', [$rangeStart, $rangeEnd])
            ->count();

        $dailyMilestones = DmBonusMilestone::query()
            ->where('period_type', 'daily')
            ->where('status', true)
            ->orderBy('orders_required')
            ->get();

        $orderCountsByDay = Order::query()
            ->where('delivery_man_id', $dm->id)
            ->where('order_status', 'delivered')
            ->whereBetween('updated_at', [$rangeStart, $rangeEnd])
            ->selectRaw('DATE(updated_at) as day_date, COUNT(*) as cnt')
            ->groupByRaw('DATE(updated_at)')
            ->pluck('cnt', 'day_date');

        $dailyKeyMin = 'd_'.$rangeStart->format('Y-m-d');
        $dailyKeyMax = 'd_'.$rangeEnd->format('Y-m-d');

        $allAwards = DmBonusAward::query()
            ->where('delivery_man_id', $dm->id)
            ->where(function ($q) use ($rangeStart, $rangeEnd, $dailyKeyMin, $dailyKeyMax) {
                $q->whereBetween('awarded_at', [$rangeStart, $rangeEnd])
                    ->orWhere(function ($q2) use ($dailyKeyMin, $dailyKeyMax) {
                        $q2->where('period_key', '>=', $dailyKeyMin)
                            ->where('period_key', '<=', $dailyKeyMax);
                    });
            })
            ->with('milestone')
            ->get();

        $awardsByDailyKey = $allAwards->groupBy('period_key');

        $history = [];
        $locale = str_replace('_', '-', app()->getLocale());

        for ($day = $now->copy()->startOfDay(); $day->gte($rangeStart) && count($history) < $historyMaxRows; $day->subDay()) {
            $dateStr = $day->format('Y-m-d');
            $ordersCompleted = (int) ($orderCountsByDay[$dateStr] ?? 0);

            $milestonesReached = [];
            $expectedDaily = 0.0;
            $qualifiedIds = [];
            foreach ($dailyMilestones as $m) {
                if ($ordersCompleted >= $m->orders_required) {
                    $milestonesReached[] = $m->orders_required.'_orders';
                    $expectedDaily += (float) $m->bonus_amount;
                    $qualifiedIds[] = $m->id;
                }
            }

            $dayKey = $this->periodKeyDaily($day);
            /** @var Collection<int, DmBonusAward> $awardsForDailyKey */
            $awardsForDailyKey = $awardsByDailyKey->get($dayKey, collect());
            $dailyAwardSum = (float) $awardsForDailyKey->sum('amount');

            $awardedIds = $awardsForDailyKey->pluck('dm_bonus_milestone_id')->unique()->all();
            $dailyPaid = $qualifiedIds === [] || count(array_diff($qualifiedIds, $awardedIds)) === 0;

            $weeklySum = (float) $allAwards->filter(function (DmBonusAward $a) use ($dateStr) {
                if (! $a->awarded_at || ! $a->milestone || $a->milestone->period_type !== 'weekly') {
                    return false;
                }

                return $a->awarded_at->format('Y-m-d') === $dateStr;
            })->sum('amount');

            $bonusAmount = $dailyPaid ? ($dailyAwardSum + $weeklySum) : ($expectedDaily + $weeklySum);
            $bonusAmount = round($bonusAmount, 2);

            if ($ordersCompleted === 0 && $milestonesReached === [] && $bonusAmount <= 0) {
                continue;
            }

            $dayForName = $day->copy()->locale($locale);
            $history[] = [
                'date' => $dateStr,
                'day_name' => $dayForName->translatedFormat('l'),
                'orders_completed' => $ordersCompleted,
                'bonus_amount' => $bonusAmount,
                'is_paid' => $dailyPaid,
                'milestones_reached' => $milestonesReached,
            ];
        }

        return [
            'summary' => [
                'period' => $periodLabel,
                'total_bonus_earned' => round($totalBonusEarned, 2),
                'total_orders_completed' => $totalOrdersCompleted,
                'total_quests_hit' => $totalQuestsHit,
            ],
            'history' => $history,
        ];
    }
}
