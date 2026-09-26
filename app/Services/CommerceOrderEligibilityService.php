<?php

namespace App\Services;

use App\Models\BusinessSetting;
use App\Models\DeliveryMan;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class CommerceOrderEligibilityService
{
    public function availableQuery(DeliveryMan $deliveryMan, bool $applyCashLimit = true): Builder
    {
        $query = Order::query();

        if ((int) $deliveryMan->active !== 1
            || (int) $deliveryMan->current_orders >= (int) config('dm_maximum_orders')) {
            return $query->whereRaw('1 = 0');
        }

        if ($deliveryMan->work_mode !== 'delivery') {
            $query->where('order_type', 'parcel');
        }

        if ($deliveryMan->type === 'zone_wise') {
            $query->where('zone_id', $deliveryMan->zone_id)
                ->where(function (Builder $query) {
                    $query->whereNull('store_id')
                        ->orWhere(function (Builder $query) {
                            $query->whereHas('store', function (Builder $store) {
                                $store->where('store_business_model', 'subscription')
                                    ->whereHas('store_sub', fn (Builder $subscription) => $subscription->where('self_delivery', 0));
                            })->orWhereHas('store', function (Builder $store) {
                                $store->where('store_business_model', 'commission')
                                    ->where('self_delivery_system', 0);
                            });
                        });
                });
        } else {
            $query->where('store_id', $deliveryMan->store_id);
        }

        if (config('order_confirmation_model') === 'deliveryman' && $deliveryMan->type === 'zone_wise') {
            $query->whereIn('order_status', ['pending', 'confirmed', 'processing', 'handover']);
        } else {
            $query->where(function (Builder $query) {
                $query->whereIn('order_status', ['confirmed', 'processing', 'handover'])
                    ->orWhere(function (Builder $parcel) {
                        $parcel->where('order_type', 'parcel')
                            ->whereIn('order_status', ['pending', 'confirmed', 'processing', 'handover']);
                    });
            });
        }

        if ($deliveryMan->vehicle_id !== null) {
            $query->where('dm_vehicle_id', $deliveryMan->vehicle_id);
        }

        if ($applyCashLimit) {
            $this->applyCashLimit($query, $deliveryMan);
        }

        return $query->dmOrder()
            ->Notpos()
            ->NotDigitalOrder()
            ->where(fn (Builder $schedule) => $schedule->OrderScheduledIn(30))
            ->whereNull('delivery_man_id');
    }

    public function isAvailableTo(DeliveryMan $deliveryMan, Order $order, bool $applyCashLimit = true): bool
    {
        return $this->availableQuery($deliveryMan, $applyCashLimit)->whereKey($order->id)->exists();
    }

    public function exceedsCashLimit(DeliveryMan $deliveryMan, Order $order): bool
    {
        if (! $this->isCashOrder($order)) {
            return false;
        }

        return $this->cashInHand($deliveryMan) + (float) $order->order_amount >= $this->maximumCash();
    }

    public function maximumCash(): float
    {
        return (float) (BusinessSetting::query()->where('key', 'dm_max_cash_in_hand')->value('value') ?? 0);
    }

    private function applyCashLimit(Builder $query, DeliveryMan $deliveryMan): void
    {
        $remainingCashCapacity = $this->maximumCash() - $this->cashInHand($deliveryMan);

        $query->where(function (Builder $orders) use ($remainingCashCapacity) {
            $orders->where(function (Builder $nonCash) {
                $nonCash->where(fn (Builder $method) => $method
                    ->whereNull('payment_method')
                    ->orWhere('payment_method', '!=', 'cash_on_delivery'))
                    ->whereDoesntHave('payments', fn (Builder $payment) => $payment->where('payment_method', 'cash_on_delivery'));
            })->orWhere(function (Builder $cash) use ($remainingCashCapacity) {
                $cash->where(function (Builder $cashMethod) {
                    $cashMethod->where('payment_method', 'cash_on_delivery')
                        ->orWhereHas('payments', fn (Builder $payment) => $payment->where('payment_method', 'cash_on_delivery'));
                })->where('order_amount', '<', $remainingCashCapacity);
            });
        });
    }

    private function isCashOrder(Order $order): bool
    {
        return $order->payment_method === 'cash_on_delivery'
            || $order->payments()->where('payment_method', 'cash_on_delivery')->exists();
    }

    private function cashInHand(DeliveryMan $deliveryMan): float
    {
        return (float) ($deliveryMan->wallet?->collected_cash ?? 0);
    }
}
